<?php

declare(strict_types=1);

namespace Packages\Domain\Comic;

use Packages\Domain\AbstractEntities;

class Comics extends AbstractEntities
{
    /**
     * @return string
     */
    protected function getEntityClass(): string
    {
        return Comic::class;
    }
}
