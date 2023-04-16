<?php

declare(strict_types=1);

namespace Packages\Domain\Comic\ComicStatusCase;

interface ComicStatusCaseInterface
{
    /**
     * @return bool
     */
    public function isPublished(): bool;

    /**
     * @return bool
     */
    public function isDraft(): bool;

    /**
     * @return bool
     */
    public function isClosed(): bool;

    /**
     * @return bool
     */
    public function isEditable(): bool;

    /**
     * @return bool
     */
    public function isDeletable(): bool;
}
