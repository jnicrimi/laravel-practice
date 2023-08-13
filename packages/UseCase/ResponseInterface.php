<?php

declare(strict_types=1);

namespace Packages\UseCase;

interface ResponseInterface
{
    /**
     * @return array
     */
    public function build(): array;
}
