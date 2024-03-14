<?php

declare(strict_types=1);

namespace Tests\Unit\Packages\Infrastructure\Notifier;

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
use Packages\Infrastructure\Notifier\ComicNotifier;
use Tests\TestCase;

class ComicNotifierTest extends TestCase
{
    /**
     * @var ComicNotifier
     */
    private ComicNotifier $notifier;

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
        Queue::fake();
        $this->notifier = $this->app->make(ComicNotifier::class);
        $this->comic = $this->createEntity(self::$defaultAttributes);
    }

    /**
     * @return void
     */
    public function testNotifyStore(): void
    {
        $this->notifier->notifyStore($this->comic);
        Queue::assertPushed(ComicStoreNotificationJob::class, function ($job) {
            return $job->comic['id'] === 1;
        });
    }

    /**
     * @return void
     */
    public function testNotifyUpdate(): void
    {
        $this->notifier->notifyUpdate($this->comic);
        Queue::assertPushed(ComicUpdateNotificationJob::class, function ($job) {
            return $job->comic['id'] === 1;
        });
    }

    /**
     * @return void
     */
    public function testNotifyDestroy(): void
    {
        $this->notifier->notifyDestroy($this->comic);
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
