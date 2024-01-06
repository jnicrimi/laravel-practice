<?php

declare(strict_types=1);

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;

class SlackNotification extends Notification
{
    use Queueable;

    /**
     * @var string
     */
    protected string $channel;

    /**
     * @var string
     */
    protected string $message;

    /**
     * Create a new notification instance.
     *
     * @param string $message
     */
    public function __construct(string $message)
    {
        $this->channel = config('slack.channel');
        $this->message = $message;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['slack'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [];
    }

    /**
     * @param object $notifiable
     *
     * @return SlackMessage
     */
    public function toSlack(object $notifiable): SlackMessage
    {
        return (new SlackMessage())
            ->to($this->channel)
            ->content($this->message);
    }
}
