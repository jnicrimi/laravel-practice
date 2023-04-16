<?php

declare(strict_types=1);

namespace Packages\Domain\Comic\ComicStatusCase;

abstract class AbstractComicStatusCase implements ComicStatusCaseInterface
{
    /**
     * @var ComicStatusCaseEnum
     */
    protected $comicStatusCaseEnum;

    public function __construct()
    {
        // nothing to do.
    }

    /**
     * @return ComicStatusCaseEnum
     */
    final public function getComicStatusCaseEnum(): ComicStatusCaseEnum
    {
        return $this->comicStatusCaseEnum;
    }

    /**
     * @return bool
     */
    final public function isPublished(): bool
    {
        return $this->comicStatusCaseEnum->equals(ComicStatusCaseEnum::PUBLISHED);
    }

    /**
     * @return bool
     */
    final public function isDraft(): bool
    {
        return $this->comicStatusCaseEnum->equals(ComicStatusCaseEnum::DRAFT);
    }

    /**
     * @return bool
     */
    final public function isClosed(): bool
    {
        return $this->comicStatusCaseEnum->equals(ComicStatusCaseEnum::CLOSED);
    }
}
