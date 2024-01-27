<?php

declare(strict_types=1);

namespace Packages\UseCase\Comic\Destroy;

use Packages\UseCase\RequestInterface;

class ComicDestroyRequest implements RequestInterface
{
    /**
     * @var int
     */
    private int $id;

    /**
     * Constructor
     */
    public function __construct()
    {
    }

    /**
     * @param int $id
     *
     * @return self
     */
    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }
}
