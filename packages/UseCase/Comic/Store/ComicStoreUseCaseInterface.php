<?php

declare(strict_types=1);

namespace Packages\UseCase\Comic\Store;

interface ComicStoreUseCaseInterface
{
    /**
     * @param ComicStoreRequest $request
     *
     * @return ComicStoreResponse
     */
    public function handle(ComicStoreRequest $request): ComicStoreResponse;
}
