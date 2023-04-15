<?php

declare(strict_types=1);

namespace Packages\Domain\Comic\ComicStatusCase;

class ComicStatusCaseFactory
{
    /**
     * @param ComicStatusCaseEnum $comicStatusCaseEnum
     *
     * @return ComicStatusCaseInterface
     */
    public static function create(ComicStatusCaseEnum $comicStatusCaseEnum): ComicStatusCaseInterface
    {
        $comicStatusCase = null;
        switch ($comicStatusCaseEnum->value) {
            case ComicStatusCaseEnum::PUBLISHED->value:
                $comicStatusCase = new PublishedComicStatusCase();

                break;
            case ComicStatusCaseEnum::DRAFT->value:
                $comicStatusCase = new DraftComicStatusCase();

                break;
            case ComicStatusCaseEnum::CLOSED->value:
                $comicStatusCase = new ClosedComicStatusCase();

                break;
        }

        return $comicStatusCase;
    }
}
