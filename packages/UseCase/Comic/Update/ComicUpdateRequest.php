<?php

declare(strict_types=1);

namespace Packages\UseCase\Comic\Update;

use Packages\UseCase\RequestInterface;

class ComicUpdateRequest implements RequestInterface
{
    /**
     * @param int $id
     * @param string $key
     * @param string $name
     * @param string $status
     */
    public function __construct(
        public readonly int $id,
        public readonly string $key,
        public readonly string $name,
        public readonly string $status
    ) {
    }
}
