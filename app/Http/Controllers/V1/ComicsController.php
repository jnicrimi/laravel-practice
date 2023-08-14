<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Comic\V1\IndexResource;
use App\Http\Resources\Comic\V1\ShowResource;
use Illuminate\Http\Response;
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
        $comicRequest = new ComicShowRequest($comicId);

        try {
            $response = $interactor->handle($comicRequest);
        } catch (ComicNotFoundException $ex) {
            abort(Response::HTTP_NOT_FOUND);
        }

        return new ShowResource($response->build());
    }
}
