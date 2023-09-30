<?php

declare(strict_types=1);

namespace Packages\UseCase\Comic\Index;

interface ComicIndexUseCaseInterface
{
    /**
     * @param ComicIndexRequest $request
     *
     * @return ComicIndexResponse
     */
    public function handle(ComicIndexRequest $request): ComicIndexResponse;
}
