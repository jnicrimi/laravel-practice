<?php

declare(strict_types=1);

namespace Packages\Infrastructure\Repository;

use Illuminate\Database\Eloquent\Model;
use Packages\Domain\EntityInterface;

interface EloquentRepositoryInterface
{
    /**
     * @param Model $model
     *
     * @return EntityInterface
     */
    public function modelToEntity(Model $model): EntityInterface;
}
