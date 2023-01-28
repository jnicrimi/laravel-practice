<?php

declare(strict_types=1);

namespace Packages\Application\Comic\Index;

use Packages\Domain\Comic\ComicRepositoryInterface;
use Packages\UseCase\Comic\Index\ComicIndexResponse;
use Packages\UseCase\Comic\Index\ComicIndexUseCaseInterface;

class ComicIndexInteractor implements ComicIndexUseCaseInterface
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
     * @return ComicIndexResponse
     */
    public function handle(): ComicIndexResponse
    {
        $response = new ComicIndexResponse();

        return $response;
    }
}
