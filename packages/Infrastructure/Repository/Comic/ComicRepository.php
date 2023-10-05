<?php

declare(strict_types=1);

namespace Packages\Infrastructure\Repository\Comic;

use App\Models\Comic as ComicModel;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Packages\Domain\Comic\Comic;
use Packages\Domain\Comic\ComicId;
use Packages\Domain\Comic\ComicKey;
use Packages\Domain\Comic\ComicRepositoryInterface;
use Packages\Domain\Comic\Comics;
use Packages\Infrastructure\EntityFactory\Comic\ComicEntityFactory;
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
    public function save(Comic $comic): Comic
    {
        $data = [];
        $fillable = (new ComicModel())->getFillable();
        foreach ($comic->toArray() as $key => $val) {
            if (in_array($key, $fillable)) {
                $data[$key] = $val;
            }
        }
        if ($comic->getId() === null) {
            $comicModel = ComicModel::create($data);
        } else {
            $comicModel = ComicModel::findOrFail($comic->getId()->getValue());
            $comicModel->update($data);
        }
        $comicModel->refresh();

        return $this->modelToEntity($comicModel);
    }

    /**
     * @param Model $model
     *
     * @return Comic
     */
    public function modelToEntity(Model $model): Comic
    {
        $factory = new ComicEntityFactory();
        $attributes = [
            'id' => $model->getAttribute('id'),
            'key' => $model->getAttribute('key'),
            'name' => $model->getAttribute('name'),
            'status' => $model->getAttribute('status'),
            'created_at' => Carbon::parse($model->getAttribute('created_at'))->format(Comic::DATE_FORMAT),
            'updated_at' => Carbon::parse($model->getAttribute('updated_at')->format(Comic::DATE_FORMAT)),
        ];

        return $factory->create($attributes);
    }
}
