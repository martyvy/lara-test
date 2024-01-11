<?php

namespace Domains\Sender\Notifications;

use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\VonageMessage;
use Illuminate\Notifications\Slack\SlackMessage;
use NotificationChannels\MicrosoftTeams\MicrosoftTeamsMessage;
use NotificationChannels\Webhook\WebhookMessage;

class Invitation extends BaseNotification
{
    public function toMail(AnonymousNotifiable $notifiable): MailMessage
    {
        return (new MailMessage)
            ->line('Invitation notification.')
            ->line('Params: ' . json_encode($this->params));
    }

    function toVonage(AnonymousNotifiable $notifiable): VonageMessage
    {
        return (new VonageMessage)
            ->content('Invitation notification. Params: ' . json_encode($this->params));
    }

    function toMicrosoftTeams(AnonymousNotifiable $notifiable): MicrosoftTeamsMessage
    {
        return MicrosoftTeamsMessage::create()
            ->type('success')
            ->title('Invitation notification.')
            ->content('Params: ' . json_encode($this->params));
    }

    function toWebhook(AnonymousNotifiable $notifiable): WebhookMessage
    {
        return WebhookMessage::create()
            ->data($this->params);
    }

    function toSlack(AnonymousNotifiable $notifiable): SlackMessage
    {
        return (new SlackMessage)
            ->text('Invitation notification.')
            ->text('Params: ' . json_encode($this->params));
    }
}
