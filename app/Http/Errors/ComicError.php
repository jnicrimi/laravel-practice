<?php

declare(strict_types=1);

namespace App\Http\Errors;

enum ComicError implements ErrorInterface
{
    case ComicNotFound;

    /**
     * @return string
     */
    public function code(): string
    {
        return match ($this) {
            self::ComicNotFound => 'comic-not-found',
        };
    }

    /**
     * @return string
     */
    public function message(): string
    {
        return match ($this) {
            self::ComicNotFound => 'Comic not found.',
        };
    }
}
