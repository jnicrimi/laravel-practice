<?php

declare(strict_types=1);

namespace Packages\Infrastructure\Comic;

use App\Models\Comic as ComicModel;
use Packages\Domain\Comic\Comic;
use Packages\Domain\Comic\ComicRepositoryInterface;

class ComicRepository implements ComicRepositoryInterface
{
    /**
     * @param Comic $comic
     *
     * @return Comic|null
     */
    public function find(Comic $comic): ?Comic
    {
        $comicModel = ComicModel::find($comic->getId());
        if ($comicModel === null) {
            return null;
        }

        $comicEntity = new Comic(
            $comicModel->id,
            $comicModel->key,
            $comicModel->name
        );

        return $comicEntity;
    }

    /**
     * @param Comic $comic
     *
     * @return void
     */
    public function save(Comic $comic): void
    {
        $comicModel = new ComicModel();
        $comicModel->key = $comic->getKey();
        $comicModel->name = $comic->getName();
        $comicModel->save();
    }
}
