<?php

declare(strict_types=1);

namespace Packages\UseCase\Comic\Index;

use Packages\Domain\Comic\Comics;
use Packages\UseCase\ResponseInterface;

class ComicIndexResponse implements ResponseInterface
{
    /**
     * @var Comics
     */
    private $comics;

    /**
     * Constructor
     */
    public function __construct()
    {
    }

    /**
     * @param Comics $comics
     *
     * @return self
     */
    public function setComics(Comics $comics): self
    {
        $this->comics = $comics;

        return $this;
    }

    /**
     * @return array
     */
    public function build(): array
    {
        return [
            'comics' => $this->buildComics(),
        ];
    }

    /**
     * @return array
     */
    private function buildComics(): array
    {
        $comics = [];
        foreach ($this->comics as $comic) {
            $comics[] = [
                'id' => $comic->getId()->getValue(),
                'key' => $comic->getKey()->getValue(),
                'name' => $comic->getName()->getValue(),
                'status' => [
                    'value' => $comic->getStatus()->value,
                    'description' => $comic->getStatus()->description(),
                ],
            ];
        }

        return $comics;
    }
}
