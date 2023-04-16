<?php

declare(strict_types=1);

namespace Packages\Domain\Comic\ComicStatusCase;

use Illuminate\Support\Facades\Lang;

enum ComicStatusCaseEnum: string
{
    case PUBLISHED = 'published';
    case DRAFT = 'draft';
    case CLOSED = 'closed';

    /**
     * @param self $enum
     *
     * @return bool
     */
    public function equals(self $enum): bool
    {
        return $this->value === $enum->value && static::class === $enum::class;
    }

    /**
     * @return string
     */
    public function description(): string
    {
        return match ($this) {
            self::PUBLISHED => Lang::get('company/status.description.published'),
            self::DRAFT => Lang::get('company/status.description.draft'),
            self::CLOSED => Lang::get('company/status.description.closed'),
        };
    }
}
