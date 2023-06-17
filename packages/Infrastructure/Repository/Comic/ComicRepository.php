<?php

declare(strict_types=1);

namespace Packages\Infrastructure\Repository\Comic;

use App\Models\Comic as ComicModel;
use Illuminate\Database\Eloquent\Model;
use Packages\Domain\Comic\Comic;
use Packages\Domain\Comic\ComicId;
use Packages\Domain\Comic\ComicKey;
use Packages\Domain\Comic\ComicName;
use Packages\Domain\Comic\ComicRepositoryInterface;
use Packages\Domain\Comic\Comics;
use Packages\Domain\Comic\ComicStatus;
use Packages\Infrastructure\Repository\AbstractRepository;

class ComicRepository extends AbstractRepository implements ComicRepositoryInterface
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

    public function paginate(int $perPage): Comics
    {
        $comicModels = ComicModel::paginate($perPage);
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
        $comicId = new ComicId($model->getAttribute('id'));
        $comicKey = new ComicKey($model->getAttribute('key'));
        $comicName = new ComicName($model->getAttribute('name'));
        $comicStatus = ComicStatus::from($model->getAttribute('status'));

        return new Comic(
            $comicId,
            $comicKey,
            $comicName,
            $comicStatus
        );
    }
}
