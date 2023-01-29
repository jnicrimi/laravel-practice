<?php

declare(strict_types=1);

namespace Packages\Domain\Comic;

class Comic
{
    /**
     * @var ComicId
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
     * @var string
     */
    private $status;

    /**
     * Constructor
     *
     * @param ComicId $id
     * @param string $key
     * @param string $name
     * @param string $status
     */
    public function __construct(
        ComicId $id,
        string $key,
        string $name,
        string $status
    ) {
        $this->id = $id;
        $this->key = $key;
        $this->name = $name;
        $this->status = $status;
    }

    /**
     * @return ComicId
     */
    public function getId(): ComicId
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
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }
}
