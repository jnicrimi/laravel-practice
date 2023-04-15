<?php

declare(strict_types=1);

namespace Packages\Domain\Comic;

use Packages\Domain\AbstractValueObject;
use Packages\Domain\Comic\ComicStatusCase\ComicStatusCaseInterface;

class ComicStatus extends AbstractValueObject
{
    /**
     * @return bool
     */
    protected function validate(): bool
    {
        return $this->value instanceof ComicStatusCaseInterface;
    }
}
