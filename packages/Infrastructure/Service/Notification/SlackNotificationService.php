<?php

declare(strict_types=1);

namespace Packages\Infrastructure\Service\Notification;

use App\Notifications\SlackNotification;
use Illuminate\Notifications\Notifiable;

class SlackNotificationService implements NotificationServiceInterface
{
    use Notifiable;

    /**
     * @param string $message
     *
     * @return void
     */
    public function send(string $message): void
    {
        $this->notify(new SlackNotification($message));
    }

    /**
     * @return string
     */
    protected function routeNotificationForSlack(): string
    {
        return config('slack.webhook_url');
    }

    /**
     * @return void
     */
    public function getKey(): void
    {
    }
}
