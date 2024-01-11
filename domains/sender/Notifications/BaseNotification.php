<?php

namespace Domains\Sender\Notifications;

use Domains\Sender\Sender;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\VonageMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Slack\SlackMessage;
use Illuminate\Support\Facades\Log;
use JetBrains\PhpStorm\NoReturn;
use NotificationChannels\MicrosoftTeams\MicrosoftTeamsMessage;
use NotificationChannels\Webhook\WebhookMessage;

abstract class BaseNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public int $tries = 3;

    public int $timeout = 30;

    public function __construct(
        public array $params,
        public string $queueName,
        public string $providerName
    ) {

    }

    public function via(Sender $notifiable): array
    {
        return [$this->providerName];
    }

    public function viaQueues(): array
    {
        return [$this->providerName => $this->queueName];
    }

    #[NoReturn] public function failed(Exception $e): void
    {
        Log::error($e);
    }

    abstract function toMail(Sender $notifiable): MailMessage;
    abstract function toVonage(Sender $notifiable): VonageMessage;
    abstract function toSlack(Sender $notifiable): SlackMessage;
    abstract function toMicrosoftTeams(Sender $notifiable): MicrosoftTeamsMessage;
    abstract function toWebhook(Sender $notifiable): WebhookMessage;
}
