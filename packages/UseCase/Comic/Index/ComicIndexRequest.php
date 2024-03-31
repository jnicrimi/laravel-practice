<?php

declare(strict_types=1);

namespace Packages\UseCase\Comic\Index;

use Packages\UseCase\RequestInterface;

class ComicIndexRequest implements RequestInterface
{
    /**
     * @var string|null
     */
    private ?string $key;

    /**
     * @var string|null
     */
    private ?string $name;

    /**
     * @var array|null
     */
    private ?array $status;

    /**
     * @param string|null $key
     *
     * @return self
     */
    public function setKey(?string $key): self
    {
        $this->key = $key;

        return $this;
    }

    /**
     * @param string|null $name
     *
     * @return self
     */
    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @param array|null $status
     *
     * @return self
     */
    public function setStatus(?array $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getKey(): ?string
    {
        return $this->key;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @return array|null
     */
    public function getStatus(): ?array
    {
        return $this->status;
    }
}
