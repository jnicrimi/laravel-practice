<?php

declare(strict_types=1);

namespace Packages\Domain\Comic;

class Comic
{
    /**
     * @var ComicId|null
     */
    private $id;

    /**
     * @var string
     */
    private $key;

    /**
     * @var string
     */
    private $name;

    /**
     * @var ComicStatus
     */
    private $status;

    /**
     * Constructor
     *
     * @param ComicId|null $id
     * @param string $key
     * @param string $name
     * @param ComicStatus $status
     */
    public function __construct(
        ?ComicId $id,
        string $key,
        string $name,
        ComicStatus $status
    ) {
        $this->id = $id;
        $this->key = $key;
        $this->name = $name;
        $this->status = $status;
    }

    /**
     * @return ComicId|null
     */
    public function getId(): ?ComicId
    {
        return $this->id;
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
     * @return ComicStatus
     */
    public function getStatus(): ComicStatus
    {
        return $this->status;
    }
}
