<?php

declare(strict_types=1);

namespace Packages\UseCase\Comic\Store;

use Packages\Domain\Comic\Comic;
use Packages\UseCase\ResponseInterface;

class ComicStoreResponse implements ResponseInterface
{
    /**
     * @var Comic
     */
    private $comic;

    /**
     * Constructor
     */
    public function __construct()
    {
    }

    /**
     * @param Comic $comic
     *
     * @return self
     */
    public function setComic(Comic $comic): self
    {
        $this->comic = $comic;

        return $this;
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
