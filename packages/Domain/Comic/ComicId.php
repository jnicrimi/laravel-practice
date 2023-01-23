<?php

declare(strict_types=1);

namespace Packages\Domain\Comic;

class ComicId
{
    /**
     * @var int
     */
    private $value;

    /**
     * Constructor
     *
     * @param int $value
     */
    public function __construct(int $value)
    {
        $this->value = $value;
    }

    /**
     * @return int
     */
    public function getValue(): int
    {
        return $this->value;
    }
}
