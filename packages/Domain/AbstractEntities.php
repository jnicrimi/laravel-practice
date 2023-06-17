<?php

declare(strict_types=1);

namespace Packages\Domain;

use ArrayAccess;
use ArrayIterator;
use Countable;
use InvalidArgumentException;
use IteratorAggregate;
use Traversable;

abstract class AbstractEntities implements ArrayAccess, Countable, IteratorAggregate
{
    /**
     * @var array
     */
    protected $items = [];

    /**
     * @var Pagination
     */
    protected $pagination;

    /**
     * @param mixed $offset
     *
     * @return bool
     */
    public function offsetExists(mixed $offset): bool
    {
        return isset($this->items[$offset]);
    }

    /**
     * @param mixed $offset
     *
     * @return mixed
     */
    public function offsetGet(mixed $offset): mixed
    {
        return $this->items[$offset] ?? null;
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     *
     * @return void
     */
    public function offsetSet(mixed $offset, mixed $value): void
    {
        if (get_class($value) !== $this->getEntityClass()) {
            throw new InvalidArgumentException();
        }

        if ($offset === null) {
            $this->items[] = $value;
        } else {
            $this->items[$offset] = $value;
        }
    }

    /**
     * @param mixed $offset
     *
     * @return void
     */
    public function offsetUnset(mixed $offset): void
    {
        unset($this->items[$offset]);
    }

    /**
     * @return int
     */
    public function count(): int
    {
        return count($this->items);
    }

    /**
     * @param Pagination $pagination
     *
     * @return self
     */
    public function setPagination(Pagination $pagination): self
    {
        $this->pagination = $pagination;

        return $this;
    }

    /**
     * @return Pagination
     */
    public function getPagination(): Pagination
    {
        return $this->pagination;
    }

    /**
     * @return Traversable
     */
    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->items);
    }

    /**
     * @return string
     */
    abstract protected function getEntityClass(): string;
}
