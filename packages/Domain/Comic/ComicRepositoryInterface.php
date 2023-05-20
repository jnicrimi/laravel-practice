<?php

declare(strict_types=1);

namespace Packages\Domain\Comic;

interface ComicRepositoryInterface
{
    /**
     * @param ComicId $comicId
     *
     * @return Comic|null
     */
    public function find(ComicId $comicId): ?Comic;

    /**
     * @return Comics
     */
    public function all(): Comics;

    /**
     * @param Comic $comic
     *
     * @return Comic
     */
    public function save(Comic $comic): Comic;
}
