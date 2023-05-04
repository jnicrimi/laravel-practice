<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
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
     * @return array
     */
    public function index(ComicIndexUseCaseInterface $interactor): array
    {
        $response = $interactor->handle();

        return $response->build();
    }

    /**
     * @param ComicShowUseCaseInterface $interactor
     * @param int $comicId
     *
     * @return array
     */
    public function show(ComicShowUseCaseInterface $interactor, int $comicId): array
    {
        $comicRequest = new ComicShowRequest($comicId);

        try {
            $response = $interactor->handle($comicRequest);
        } catch (ComicNotFoundException $ex) {
            abort(Response::HTTP_NOT_FOUND);
        }

        return $response->build();
    }
}
