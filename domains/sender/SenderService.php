<?php

namespace Domains\Sender;

use Domains\Sender\Enums\NotificationChannels;
use Domains\Sender\Enums\NotificationTypes;

class SenderService
{
    public function __construct(private readonly array $config = []) {}

    public function send(NotificationChannels $notificationChannel, NotificationTypes $notificationType, array $params): void
    {
        $config = $this->config[$notificationChannel->value];
        throw_unless($config);
        $sender = new Sender($config);
        $notification = app()->makeWith(
            SenderServicesProvider::NOTIFICATION_PREFIX . $notificationType->value,
            ['params' => $params, 'queueName' => $config['queue'], 'providerName' => $config['provider']]
        );
        $sender->notify($notification);
    }
}
