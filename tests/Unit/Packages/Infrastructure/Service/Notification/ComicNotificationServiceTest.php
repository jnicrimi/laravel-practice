<?php

declare(strict_types=1);

namespace Tests\Unit\Packages\Infrastructure\Service\Notification;

use App\Jobs\ComicDestroyNotificationJob;
use App\Jobs\ComicStoreNotificationJob;
use App\Jobs\ComicUpdateNotificationJob;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Queue;
use Packages\Domain\Comic\Comic;
use Packages\Domain\Comic\ComicId;
use Packages\Domain\Comic\ComicKey;
use Packages\Domain\Comic\ComicName;
use Packages\Domain\Comic\ComicStatus;
use Packages\Infrastructure\Service\Notification\ComicNotificationService;
use Tests\TestCase;

class ComicNotificationServiceTest extends TestCase
{
    /**
     * @var ComicNotificationService
     */
    private ComicNotificationService $service;

    /**
     * @var Comic
     */
    private $comic;

    /**
     * @var array
     */
    private static array $defaultAttributes = [
        'id' => 1,
        'key' => 'key',
        'name' => 'name',
        'status' => 'published',
        'created_at' => '2023-01-01 00:00:00',
        'updated_at' => '2023-12-31 23:59:59',
    ];

    /**
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->service = $this->app->make(ComicNotificationService::class);
        $this->comic = $this->createEntity(self::$defaultAttributes);
    }

    /**
     * @return void
     */
    public function testNotifyStore(): void
    {
        Queue::fake();
        $this->service->notifyStore($this->comic);
        Queue::assertPushed(ComicStoreNotificationJob::class, function ($job) {
            return $job->comic['id'] === 1;
        });
    }

    /**
     * @return void
     */
    public function testNotifyUpdate(): void
    {
        Queue::fake();
        $this->service->notifyUpdate($this->comic);
        Queue::assertPushed(ComicUpdateNotificationJob::class, function ($job) {
            return $job->comic['id'] === 1;
        });
    }

    /**
     * @return void
     */
    public function testNotifyDestroy(): void
    {
        Queue::fake();
        $this->service->notifyDestroy($this->comic);
        Queue::assertPushed(ComicDestroyNotificationJob::class, function ($job) {
            return $job->comic['id'] === 1;
        });
    }

    /**
     * @param array $attributes
     *
     * @return Comic
     */
    private function createEntity(array $attributes): Comic
    {
        return new Comic(
            Arr::get($attributes, 'id') ? new ComicId(Arr::get($attributes, 'id')) : null,
            new ComicKey(Arr::get($attributes, 'key')),
            new ComicName(Arr::get($attributes, 'name')),
            ComicStatus::from(Arr::get($attributes, 'status')),
            Carbon::parse(Arr::get($attributes, 'created_at')),
            Carbon::parse(Arr::get($attributes, 'updated_at'))
        );
    }
}
