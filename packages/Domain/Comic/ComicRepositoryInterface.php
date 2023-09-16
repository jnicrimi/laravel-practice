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
     * @param ComicKey $comicKey
     *
     * @return Comic|null
     */
    public function findByKey(ComicKey $comicKey): ?Comic;

    /**
     * @param int $perPage
     *
     * @return Comics
     */
    public function paginate(int $perPage): Comics;

    /**
     * @param Comic $comic
     *
     * @return Comic
     */
    public function save(Comic $comic): Comic;
}
