<?php

declare(strict_types=1);

namespace Packages\Domain\Comic;

use Illuminate\Database\Eloquent\Builder;

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
     * @param Builder $query
     * @param int $perPage
     *
     * @return Comics
     */
    public function paginate(Builder $query, int $perPage): Comics;

    /**
     * @param Comic $comic
     *
     * @return Comic
     */
    public function save(Comic $comic): Comic;
}
