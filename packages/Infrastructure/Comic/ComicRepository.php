<?php

declare(strict_types=1);

namespace Packages\Infrastructure\Comic;

use App\Models\Comic as ComicModel;
use Packages\Domain\Comic\Comic;
use Packages\Domain\Comic\ComicId;
use Packages\Domain\Comic\ComicRepositoryInterface;

class ComicRepository implements ComicRepositoryInterface
{
    /**
     * @param ComicId $comicId
     *
     * @return Comic|null
     */
    public function find(ComicId $comicId): ?Comic
    {
        $comicModel = ComicModel::find($comicId->getValue());
        if ($comicModel === null) {
            return null;
        }

        $comicEntity = new Comic(
            new ComicId($comicModel->id),
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
