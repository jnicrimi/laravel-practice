<?php

declare(strict_types=1);

namespace Packages\Application\Comic;

use Packages\Domain\Comic\ComicRepositoryInterface;
use Packages\UseCase\Comic\Index\ComicIndexResponse;
use Packages\UseCase\Comic\Index\ComicIndexUseCaseInterface;

class ComicIndexInteractor implements ComicIndexUseCaseInterface
{
    /**
     * @var int
     */
    private const PER_PAGE = 5;

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
     * @return ComicIndexResponse
     */
    public function handle(): ComicIndexResponse
    {
        $comicEntities = $this->comicRepository->paginate(self::PER_PAGE);
        $response = new ComicIndexResponse();
        $response->setComics($comicEntities);

        return $response;
    }
}
