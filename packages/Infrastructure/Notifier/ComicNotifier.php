<?php

declare(strict_types=1);

namespace Packages\Infrastructure\Notifier;

use App\Jobs\ComicDestroyNotificationJob;
use App\Jobs\ComicStoreNotificationJob;
use App\Jobs\ComicUpdateNotificationJob;
use Packages\Domain\Comic\Comic;

class ComicNotifier
{
    /**
     * @param Comic $comic
     *
     * @return void
     */
    public function notifyStore(Comic $comic): void
    {
        $comicAttributes = $comic->toArray();
        ComicStoreNotificationJob::dispatch($comicAttributes);
    }

    /**
     * @param Comic $comic
     *
     * @return void
     */
    public function notifyUpdate(Comic $comic): void
    {
        $comicAttributes = $comic->toArray();
        ComicUpdateNotificationJob::dispatch($comicAttributes);
    }

    /**
     * @param Comic $comic
     *
     * @return void
     */
    public function notifyDestroy(Comic $comic): void
    {
        $comicAttributes = $comic->toArray();
        ComicDestroyNotificationJob::dispatch($comicAttributes);
    }
}
