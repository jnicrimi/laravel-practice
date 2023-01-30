<?php

declare(strict_types=1);

namespace Packages\Domain\Comic;

class Comics implements \IteratorAggregate
{
    /**
     * @var array
     */
    private $comics;

    /**
     * Constructor
     *
     * @param array $comics
     */
    public function __construct(array $comics)
    {
        foreach ($comics as $comic) {
            if (! $comic instanceof Comic) {
                throw new \InvalidArgumentException('Invalid comic entity');
            }
        }
        $this->comics = $comics;
    }

    /**
     * @return \Traversable
     */
    public function getIterator(): \Traversable
    {
        return new \ArrayIterator($this->comics);
    }
}
