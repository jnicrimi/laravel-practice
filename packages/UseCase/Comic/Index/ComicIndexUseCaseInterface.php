<?php

declare(strict_types=1);

namespace Packages\UseCase\Comic\Index;

interface ComicIndexUseCaseInterface
{
    /**
     * @return ComicIndexResponse
     */
    public function handle(): ComicIndexResponse;
}
