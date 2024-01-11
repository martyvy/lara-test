<?php

use Domains\Notifications\Enums\NotificationChannels;
use Domains\Notifications\Enums\NotificationTypes;
use Domains\Notifications\Notifications\Birthday;
use Domains\Notifications\Notifications\Invitation;
use Domains\Notifications\Notifications\Reminder;
use NotificationChannels\MicrosoftTeams\MicrosoftTeamsChannel;
use NotificationChannels\Webhook\WebhookChannel;

return [
    'channels' => [
        NotificationChannels::EMAIL->value => [
            'provider' => 'mail',
            'queue' => 'nt:mail-queue',
            'connection' => 'redis',
            'route' => env('NT_EMAIL_ADDRESS')
        ],
        NotificationChannels::SMS->value => [
            'provider' => 'vonage',
            'queue' => 'nt:sms-queue',
            'connection' => 'redis',
            'route' => env('NT_PHONE_NUMBER')
        ],
        NotificationChannels::SLACK->value=> [
            'provider' => 'slack',
            'queue' => 'nt:slack-queue',
            'connection' => 'redis',
            'route' => env('NT_SLACK_CHANNEL')
        ],
        NotificationChannels::TEAMS->value => [
            'provider' => MicrosoftTeamsChannel::class,
            'queue' => 'nt:teams-queue',
            'connection' => 'redis',
            'route' => null
        ],
        NotificationChannels::WEBHOOK->value => [
            'provider' => WebhookChannel::class,
            'queue' => 'nt:webhook-queue',
            'connection' => 'redis',
            'route' => env('NT_WEBHOOK_URL')
        ],
    ],
    'types' => [
        NotificationTypes::REMINDER->value => [
            'notification' => Reminder::class,
        ],
        NotificationTypes::BIRTHDAY->value => [
            'notification' => Birthday::class,
        ],
        NotificationTypes::INVITATION->value => [
            'notification' => Invitation::class,
        ],
    ],
];
