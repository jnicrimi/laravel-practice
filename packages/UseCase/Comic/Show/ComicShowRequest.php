<?php

declare(strict_types=1);

namespace Packages\UseCase\Comic\Show;

class ComicShowRequest
{
    /**
     * @var int
     */
    private $comicId;

    /**
     * Constructor
     *
     * @param int $comicId
     */
    public function __construct(int $comicId)
    {
        $this->comicId = $comicId;
    }

    /**
     * @return int
     */
    public function getComicId(): int
    {
        return $this->comicId;
    }
}
