<?php

declare(strict_types=1);

namespace Packages\Domain\Comic;

class Comic
{
    /**
     * @var int
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
     * @param int $id
     * @param string $key
     * @param string $name
     */
    public function __construct(
        int $id,
        string $key,
        string $name
    ) {
        $this->id = $id;
        $this->key = $key;
        $this->name = $name;
    }

    /**
     * @return int
     */
    public function getId(): int
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
