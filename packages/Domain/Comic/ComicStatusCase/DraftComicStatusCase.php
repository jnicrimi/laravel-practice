<?php

declare(strict_types=1);

namespace Packages\Domain\Comic\ComicStatusCase;

class DraftComicStatusCase extends AbstractComicStatusCase implements ComicStatusCaseInterface
{
    public function __construct()
    {
        $this->comicStatusCaseEnum = ComicStatusCaseEnum::DRAFT;
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
        return true;
    }
}
