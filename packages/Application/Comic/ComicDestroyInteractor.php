<?php

declare(strict_types=1);

namespace Packages\Application\Comic;

use Packages\Domain\Comic\ComicId;
use Packages\Domain\Comic\ComicRepositoryInterface;
use Packages\UseCase\Comic\Destroy\ComicDestroyRequest;
use Packages\UseCase\Comic\Destroy\ComicDestroyResponse;
use Packages\UseCase\Comic\Destroy\ComicDestroyUseCaseInterface;
use Packages\UseCase\Comic\Exception\ComicCannotBeDeletedException;
use Packages\UseCase\Comic\Exception\ComicNotFoundException;

class ComicDestroyInteractor implements ComicDestroyUseCaseInterface
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
     * @param ComicDestroyRequest $request
     *
     * @throws ComicNotFoundException
     * @throws ComicCannotBeDeletedException
     *
     * @return ComicDestroyResponse
     */
    public function handle(ComicDestroyRequest $request): ComicDestroyResponse
    {
        $comicId = new ComicId($request->getId());
        $comicEntity = $this->comicRepository->find($comicId);
        if ($comicEntity === null) {
            throw new ComicNotFoundException('Comic not found');
        }
        if (! $comicEntity->canDelete()) {
            throw new ComicCannotBeDeletedException('Comic cannot be deleted');
        }
        $this->comicRepository->delete($comicEntity);
        $response = new ComicDestroyResponse();
        $response->setComic($comicEntity);

        return $response;
    }
}
