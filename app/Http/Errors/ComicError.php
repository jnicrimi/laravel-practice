<?php

declare(strict_types=1);

namespace App\Http\Errors;

enum ComicError: string implements ErrorInterface
{
    case ComicNotFound = 'comic-not-found';
    case ComicAlreadyExists = 'comic-already-exists';
    case ComicUndelete = 'comic-undelete';

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
            self::ComicAlreadyExists => 'Comic already exists.',
            self::ComicUndelete => 'Comic cannot be deleted.',
        };
    }
}
