<?php

declare(strict_types=1);

namespace Packages\Domain;

interface EntityInterface
{
    /**
     * @return array
     */
    public function toArray(): array;
}
