<?php

declare(strict_types=1);

namespace Packages\Domain\Comic;

use Packages\Domain\AbstractValueObject;

class ComicId extends AbstractValueObject
{
    /**
     * @return bool
     */
    protected function validate(): bool
    {
        return $this->isNaturalNumber();
    }
}
