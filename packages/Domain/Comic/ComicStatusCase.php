<?php

declare(strict_types=1);

namespace Packages\Domain\Comic;

enum ComicStatusCase: string
{
    case PUBLISH = 'publish';
    case DRAFT = 'draft';
    case PRIVATE = 'private';
}
