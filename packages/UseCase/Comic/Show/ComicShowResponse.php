<?php

declare(strict_types=1);

namespace Packages\UseCase\Comic\Show;

use Packages\Domain\Comic\Comic;
use Packages\UseCase\ResponseInterface;

class ComicShowResponse implements ResponseInterface
{
    /**
     * @var Comic
     */
    private $comic;

    /**
     * Constructor
     *
     * @param Comic $comic
     */
    public function __construct(Comic $comic)
    {
        $this->comic = $comic;
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
            'status' => $this->comic->getStatus()->description(),
        ];
    }
}
