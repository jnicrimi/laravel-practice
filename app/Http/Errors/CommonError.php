<?php

declare(strict_types=1);

namespace App\Http\Errors;

enum CommonError: string implements ErrorInterface
{
    case InternalServerError = 'internal-server-error';
    case InvalidArgument = 'invalid-argument';

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
            self::InternalServerError => 'Internal server error.',
            self::InvalidArgument => 'Invalid argument.',
        };
    }
}
