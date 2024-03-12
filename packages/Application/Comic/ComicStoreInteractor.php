<?php

declare(strict_types=1);

namespace Packages\Application\Comic;

use Packages\Domain\Comic\Comic;
use Packages\Domain\Comic\ComicKey;
use Packages\Domain\Comic\ComicName;
use Packages\Domain\Comic\ComicRepositoryInterface;
use Packages\Domain\Comic\ComicStatus;
use Packages\Infrastructure\Service\Notification\ComicNotificationService;
use Packages\UseCase\Comic\Exception\ComicAlreadyExistsException;
use Packages\UseCase\Comic\Store\ComicStoreRequest;
use Packages\UseCase\Comic\Store\ComicStoreResponse;
use Packages\UseCase\Comic\Store\ComicStoreUseCaseInterface;

class ComicStoreInteractor implements ComicStoreUseCaseInterface
{
    /**
     * Constructor
     *
     * @param ComicRepositoryInterface $comicRepository
     */
    public function __construct(
        private readonly ComicRepositoryInterface $comicRepository,
        private readonly ComicNotificationService $comicNotificationService
    ) {
    }

    /**
     * @param ComicStoreRequest $request
     *
     * @throws ComicAlreadyExistsException
     *
     * @return ComicStoreResponse
     */
    public function handle(ComicStoreRequest $request): ComicStoreResponse
    {
        if ($this->doesComicExist($request)) {
            throw new ComicAlreadyExistsException('Comic already exists');
        }
        $comic = $this->createComic($request);
        $this->comicNotificationService->notifyStore($comic);
        $response = new ComicStoreResponse();
        $response->setComic($comic);

        return $response;
    }

    /**
     * @param ComicStoreRequest $request
     *
     * @return bool
     */
    private function doesComicExist(ComicStoreRequest $request): bool
    {
        $comicKey = new ComicKey($request->getKey());
        $comic = $this->comicRepository->findByKey($comicKey);
        if ($comic === null) {
            return false;
        }

        return true;
    }

    /**
     * @param ComicStoreRequest $request
     *
     * @return Comic
     */
    private function createComic(ComicStoreRequest $request): Comic
    {
        $entity = new Comic(
            id: null,
            key: new ComicKey($request->getKey()),
            name: new ComicName($request->getName()),
            status: ComicStatus::from($request->getStatus())
        );
        $comic = $this->comicRepository->create($entity);

        return $comic;
    }
}
