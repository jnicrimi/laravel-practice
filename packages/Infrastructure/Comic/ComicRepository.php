<?php

declare(strict_types=1);

namespace Packages\Infrastructure\Comic;

use App\Models\Comic as ComicModel;
use Illuminate\Database\Eloquent\Model;
use Packages\Domain\Comic\Comic;
use Packages\Domain\Comic\ComicId;
use Packages\Domain\Comic\ComicRepositoryInterface;
use Packages\Domain\Comic\Comics;
use Packages\Domain\Comic\ComicStatus;
use Packages\Domain\Comic\ComicStatusCase;
use Packages\Domain\EntityInterface;
use Packages\Infrastructure\EloquentRepositoryInterface;

class ComicRepository implements ComicRepositoryInterface, EloquentRepositoryInterface
{
    /**
     * @param ComicId $comicId
     *
     * @return Comic|null
     */
    public function find(ComicId $comicIdCondition): ?Comic
    {
        $comicModel = ComicModel::find($comicIdCondition->getValue());
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
        $comicEntities = [];
        foreach ($comicModels as $comicModel) {
            $comicEntities[] = $this->modelToEntity($comicModel);
        }

        return new Comics($comicEntities);
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
        $comicModel->status = $comic->getStatus()->getValue()->value;
        $comicModel->save();
    }

    /**
     * @param Model $model
     *
     * @return EntityInterface
     */
    public function modelToEntity(Model $model): EntityInterface
    {
        $comicId = new ComicId($model->id);
        $comicStatusCase = ComicStatusCase::from($model->status);
        $comicStatus = new ComicStatus($comicStatusCase);

        return new Comic(
            $comicId,
            $model->key,
            $model->name,
            $comicStatus
        );
    }
}
