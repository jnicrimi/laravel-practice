<?php

declare(strict_types=1);

namespace Packages\Infrastructure\Repository\Comic;

use App\Models\Comic as ComicModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Packages\Domain\Comic\Comic;
use Packages\Domain\Comic\ComicId;
use Packages\Domain\Comic\ComicKey;
use Packages\Domain\Comic\ComicName;
use Packages\Domain\Comic\ComicRepositoryInterface;
use Packages\Domain\Comic\Comics;
use Packages\Domain\Comic\ComicStatus;
use Packages\Infrastructure\Repository\AbstractEloquentRepository;

class ComicRepository extends AbstractEloquentRepository implements ComicRepositoryInterface
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
     * @param ComicKey $comicKey
     * @param ComicId|null $ignoreComicId
     *
     * @return Comic|null
     */
    public function findByKey(ComicKey $comicKey, ?ComicId $ignoreComicId = null): ?Comic
    {
        $query = ComicModel::where('key', $comicKey->getValue());
        if ($ignoreComicId !== null) {
            $query->where('id', '!=', $ignoreComicId->getValue());
        }
        $comicModel = $query->first();
        if ($comicModel === null) {
            return null;
        }

        return $this->modelToEntity($comicModel);
    }

    /**
     * @param Builder $query
     * @param int $perPage
     *
     * @return Comics
     */
    public function paginate(Builder $query, int $perPage): Comics
    {
        $comicModels = $query->paginate($perPage);
        $comics = new Comics();
        foreach ($comicModels as $comicModel) {
            $comics[] = $this->modelToEntity($comicModel);
        }
        if ($comicModels->isNotEmpty()) {
            $pagination = $this->lengthAwarePaginatorToPagination($comicModels);
            $comics->setPagination($pagination);
        }

        return $comics;
    }

    /**
     * @param Comic $comic
     *
     * @return Comic
     */
    public function create(Comic $comic): Comic
    {
        $data = [];
        $fillable = (new ComicModel())->getFillable();
        foreach ($comic->toArray() as $key => $val) {
            if (in_array($key, $fillable)) {
                $data[$key] = $val;
            }
        }
        $comicModel = ComicModel::create($data);
        $comicModel->refresh();

        return $this->modelToEntity($comicModel);
    }

    /**
     * @param Comic $comic
     *
     * @return Comic
     */
    public function update(Comic $comic): Comic
    {
        $data = [];
        $fillable = (new ComicModel())->getFillable();
        foreach ($comic->toArray() as $key => $val) {
            if (in_array($key, $fillable)) {
                $data[$key] = $val;
            }
        }
        $comicModel = ComicModel::findOrFail($comic->getId()->getValue());
        $comicModel->update($data);
        $comicModel->refresh();

        return $this->modelToEntity($comicModel);
    }

    /**
     * @param Comic $comic
     *
     * @return void
     */
    public function delete(Comic $comic): void
    {
        $comicModel = ComicModel::findOrFail($comic->getId()->getValue());
        $comicModel->delete();
    }

    /**
     * @param Model $model
     *
     * @return Comic
     */
    public function modelToEntity(Model $model): Comic
    {
        return new Comic(
            new ComicId($model->getAttribute('id')),
            new ComicKey($model->getAttribute('key')),
            new ComicName($model->getAttribute('name')),
            ComicStatus::from($model->getAttribute('status')),
            $model->getAttribute('created_at'),
            $model->getAttribute('updated_at')
        );
    }
}
