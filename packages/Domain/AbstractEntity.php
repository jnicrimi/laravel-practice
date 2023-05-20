<?php

declare(strict_types=1);

namespace Packages\Domain;

abstract class AbstractEntity
{
    /**
     * @return array
     */
    abstract public function toArray(): array;
}
