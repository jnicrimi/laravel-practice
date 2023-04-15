<?php

declare(strict_types=1);

namespace Packages\Domain\Comic;

enum ComicStatusCase: string
{
    case PUBLISHED = 'published';
    case DRAFT = 'draft';
    case CLOSED = 'closed';
}
