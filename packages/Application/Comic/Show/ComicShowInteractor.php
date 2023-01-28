<?php

declare(strict_types=1);

namespace Packages\Application\Comic\Show;

use Packages\Domain\Comic\ComicId;
use Packages\Domain\Comic\ComicRepositoryInterface;
use Packages\UseCase\Comic\Show\ComicShowRequest;
use Packages\UseCase\Comic\Show\ComicShowResponse;
use Packages\UseCase\Comic\Show\ComicShowUseCaseInterface;

class ComicShowInteractor implements ComicShowUseCaseInterface
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
     * @param ComicShowRequest
     *
     * @return ComicShowResponse
     */
    public function handle(ComicShowRequest $request): ComicShowResponse
    {
        $comicId = new ComicId($request->getComicId());
        $comicEntity = $this->comicRepository->find($comicId);
        $response = new ComicShowResponse(
            $comicEntity->getId()->getValue(),
            $comicEntity->getKey(),
            $comicEntity->getName()
        );

        return $response;
    }
}
