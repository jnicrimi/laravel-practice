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
     * Constructor
     *
     * @param ComicId $id
     * @param string $key
     * @param string $name
     */
    public function __construct(
        ComicId $id,
        string $key,
        string $name
    ) {
        $this->id = $id;
        $this->key = $key;
        $this->name = $name;
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
}
