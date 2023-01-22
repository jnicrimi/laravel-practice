<?php

declare(strict_types=1);

namespace Packages\Domain\Comic;

interface ComicRepositoryInterface
{
    /**
     * @param Comic $comic
     *
     * @return Comic|null
     */
    public function find(Comic $comic): ?Comic;

    /**
     * @param Comic $comic
     *
     * @return void
     */
    public function save(Comic $comic): void;
}
