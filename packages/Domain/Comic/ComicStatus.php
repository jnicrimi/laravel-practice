<?php

declare(strict_types=1);

namespace Packages\Domain\Comic;

use Packages\Domain\AbstractValueObject;

class ComicStatus extends AbstractValueObject
{
    /**
     * @return bool
     */
    protected function validate(): bool
    {
        return $this->value::class === ComicStatusCase::class;
    }
}
