<?php

declare(strict_types=1);

namespace Packages\UseCase\Comic\Show;

use Packages\UseCase\RequestInterface;

class ComicShowRequest implements RequestInterface
{
    /**
     * @var int
     */
    private $comicId;

    /**
     * Constructor
     */
    public function __construct()
    {
    }

    /**
     * @param int $comicId
     *
     * @return self
     */
    public function setComicId(int $comicId): self
    {
        $this->comicId = $comicId;

        return $this;
    }

    /**
     * @return int
     */
    public function getComicId(): int
    {
        return $this->comicId;
    }
}
