<?php

namespace Domains\Notifications\Notifications;

use Domains\Notifications\DTO\Message;
use Domains\Notifications\Sender;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\VonageMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Slack\SlackMessage;
use NotificationChannels\MicrosoftTeams\MicrosoftTeamsMessage;
use NotificationChannels\Webhook\WebhookMessage;

abstract class BaseNotification extends Notification
{
    public function __construct(public Message $message)
    {}

    public function via(Sender $sender): array
    {
        return $sender->providers();
    }

    public function toArray(Sender $notifiable): array
    {
        return (array) $this->message;
    }

    abstract function toMail(Sender $notifiable): MailMessage;
    abstract function toVonage(Sender $notifiable): VonageMessage;
    abstract function toSlack(Sender $notifiable): SlackMessage;
    abstract function toMicrosoftTeams(Sender $notifiable): MicrosoftTeamsMessage;
    abstract function toWebhook(Sender $notifiable): WebhookMessage;
}
