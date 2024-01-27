<?php

declare(strict_types=1);

namespace Packages\UseCase\Comic\Store;

use Packages\UseCase\RequestInterface;

class ComicStoreRequest implements RequestInterface
{
    /**
     * @var string
     */
    private string $key;

    /**
     * @var string
     */
    private string $name;

    /**
     * @var string
     */
    private string $status;

    /**
     * Constructor
     */
    public function __construct()
    {
    }

    /**
     * @param string $key
     *
     * @return self
     */
    public function setKey(string $key): self
    {
        $this->key = $key;

        return $this;
    }

    /**
     * @param string $name
     *
     * @return self
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @param string $status
     *
     * @return self
     */
    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return string
     */
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }
}
