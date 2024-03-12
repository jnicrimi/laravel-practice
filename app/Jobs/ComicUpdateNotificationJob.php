<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Models\Comic;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Packages\Infrastructure\Service\Notification\SlackNotificationService;

class ComicUpdateNotificationJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * Create a new job instance.
     *
     * @param Comic $comic
     */
    public function __construct(public Comic $comic)
    {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $service = new SlackNotificationService();
        $message = sprintf(
            'Comic has been updated. id:%d',
            $this->comic->id,
        );
        $service->send($message);
    }
}
