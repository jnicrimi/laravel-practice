<?php

declare(strict_types=1);

namespace Packages\Infrastructure\Service\Notification;

use App\Jobs\ComicDestroyNotificationJob;
use App\Jobs\ComicStoreNotificationJob;
use App\Jobs\ComicUpdateNotificationJob;
use Packages\Domain\Comic\Comic;
use Packages\Domain\Comic\ComicRepositoryInterface;

class ComicNotificationService
{
    /**
     * Constructor
     *
     * @param ComicRepositoryInterface $comicRepository
     */
    public function __construct(private readonly ComicRepositoryInterface $comicRepository)
    {
    }

    /**
     * @param Comic $comic
     *
     * @return void
     */
    public function notifyStore(Comic $comic): void
    {
        $model = $this->comicRepository->findModel($comic->getId());
        ComicStoreNotificationJob::dispatch($model);
    }

    /**
     * @param Comic $comic
     *
     * @return void
     */
    public function notifyUpdate(Comic $comic): void
    {
        $model = $this->comicRepository->findModel($comic->getId());
        ComicUpdateNotificationJob::dispatch($model);
    }

    /**
     * @param Comic $comic
     *
     * @return void
     */
    public function notifyDestroy(Comic $comic): void
    {
        $model = $this->comicRepository->findModel($comic->getId());
        ComicDestroyNotificationJob::dispatch($model);
    }
}
