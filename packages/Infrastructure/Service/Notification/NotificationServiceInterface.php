<?php

declare(strict_types=1);

namespace Packages\Infrastructure\Service\Notification;

interface NotificationServiceInterface
{
    /**
     * @param string $message
     *
     * @return void
     */
    public function send(string $message): void;
}
