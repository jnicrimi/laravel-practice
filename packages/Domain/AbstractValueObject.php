<?php

declare(strict_types=1);

namespace Packages\Domain;

use InvalidArgumentException;

abstract class AbstractValueObject implements ValueObjectInterface
{
    /**
     * Constructor
     *
     * @param mixed $value
     *
     * @throws InvalidArgumentException
     */
    public function __construct(protected mixed $value)
    {
        if (! $this->validate()) {
            throw new InvalidArgumentException('Invalid argument');
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
     * @param ValueObjectInterface $valueObject
     *
     * @return bool
     */
    public function equals(ValueObjectInterface $valueObject): bool
    {
        return $this->value === $valueObject->getValue() && static::class === $valueObject::class;
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
    final protected function isNaturalNumber(): bool
    {
        return is_int($this->value) && $this->value > 0;
    }

    /**
     * @param int $min
     * @param int $max
     *
     * @throws InvalidArgumentException
     *
     * @return bool
     */
    final protected function isWithinRange(int $min, int $max): bool
    {
        if ($min > $max) {
            throw new InvalidArgumentException('Invalid range');
        }
        if (is_int($this->value)) {
            return $this->value >= $min && $this->value <= $max;
        } elseif (is_string($this->value)) {
            return mb_strlen($this->value) >= $min && mb_strlen($this->value) <= $max;
        } elseif (is_array($this->value)) {
            return count($this->value) >= $min && count($this->value) <= $max;
        }

        throw new InvalidArgumentException('Invalid argument type');
    }

    /**
     * @return bool
     */
    abstract protected function validate(): bool;
}
