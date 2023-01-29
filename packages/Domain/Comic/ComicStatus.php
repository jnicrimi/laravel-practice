<?php

declare(strict_types=1);

namespace Packages\Domain\Comic;

class ComicStatus
{
    /**
     * @var ComicStatusCase
     */
    private $value;

    /**
     * Constructor
     *
     * @param ComicStatusCase $value
     */
    public function __construct(ComicStatusCase $value)
    {
        $this->value = $value;
    }

    /**
     * @return ComicStatusCase
     */
    public function getValue(): ComicStatusCase
    {
        return $this->value;
    }
}
