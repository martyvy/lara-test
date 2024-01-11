<?php

namespace Domains\Notifications\Enums;

enum NotificationChannels: string
{
    case EMAIL = 'email';
    case SMS = 'sms';
    case SLACK = 'slack';
    case TEAMS = 'teams';
    case WEBHOOK = 'webhook';
}
