<?php

declare(strict_types=1);

namespace Packages\Infrastructure\Comic;

use App\Models\Comic as ComicModel;
use Packages\Domain\Comic\Comic;
use Packages\Domain\Comic\ComicId;
use Packages\Domain\Comic\ComicRepositoryInterface;
use Packages\Domain\Comic\Comics;
use Packages\Domain\Comic\ComicStatus;

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

        return $this->modelToEntity($comicModel);
    }

    /**
     * @return Comics
     */
    public function all(): Comics
    {
        $comicModels = ComicModel::all();
        $comics = new Comics();
        foreach ($comicModels as $comicModel) {
            $comics[] = $this->modelToEntity($comicModel);
        }

        return $comics;
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
        $comicModel->status = $comic->getStatus()->value;
        $comicModel->save();
    }

    /**
     * @param ComicModel $model
     *
     * @return Comic
     */
    public function modelToEntity(ComicModel $model): Comic
    {
        $comicId = new ComicId($model->id);
        $comicStatus = ComicStatus::from($model->status);

        return new Comic(
            $comicId,
            $model->key,
            $model->name,
            $comicStatus
        );
    }
}
