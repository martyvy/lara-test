<?php

use Domains\Sender\Enums\NotificationChannels;
use Illuminate\Notifications\Channels\MailChannel;
use Illuminate\Notifications\Channels\VonageSmsChannel;
use Illuminate\Notifications\Slack\SlackChannel;
use NotificationChannels\MicrosoftTeams\MicrosoftTeamsChannel;
use NotificationChannels\Webhook\WebhookChannel;

return [
    NotificationChannels::EMAIL->value => [
        'provider' => MailChannel::class,
        'queue' => 'nt:mail-queue',
        'route' => env('NT_EMAIL_ADDRESS')
    ],
    NotificationChannels::SMS->value => [
        'provider' => SlackChannel::class,
        'queue' => 'nt:sms-queue',
        'route' => env('NT_PHONE_NUMBER')
    ],
    NotificationChannels::SLACK->value=> [
        'provider' => VonageSmsChannel::class,
        'queue' => 'nt:slack-queue',
        'route' => env('NT_SLACK_CHANNEL')
    ],
    NotificationChannels::TEAMS->value => [
        'provider' => MicrosoftTeamsChannel::class,
        'queue' => 'nt:teams-queue',
        'route' => null
    ],
    NotificationChannels::WEBHOOK->value => [
        'provider' => WebhookChannel::class,
        'queue' => 'nt:webhook-queue',
        'route' => env('NT_WEBHOOK_URL')
    ],
];
