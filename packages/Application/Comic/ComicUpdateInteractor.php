<?php

declare(strict_types=1);

namespace Packages\Application\Comic;

use Packages\Domain\Comic\Comic;
use Packages\Domain\Comic\ComicId;
use Packages\Domain\Comic\ComicKey;
use Packages\Domain\Comic\ComicName;
use Packages\Domain\Comic\ComicRepositoryInterface;
use Packages\Domain\Comic\ComicStatus;
use Packages\Infrastructure\Notifier\ComicNotifier;
use Packages\UseCase\Comic\Exception\ComicAlreadyExistsException;
use Packages\UseCase\Comic\Exception\ComicNotFoundException;
use Packages\UseCase\Comic\Update\ComicUpdateRequest;
use Packages\UseCase\Comic\Update\ComicUpdateResponse;
use Packages\UseCase\Comic\Update\ComicUpdateUseCaseInterface;

class ComicUpdateInteractor implements ComicUpdateUseCaseInterface
{
    /**
     * @param ComicRepositoryInterface $comicRepository
     */
    public function __construct(
        private readonly ComicRepositoryInterface $comicRepository,
        private readonly ComicNotifier $comicNotifier
    ) {
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
        $comicId = new ComicId($request->getId());
        $entity = $this->comicRepository->find($comicId);
        if ($entity === null) {
            throw new ComicNotFoundException('Comic not found');
        }
        if ($this->isDuplicateKey($entity, $request) === true) {
            throw new ComicAlreadyExistsException('Duplicate key');
        }
        $comic = $this->updateComic($entity, $request);
        $this->comicNotifier->notifyUpdate($comic);
        $response = new ComicUpdateResponse();
        $response->setComic($comic);

        return $response;
    }

    /**
     * @param Comic $entity
     * @param ComicUpdateRequest $request
     *
     * @return bool
     */
    private function isDuplicateKey(Comic $entity, ComicUpdateRequest $request): bool
    {
        $comicKey = new ComicKey($request->getKey());
        $ignoreComicId = $entity->getId();
        $comicEntity = $this->comicRepository->findByKey($comicKey, $ignoreComicId);
        if ($comicEntity === null) {
            return false;
        }

        return true;
    }

    /**
     * @param Comic $entity
     * @param ComicUpdateRequest $request
     *
     * @return Comic
     */
    private function updateComic(Comic $entity, ComicUpdateRequest $request): Comic
    {
        $entity->changeKey(new ComicKey($request->getKey()));
        $entity->changeName(new ComicName($request->getName()));
        $entity->changeStatus(ComicStatus::from($request->getStatus()));
        $comic = $this->comicRepository->update($entity);

        return $comic;
    }
}
