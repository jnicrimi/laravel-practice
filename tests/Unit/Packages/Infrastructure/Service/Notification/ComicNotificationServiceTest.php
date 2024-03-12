<?php

declare(strict_types=1);

namespace Tests\Unit\Packages\Infrastructure\Service\Notification;

use App\Jobs\ComicDestroyNotificationJob;
use App\Jobs\ComicStoreNotificationJob;
use App\Jobs\ComicUpdateNotificationJob;
use Illuminate\Support\Facades\Queue;
use Packages\Domain\Comic\ComicId;
use Packages\Infrastructure\Repository\Comic\ComicRepository;
use Packages\Infrastructure\Service\Notification\ComicNotificationService;
use Tests\TestCase;

class ComicNotificationServiceTest extends TestCase
{
    /**
     * @var ComicNotificationService
     */
    private ComicNotificationService $service;

    /**
     * @var ComicRepository
     */
    private ComicRepository $comicRepository;

    /**
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->service = $this->app->make(ComicNotificationService::class);
        $this->comicRepository = $this->app->make(ComicRepository::class);
    }

    /**
     * @return void
     */
    public function testNotifyStore(): void
    {
        Queue::fake();
        $comic = $this->comicRepository->find(new ComicId(1));
        $this->service->notifyStore($comic);
        Queue::assertPushed(ComicStoreNotificationJob::class, function ($job) {
            return $job->comic->id === 1;
        });
    }

    /**
     * @return void
     */
    public function testNotifyUpdate(): void
    {
        Queue::fake();
        $comic = $this->comicRepository->find(new ComicId(1));
        $this->service->notifyUpdate($comic);
        Queue::assertPushed(ComicUpdateNotificationJob::class, function ($job) {
            return $job->comic->id === 1;
        });
    }

    /**
     * @return void
     */
    public function testNotifyDestroy(): void
    {
        Queue::fake();
        $comic = $this->comicRepository->find(new ComicId(1));
        $this->service->notifyDestroy($comic);
        Queue::assertPushed(ComicDestroyNotificationJob::class, function ($job) {
            return $job->comic->id === 1;
        });
    }
}
