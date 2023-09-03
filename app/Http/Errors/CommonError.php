<?php

declare(strict_types=1);

namespace App\Http\Errors;

enum CommonError implements ErrorInterface
{
    case InvalidArgument;
    case InternalServerError;

    /**
     * @return string
     */
    public function code(): string
    {
        return match ($this) {
            self::InvalidArgument => 'invalid-argument',
            self::InternalServerError => 'internal-server-error',
        };
    }

    /**
     * @return string
     */
    public function message(): string
    {
        return match ($this) {
            self::InvalidArgument => 'Invalid argument.',
            self::InternalServerError => 'Internal server error.',
        };
    }
}
