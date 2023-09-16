<?php

declare(strict_types=1);

namespace Packages\Application\Comic;

use Packages\Domain\Comic\Comic;
use Packages\Domain\Comic\ComicKey;
use Packages\Domain\Comic\ComicRepositoryInterface;
use Packages\Infrastructure\EntityFactory\Comic\ComicEntityFactory;
use Packages\UseCase\Comic\Create\ComicCreateRequest;
use Packages\UseCase\Comic\Create\ComicCreateResponse;
use Packages\UseCase\Comic\Create\ComicCreateUseCaseInterface;
use Packages\UseCase\Comic\Exception\ComicDuplicateException;

class ComicCreateInteractor implements ComicCreateUseCaseInterface
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
     * @param ComicCreateRequest $request
     *
     * @throws ComicDuplicateException
     *
     * @return ComicCreateResponse
     */
    public function handle(ComicCreateRequest $request): ComicCreateResponse
    {
        if ($this->doesComicExist($request)) {
            throw new ComicDuplicateException('Comic already exists');
        }
        $comic = $this->saveComic($request);
        $response = new ComicCreateResponse();
        $response->setComic($comic);

        return $response;
    }

    /**
     * @param ComicCreateRequest $request
     *
     * @return bool
     */
    private function doesComicExist(ComicCreateRequest $request): bool
    {
        $comicKey = new ComicKey($request->getKey());
        $comic = $this->comicRepository->findByKey($comicKey);
        if ($comic === null) {
            return false;
        }

        return true;
    }

    /**
     * @param ComicCreateRequest $request
     *
     * @return Comic
     */
    private function saveComic(ComicCreateRequest $request): Comic
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
