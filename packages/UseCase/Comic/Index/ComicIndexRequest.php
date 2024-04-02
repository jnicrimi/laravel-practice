<?php

declare(strict_types=1);

namespace Packages\UseCase\Comic\Index;

use Packages\UseCase\RequestInterface;

class ComicIndexRequest implements RequestInterface
{
    /**
     * @param string|null $key
     * @param string|null $name
     * @param array|null $status
     */
    public function __construct(
        public readonly ?string $key,
        public readonly ?string $name,
        public readonly ?array $status
    ) {
    }
}
