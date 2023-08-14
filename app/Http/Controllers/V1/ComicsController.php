<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Comic\V1\IndexResource;
use App\Http\Resources\Comic\V1\ShowResource;
use Exception;
use Illuminate\Http\Response;
use InvalidArgumentException;
use Packages\UseCase\Comic\Exception\ComicNotFoundException;
use Packages\UseCase\Comic\Index\ComicIndexUseCaseInterface;
use Packages\UseCase\Comic\Show\ComicShowRequest;
use Packages\UseCase\Comic\Show\ComicShowUseCaseInterface;

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
     * @param int $comicId
     *
     * @return ShowResource
     */
    public function show(ComicShowUseCaseInterface $interactor, int $comicId): ShowResource
    {
        try {
            $comicRequest = new ComicShowRequest($comicId);
            $response = $interactor->handle($comicRequest);
        } catch (ComicNotFoundException $ex) {
            abort(Response::HTTP_NOT_FOUND);
        } catch (InvalidArgumentException $ex) {
            abort(Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (Exception $ex) {
            abort(Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return new ShowResource($response->build());
    }
}
