<?php

declare(strict_types=1);

namespace Packages\UseCase\Comic\Show;

interface ComicShowUseCaseInterface
{
    /**
     * @param ComicShowRequest $request
     *
     * @return ComicShowResponse
     */
    public function handle(ComicShowRequest $request): ComicShowResponse;
}
