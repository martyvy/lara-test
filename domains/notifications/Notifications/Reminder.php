<?php

namespace Domains\Notifications\Notifications;

use Domains\Notifications\Sender;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\VonageMessage;
use Illuminate\Notifications\Slack\SlackMessage;
use NotificationChannels\MicrosoftTeams\MicrosoftTeamsMessage;
use NotificationChannels\Webhook\WebhookMessage;

class Reminder extends BaseNotification
{
    public function toMail(Sender $notifiable): MailMessage
    {
        return (new MailMessage)
            ->line('Reminder notification.')
            ->line('Params: ' . json_encode($this->message->params));
    }

    function toVonage(Sender $notifiable): VonageMessage
    {
        return (new VonageMessage)
            ->content('Reminder notification. Params: ' . json_encode($this->message->params));
    }

    function toMicrosoftTeams(Sender $notifiable): MicrosoftTeamsMessage
    {
        return MicrosoftTeamsMessage::create()
            ->type('success')
            ->title('Reminder notification.')
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
            ->text('Reminder notification.')
            ->text('Params: ' . json_encode($this->message->params));
    }
}
