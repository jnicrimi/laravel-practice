<?php

declare(strict_types=1);

namespace Packages\UseCase\Comic\Show;

class ComicShowResponse
{
    /**
     * @var int
     */
    private $comicId;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $key;

    /**
     * Constructor
     *
     * @param int $comicId
     */
    public function __construct(
        int $comicId,
        string $name,
        string $key
    ) {
        $this->comicId = $comicId;
        $this->name = $name;
        $this->key = $key;
    }

    /**
     * @return int
     */
    public function getComicId(): int
    {
        return $this->comicId;
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
    public function getKey(): string
    {
        return $this->key;
    }
}
