<?php

declare(strict_types=1);

namespace Packages\Infrastructure\QueryBuilder;

use Illuminate\Database\Eloquent\Builder;

interface QueryBuilderInterface
{
    /**
     * @return Builder
     */
    public function build(): Builder;
}
