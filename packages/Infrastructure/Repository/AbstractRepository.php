<?php

declare(strict_types=1);

namespace Packages\Infrastructure\Repository;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Packages\Domain\EntityInterface;
use Packages\Domain\Pagination;

abstract class AbstractRepository
{
    /**
     * @param Model $model
     *
     * @return EntityInterface
     */
    abstract public function modelToEntity(Model $model): EntityInterface;

    /**
     * @param LengthAwarePaginator $lengthAwarePaginator
     *
     * @return Pagination
     */
    protected function lengthAwarePaginatorToPagination(LengthAwarePaginator $lengthAwarePaginator): Pagination
    {
        return new Pagination(
            $lengthAwarePaginator->perPage(),
            $lengthAwarePaginator->currentPage(),
            $lengthAwarePaginator->lastPage(),
            $lengthAwarePaginator->total(),
            $lengthAwarePaginator->firstItem(),
            $lengthAwarePaginator->lastItem()
        );
    }
}
