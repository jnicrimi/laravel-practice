<?php

declare(strict_types=1);

namespace Packages\Infrastructure\QueryBuilder;

use Illuminate\Database\Eloquent\Builder;

abstract class AbstractQueryBuilder
{
    /**
     * @return Builder
     */
    abstract public function build(): Builder;
}
