<?php

declare(strict_types=1);

namespace Packages\UseCase\Comic\Destroy;

interface ComicDestroyUseCaseInterface
{
    /**
     * @param ComicDestroyRequest $request
     *
     * @return ComicDestroyResponse
     */
    public function handle(ComicDestroyRequest $request): ComicDestroyResponse;
}
