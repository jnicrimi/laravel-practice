<?php

declare(strict_types=1);

namespace Packages\UseCase\Comic\Create;

interface ComicCreateUseCaseInterface
{
    /**
     * @param ComicCreateRequest $request
     *
     * @return ComicCreateResponse
     */
    public function handle(ComicCreateRequest $request): ComicCreateResponse;
}
