<?php

declare(strict_types=1);

namespace Packages\Infrastructure\EntityFactory\Comic;

use Illuminate\Support\Arr;
use Packages\Domain\Comic\Comic;
use Packages\Domain\Comic\ComicId;
use Packages\Domain\Comic\ComicKey;
use Packages\Domain\Comic\ComicName;
use Packages\Domain\Comic\ComicStatus;
use Packages\Domain\EntityInterface;
use Packages\Infrastructure\EntityFactory\AbstractEntityFactory;
use Packages\Infrastructure\EntityFactory\EntityFactoryInterface;

class ComicEntityFactory extends AbstractEntityFactory implements EntityFactoryInterface
{
    /**
     * @param array $attributes
     * @param EntityInterface|null $entity
     *
     * @return Comic
     */
    public function create(array $attributes, ?EntityInterface $entity = null): Comic
    {
        if ($entity !== null) {
            if (isset($attributes['id'])) {
                unset($attributes['id']);
            }
            $attributes = array_merge($entity->toArray(), $attributes);
        }
        $comicId = null;
        if (Arr::has($attributes, 'id')) {
            $comicId = new ComicId(Arr::get($attributes, 'id'));
        }
        $comicKey = new ComicKey(Arr::get($attributes, 'key'));
        $comicName = new ComicName(Arr::get($attributes, 'name'));
        $comicStatus = ComicStatus::from(Arr::get($attributes, 'status'));
        $createdAt = Arr::get($attributes, 'created_at');
        $updatedAt = Arr::get($attributes, 'updated_at');
        $comic = new Comic(
            $comicId,
            $comicKey,
            $comicName,
            $comicStatus,
            $createdAt,
            $updatedAt
        );

        return $comic;
    }
}
