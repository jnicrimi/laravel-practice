<?php

declare(strict_types=1);

namespace Packages\UseCase\Comic\Index;

use Packages\Domain\Comic\Comics;

class ComicIndexResponse
{
    /**
     * @var Comics
     */
    private $comics;

    /**
     * Constructor
     */
    public function __construct(Comics $comics)
    {
        $this->comics = $comics;
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
                'key' => $comic->getKey(),
                'name' => $comic->getName(),
                'status' => $comic->getStatus(),
            ];
        }

        return $comics;
    }
}
