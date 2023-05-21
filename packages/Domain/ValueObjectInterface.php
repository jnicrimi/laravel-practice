<?php

declare(strict_types=1);

namespace Packages\Domain;

interface ValueObjectInterface
{
    /**
     * @param mixed $value
     */
    public function __construct($value);

    /**
     * @return mixed
     */
    public function getValue();

    /**
     * @param ValueObjectInterface $valueObject
     *
     * @return bool
     */
    public function equals(self $valueObject): bool;
}
