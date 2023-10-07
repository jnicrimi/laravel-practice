<?php

declare(strict_types=1);

namespace Packages\Application\Comic;

use Packages\Domain\Comic\Comic;
use Packages\Domain\Comic\ComicKey;
use Packages\Domain\Comic\ComicRepositoryInterface;
use Packages\Infrastructure\EntityFactory\Comic\ComicEntityFactory;
use Packages\UseCase\Comic\Exception\ComicDuplicateException;
use Packages\UseCase\Comic\Store\ComicStoreRequest;
use Packages\UseCase\Comic\Store\ComicStoreResponse;
use Packages\UseCase\Comic\Store\ComicStoreUseCaseInterface;

class ComicStoreInteractor implements ComicStoreUseCaseInterface
{
    /**
     * @var ComicRepositoryInterface
     */
    private $comicRepository;

    /**
     * Constructor
     *
     * @param ComicRepositoryInterface $comicRepository
     */
    public function __construct(ComicRepositoryInterface $comicRepository)
    {
        $this->comicRepository = $comicRepository;
    }

    /**
     * @param ComicStoreRequest $request
     *
     * @throws ComicDuplicateException
     *
     * @return ComicStoreResponse
     */
    public function handle(ComicStoreRequest $request): ComicStoreResponse
    {
        if ($this->doesComicExist($request)) {
            throw new ComicDuplicateException('Comic already exists');
        }
        $comic = $this->saveComic($request);
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
    private function saveComic(ComicStoreRequest $request): Comic
    {
        $entityFactory = new ComicEntityFactory();
        $entity = $entityFactory->create([
            'key' => $request->getKey(),
            'name' => $request->getName(),
            'status' => $request->getStatus(),
        ]);
        $comic = $this->comicRepository->save($entity);

        return $comic;
    }
}
