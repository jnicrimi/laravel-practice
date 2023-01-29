<?php

declare(strict_types=1);

namespace Packages\Infrastructure\Comic;

use App\Models\Comic as ComicModel;
use Packages\Domain\Comic\Comic;
use Packages\Domain\Comic\ComicId;
use Packages\Domain\Comic\ComicRepositoryInterface;
use Packages\Domain\Comic\Comics;
use Packages\Domain\Comic\ComicStatus;
use Packages\Domain\Comic\ComicStatusCase;

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

        $comicId = new ComicId($comicModel->id);
        $comicStatusCase = ComicStatusCase::from($comicModel->status);
        $comicStatus = new ComicStatus($comicStatusCase);
        $comicEntity = new Comic(
            $comicId,
            $comicModel->key,
            $comicModel->name,
            $comicStatus
        );

        return $comicEntity;
    }

    /**
     * @return Comics
     */
    public function all(): Comics
    {
        $comicModels = ComicModel::all();
        $comicEntities = [];
        foreach ($comicModels as $comicModel) {
            $comicId = new ComicId($comicModel->id);
            $comicStatusCase = ComicStatusCase::from($comicModel->status);
            $comicStatus = new ComicStatus($comicStatusCase);
            $comicEntities[] = new Comic(
                $comicId,
                $comicModel->key,
                $comicModel->name,
                $comicStatus
            );
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
}
