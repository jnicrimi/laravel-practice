<?php

declare(strict_types=1);

namespace Packages\Application\Comic;

use Packages\Domain\Comic\ComicId;
use Packages\Domain\Comic\ComicRepositoryInterface;
use Packages\UseCase\Comic\Exception\ComicNotFoundException;
use Packages\UseCase\Comic\Show\ComicShowRequest;
use Packages\UseCase\Comic\Show\ComicShowResponse;
use Packages\UseCase\Comic\Show\ComicShowUseCaseInterface;

class ComicShowInteractor implements ComicShowUseCaseInterface
{
    /**
     * @param ComicRepositoryInterface $comicRepository
     */
    public function __construct(private readonly ComicRepositoryInterface $comicRepository)
    {
    }

    /**
     * @param ComicShowRequest $request
     *
     * @throws ComicNotFoundException
     *
     * @return ComicShowResponse
     */
    public function handle(ComicShowRequest $request): ComicShowResponse
    {
        $comicId = new ComicId($request->getId());
        $comicEntity = $this->comicRepository->find($comicId);
        if ($comicEntity === null) {
            throw new ComicNotFoundException('Comic not found');
        }
        $response = new ComicShowResponse();
        $response->setComic($comicEntity);

        return $response;
    }
}
