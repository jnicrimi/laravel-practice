<?php

declare(strict_types=1);

namespace Packages\Domain;

use InvalidArgumentException;

abstract class AbstractValueObject
{
    /**
     * @var mixed
     */
    protected $value;

    /**
     * Constructor
     *
     * @param mixed $value
     */
    public function __construct(mixed $value)
    {
        $this->value = $value;
        if (! $this->validate()) {
            throw new InvalidArgumentException();
        }
    }

    /**
     * @return mixed
     */
    public function getValue(): mixed
    {
        return $this->value;
    }

    /**
     * @return bool
     */
    final protected function isUnsignedInt(): bool
    {
        return is_int($this->value) && $this->value >= 0;
    }

    /**
     * @return bool
     */
    abstract protected function validate(): bool;
}
