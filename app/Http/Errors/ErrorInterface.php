<?php

declare(strict_types=1);

namespace App\Http\Errors;

interface ErrorInterface
{
    /**
     * @return string
     */
    public function code(): string;

    /**
     * @return string
     */
    public function message(): string;
}
