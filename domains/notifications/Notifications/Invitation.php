<?php

namespace Domains\Notifications\Notifications;

use Domains\Notifications\Sender;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\VonageMessage;
use Illuminate\Notifications\Slack\SlackMessage;
use NotificationChannels\MicrosoftTeams\MicrosoftTeamsMessage;
use NotificationChannels\Webhook\WebhookMessage;

class Invitation extends BaseNotification
{
    public function toMail(Sender $notifiable): MailMessage
    {
        return (new MailMessage)
            ->line('Invitation notification.')
            ->line('Params: ' . json_encode($this->message->params));
    }

    function toVonage(Sender $notifiable): VonageMessage
    {
        return (new VonageMessage)
            ->content('Invitation notification. Params: ' . json_encode($this->message->params));
    }

    function toMicrosoftTeams(Sender $notifiable): MicrosoftTeamsMessage
    {
        return MicrosoftTeamsMessage::create()
            ->type('success')
            ->title('Invitation notification.')
            ->content('Params: ' . json_encode($this->message->params));
    }

    function toWebhook(Sender $notifiable): WebhookMessage
    {
        return WebhookMessage::create()
            ->data($this->message->params);
    }

    function toSlack(Sender $notifiable): SlackMessage
    {
        return (new SlackMessage)
            ->text('Invitation notification.')
            ->text('Params: ' . json_encode($this->message->params));
    }
}
