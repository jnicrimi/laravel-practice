<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Comic\ShowFormRequest;
use App\Http\Resources\ErrorResource;
use App\Http\Resources\V1\Comic\IndexResource;
use App\Http\Resources\V1\Comic\ShowResource;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use InvalidArgumentException;
use Packages\UseCase\Comic\Exception\ComicNotFoundException;
use Packages\UseCase\Comic\Index\ComicIndexUseCaseInterface;
use Packages\UseCase\Comic\Show\ComicShowRequest;
use Packages\UseCase\Comic\Show\ComicShowUseCaseInterface;
use TypeError;

class ComicsController extends Controller
{
    /**
     * @var string
     */
    public const ERROR_CODE_COMIC_NOT_FOUND = 'comic-not-found';

    /**
     * @var string
     */
    public const ERROR_CODE_INVALID_ARGUMENT = 'invalid-argument';

    /**
     * @var string
     */
    public const ERROR_CODE_INTERNAL_SERVER_ERROR = 'internal-server-error';

    /**
     * @var array<string, string>
     */
    public const ERROR_MESSAGES = [
        self::ERROR_CODE_COMIC_NOT_FOUND => 'Comic not found.',
        self::ERROR_CODE_INVALID_ARGUMENT => 'Invalid argument.',
        self::ERROR_CODE_INTERNAL_SERVER_ERROR => 'Internal server error.',
    ];

    /**
     * @param ComicIndexUseCaseInterface $interactor
     *
     * @return IndexResource
     */
    public function index(ComicIndexUseCaseInterface $interactor): IndexResource
    {
        $response = $interactor->handle();

        return new IndexResource($response->build());
    }

    /**
     * @param ComicShowUseCaseInterface $interactor
     * @param ShowFormRequest $formRequest
     * @param mixed $comicId
     *
     * @return ShowResource|JsonResponse
     */
    public function show(
        ComicShowUseCaseInterface $interactor,
        ShowFormRequest $formRequest,
        mixed $comicId
    ): ShowResource|JsonResponse {
        try {
            $request = new ComicShowRequest();
            $request->setComicId((int) $comicId);
            $response = $interactor->handle($request);
        } catch (ComicNotFoundException $ex) {
            $errorResource = new ErrorResource([
                'code' => self::ERROR_CODE_COMIC_NOT_FOUND,
                'message' => Arr::get(self::ERROR_MESSAGES, self::ERROR_CODE_COMIC_NOT_FOUND),
                'errors' => [],
            ]);

            return $errorResource->response()->setStatusCode(Response::HTTP_NOT_FOUND);
        } catch (TypeError $ex) {
            $errorResource = new ErrorResource([
                'code' => self::ERROR_CODE_INVALID_ARGUMENT,
                'message' => Arr::get(self::ERROR_MESSAGES, self::ERROR_CODE_INVALID_ARGUMENT),
                'errors' => [],
            ]);

            return $errorResource->response()->setStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (InvalidArgumentException $ex) {
            $errorResource = new ErrorResource([
                'code' => self::ERROR_CODE_INVALID_ARGUMENT,
                'message' => Arr::get(self::ERROR_MESSAGES, self::ERROR_CODE_INVALID_ARGUMENT),
                'errors' => [],
            ]);

            return $errorResource->response()->setStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (Exception $ex) {
            $errorResource = new ErrorResource([
                'code' => self::ERROR_CODE_INTERNAL_SERVER_ERROR,
                'message' => Arr::get(self::ERROR_MESSAGES, self::ERROR_CODE_INTERNAL_SERVER_ERROR),
                'errors' => [],
            ]);

            return $errorResource->response()->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return new ShowResource($response->build());
    }
}
