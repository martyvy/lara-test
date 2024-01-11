<?php

namespace Domains\Notifications;

use Domains\Notifications\DTO\Message;
use Domains\Notifications\Jobs\SendNotificationJob;
use Domains\Notifications\Notifications\BaseNotification;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Str;

class NotificationDispatcher
{
    public function __construct(private readonly array $config)
    {}

    public function dispatch(Message $message): string
    {
        $notification = $this->getNotification($message);

        SendNotificationJob::dispatch(
            $notification,
            $this->getSender($message),
        )
            ->onConnection($this->getConnections($message))
            ->onQueue($this->getQueue($message));

        return $notification->id;
    }

    private function getConnections(Message $message): string
    {
        return $this->config['channels'][$message->channel->value]['connection'];
    }

    private function getQueue(Message $message): string
    {
        return $this->config['channels'][$message->channel->value]['queue'];
    }

    private function getNotification(Message $message): BaseNotification
    {
        $notifications = app()->makeWith(
            $this->config['types'][$message->type->value]['notification'],
            ['message' => $message]
        );
        $notifications->id = Str::uuid();

        return $notifications;
    }

    private function getSender(Message $message): Sender
    {
        return new Sender($this->config['channels'][$message->channel->value]);
    }
}
