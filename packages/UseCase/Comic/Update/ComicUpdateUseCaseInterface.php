<?php

declare(strict_types=1);

namespace Packages\UseCase\Comic\Update;

interface ComicUpdateUseCaseInterface
{
    /**
     * @param ComicUpdateRequest $request
     *
     * @return ComicUpdateResponse
     */
    public function handle(ComicUpdateRequest $request): ComicUpdateResponse;
}
