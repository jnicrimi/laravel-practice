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
    private Comic $comic;

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
