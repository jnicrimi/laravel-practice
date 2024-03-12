<?php

declare(strict_types=1);

namespace App\Jobs;

use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Packages\Infrastructure\Service\Notification\SlackNotificationService;

class ComicDestroyNotificationJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * Create a new job instance.
     *
     * @param array $comic
     */
    public function __construct(public array $comic)
    {
    }

    /**
     * Execute the job.
     */
    public function handle(SlackNotificationService $service): void
    {
        $message = sprintf(
            'Comic has been destroyed. id:%d',
            $this->comic['id']
        );

        try {
            $service->send($message);
        } catch (Exception $e) {
            Log::error('Failed to send notification: ', [
                'error' => $e->getMessage(),
                'send' => $message,
            ]);

            throw $e;
        }
    }
}
