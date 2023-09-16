<?php

declare(strict_types=1);

namespace App\Http\Errors;

enum ComicError: string implements ErrorInterface
{
    case ComicNotFound = 'comic-not-found';
    case ComicDuplicate = 'comic-duplicate';

    /**
     * @return string
     */
    public function code(): string
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function message(): string
    {
        return match ($this) {
            self::ComicNotFound => 'Comic not found.',
            self::ComicDuplicate => 'Comic already exists.',
        };
    }
}
