<?php

declare(strict_types=1);

namespace Packages\Domain\Comic;

use App\Models\Comic as ComicModel;
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
     * @param ComicId $comicId
     *
     * @return ComicModel|null
     */
    public function findModel(ComicId $comicId): ?ComicModel;

    /**
     * @param ComicKey $comicKey
     * @param ComicId|null $ignoreComicId
     *
     * @return Comic|null
     */
    public function findByKey(ComicKey $comicKey, ?ComicId $ignoreComicId = null): ?Comic;

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
    public function create(Comic $comic): Comic;

    /**
     * @param Comic $comic
     *
     * @return Comic
     */
    public function update(Comic $comic): Comic;

    /**
     * @param Comic $comic
     *
     * @return void
     */
    public function delete(Comic $comic): void;
}
