<?php

declare(strict_types=1);

namespace Packages\Domain;

trait EnumMatchable
{
    /**
     * @param self $enum
     *
     * @return bool
     */
    public function equals(self $enum): bool
    {
        return $this->value === $enum->value && static::class === $enum::class;
    }
}
