<?php

declare(strict_types=1);

namespace Packages\Domain\Comic\ComicStatusCase;

class PublishedComicStatusCase extends AbstractComicStatusCase implements ComicStatusCaseInterface
{
    public function __construct()
    {
        $this->comicStatusCaseEnum = ComicStatusCaseEnum::PUBLISHED;
    }

    /**
     * @return bool
     */
    public function isEditable(): bool
    {
        return true;
    }

    /**
     * @return bool
     */
    public function isDeletable(): bool
    {
        return false;
    }
}
