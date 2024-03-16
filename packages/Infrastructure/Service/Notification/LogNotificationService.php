<?php

declare(strict_types=1);

namespace Packages\Infrastructure\Service\Notification;

use Illuminate\Support\Facades\Log;

class LogNotificationService implements NotificationServiceInterface
{
    /**
     * @param string $message
     *
     * @return void
     */
    public function send(string $message): void
    {
        Log::info($message);
    }
}
