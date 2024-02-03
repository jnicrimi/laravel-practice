<?php

declare(strict_types=1);

namespace Packages\Application\Comic;

use Packages\Domain\Comic\Comic;
use Packages\Domain\Comic\ComicId;
use Packages\Domain\Comic\ComicKey;
use Packages\Domain\Comic\ComicName;
use Packages\Domain\Comic\ComicRepositoryInterface;
use Packages\Domain\Comic\ComicStatus;
use Packages\UseCase\Comic\Exception\ComicAlreadyExistsException;
use Packages\UseCase\Comic\Exception\ComicNotFoundException;
use Packages\UseCase\Comic\Update\ComicUpdateRequest;
use Packages\UseCase\Comic\Update\ComicUpdateResponse;
use Packages\UseCase\Comic\Update\ComicUpdateUseCaseInterface;

class ComicUpdateInteractor implements ComicUpdateUseCaseInterface
{
    /**
     * Constructor
     *
     * @param ComicRepositoryInterface $comicRepository
     */
    public function __construct(private readonly ComicRepositoryInterface $comicRepository)
    {
    }

    /**
     * @param ComicUpdateRequest $request
     *
     * @throws ComicNotFoundException
     * @throws ComicAlreadyExistsException
     *
     * @return ComicUpdateResponse
     */
    public function handle(ComicUpdateRequest $request): ComicUpdateResponse
    {
        if ($this->existComic($request) === false) {
            throw new ComicNotFoundException('Comic not found');
        }
        if ($this->isDuplicateKey($request) === true) {
            throw new ComicAlreadyExistsException('Duplicate key');
        }
        $comic = $this->updateComic($request);
        $response = new ComicUpdateResponse();
        $response->setComic($comic);

        return $response;
    }

    /**
     * @param ComicUpdateRequest $request
     *
     * @return bool
     */
    private function existComic(ComicUpdateRequest $request): bool
    {
        $comicId = new ComicId($request->getId());
        $comicEntity = $this->comicRepository->find($comicId);
        if ($comicEntity === null) {
            return false;
        }

        return true;
    }

    /**
     * @param ComicUpdateRequest $request
     *
     * @return bool
     */
    private function isDuplicateKey(ComicUpdateRequest $request): bool
    {
        $ignoreComicId = new ComicId($request->getId());
        $comicKey = new ComicKey($request->getKey());
        $comicEntity = $this->comicRepository->findByKey($comicKey, $ignoreComicId);
        if ($comicEntity === null) {
            return false;
        }

        return true;
    }

    /**
     * @param ComicUpdateRequest $request
     *
     * @return Comic
     */
    private function updateComic(ComicUpdateRequest $request): Comic
    {
        $entity = new Comic(
            new ComicId($request->getId()),
            new ComicKey($request->getKey()),
            new ComicName($request->getName()),
            ComicStatus::from($request->getStatus()),
            null,
            null
        );
        $comic = $this->comicRepository->update($entity);

        return $comic;
    }
}
