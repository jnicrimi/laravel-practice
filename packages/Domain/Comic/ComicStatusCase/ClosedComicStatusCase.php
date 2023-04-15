<?php

declare(strict_types=1);

namespace Packages\Domain\Comic\ComicStatusCase;

class ClosedComicStatusCase extends AbstractComicStatusCase implements ComicStatusCaseInterface
{
    public function __construct()
    {
        $this->comicStatusCaseEnum = ComicStatusCaseEnum::CLOSED;
    }

    /**
     * @return bool
     */
    public function isEditable(): bool
    {
        return false;
    }

    /**
     * @return bool
     */
    public function isDeletable(): bool
    {
        return true;
    }
}
