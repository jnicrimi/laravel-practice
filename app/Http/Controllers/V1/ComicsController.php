<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
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
        $response = $interactor->handle($comicRequest);

        return [
            'comicId' => $response->getComicId(),
            'key' => $response->getKey(),
            'name' => $response->getName(),
        ];
    }
}
