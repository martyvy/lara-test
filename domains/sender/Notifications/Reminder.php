<?php

namespace Domains\Sender\Notifications;

use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\VonageMessage;
use Illuminate\Notifications\Slack\SlackMessage;
use NotificationChannels\MicrosoftTeams\MicrosoftTeamsMessage;
use NotificationChannels\Webhook\WebhookMessage;

class Reminder extends BaseNotification
{
    public function toMail(AnonymousNotifiable $notifiable): MailMessage
    {
        return (new MailMessage)
            ->line('Reminder notification.')
            ->line('Params: ' . json_encode($this->params));
    }

    function toVonage(AnonymousNotifiable $notifiable): VonageMessage
    {
        return (new VonageMessage)
            ->content('Reminder notification. Params: ' . json_encode($this->params));
    }

    function toMicrosoftTeams(AnonymousNotifiable $notifiable): MicrosoftTeamsMessage
    {
        return MicrosoftTeamsMessage::create()
            ->type('success')
            ->title('Reminder notification.')
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
            ->text('Reminder notification.')
            ->text('Params: ' . json_encode($this->params));
    }
}
