<?php

declare(strict_types=1);

namespace Packages\UseCase\Comic\Update;

use Packages\Domain\Comic\Comic;
use Packages\UseCase\ResponseInterface;

class ComicUpdateResponse implements ResponseInterface
{
    /**
     * @param Comic $comic
     */
    public function __construct(private readonly Comic $comic)
    {
    }

    /**
     * @return array
     */
    public function build(): array
    {
        return [
            'comic' => $this->buildComic(),
        ];
    }

    /**
     * @return array
     */
    private function buildComic(): array
    {
        return [
            'id' => $this->comic->getId()->getValue(),
            'key' => $this->comic->getKey()->getValue(),
            'name' => $this->comic->getName()->getValue(),
            'status' => [
                'value' => $this->comic->getStatus()->value,
                'description' => $this->comic->getStatus()->description(),
            ],
        ];
    }
}
