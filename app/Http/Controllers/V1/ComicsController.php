<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Errors\ComicError;
use App\Http\Errors\CommonError;
use App\Http\Requests\V1\Comic\CreateFormRequest;
use App\Http\Requests\V1\Comic\ShowFormRequest;
use App\Http\Resources\ErrorResource;
use App\Http\Resources\V1\Comic\CreateResource;
use App\Http\Resources\V1\Comic\IndexResource;
use App\Http\Resources\V1\Comic\ShowResource;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use InvalidArgumentException;
use Packages\UseCase\Comic\Create\ComicCreateRequest;
use Packages\UseCase\Comic\Create\ComicCreateUseCaseInterface;
use Packages\UseCase\Comic\Exception\ComicDuplicateException;
use Packages\UseCase\Comic\Exception\ComicNotFoundException;
use Packages\UseCase\Comic\Index\ComicIndexUseCaseInterface;
use Packages\UseCase\Comic\Show\ComicShowRequest;
use Packages\UseCase\Comic\Show\ComicShowUseCaseInterface;
use TypeError;

class ComicsController extends Controller
{
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
                'code' => ComicError::ComicNotFound->code(),
                'message' => ComicError::ComicNotFound->message(),
                'errors' => [],
            ]);

            return $errorResource->response()->setStatusCode(Response::HTTP_NOT_FOUND);
        } catch (TypeError $ex) {
            $errorResource = new ErrorResource([
                'code' => CommonError::InvalidArgument->code(),
                'message' => CommonError::InvalidArgument->message(),
                'errors' => [],
            ]);

            return $errorResource->response()->setStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (InvalidArgumentException $ex) {
            $errorResource = new ErrorResource([
                'code' => CommonError::InvalidArgument->code(),
                'message' => CommonError::InvalidArgument->message(),
                'errors' => [],
            ]);

            return $errorResource->response()->setStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (Exception $ex) {
            $errorResource = new ErrorResource([
                'code' => CommonError::InternalServerError->code(),
                'message' => CommonError::InternalServerError->message(),
                'errors' => [],
            ]);

            return $errorResource->response()->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return new ShowResource($response->build());
    }

    /**
     * @param ComicCreateUseCaseInterface $interactor
     * @param CreateFormRequest $formRequest
     *
     * @return CreateResource|JsonResponse
     */
    public function create(
        ComicCreateUseCaseInterface $interactor,
        CreateFormRequest $formRequest
    ): CreateResource|JsonResponse {
        try {
            $request = new ComicCreateRequest();
            $request->setKey($formRequest->input('key'))
                ->setName($formRequest->input('name'))
                ->setStatus($formRequest->input('status'));
            $response = $interactor->handle($request);
        } catch (ComicDuplicateException $ex) {
            $errorResource = new ErrorResource([
                'code' => ComicError::ComicDuplicate->code(),
                'message' => ComicError::ComicDuplicate->message(),
                'errors' => [],
            ]);

            return $errorResource->response()->setStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (TypeError $ex) {
            $errorResource = new ErrorResource([
                'code' => CommonError::InvalidArgument->code(),
                'message' => CommonError::InvalidArgument->message(),
                'errors' => [],
            ]);

            return $errorResource->response()->setStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (InvalidArgumentException $ex) {
            $errorResource = new ErrorResource([
                'code' => CommonError::InvalidArgument->code(),
                'message' => CommonError::InvalidArgument->message(),
                'errors' => [],
            ]);

            return $errorResource->response()->setStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (Exception $ex) {
            $errorResource = new ErrorResource([
                'code' => CommonError::InternalServerError->code(),
                'message' => CommonError::InternalServerError->message(),
                'errors' => [],
            ]);

            return $errorResource->response()->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return new CreateResource($response->build());
    }
}
