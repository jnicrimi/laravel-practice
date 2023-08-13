<?php

declare(strict_types=1);

namespace Packages\Domain\Comic;

use Packages\Domain\AbstractValueObject;

class ComicName extends AbstractValueObject
{
    /**
     * @var int
     */
    public const MIN_LENGTH = 1;

    /**
     * @var int
     */
    public const MAX_LENGTH = 255;

    /**
     * @return bool
     */
    protected function validate(): bool
    {
        if (! is_string($this->value)) {
            return false;
        }
        if (! $this->isWithinRange(self::MIN_LENGTH, self::MAX_LENGTH)) {
            return false;
        }

        return true;
    }
}
