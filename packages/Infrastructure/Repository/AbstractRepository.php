<?php

declare(strict_types=1);

namespace Packages\Infrastructure\Repository;

use Illuminate\Database\Eloquent\Model;
use Packages\Domain\EntityInterface;

abstract class AbstractRepository
{
    /**
     * @param Model $model
     *
     * @return EntityInterface
     */
    abstract public function modelToEntity(Model $model): EntityInterface;
}
