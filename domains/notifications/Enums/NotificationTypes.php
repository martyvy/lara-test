<?php

namespace Domains\Notifications\Enums;

enum NotificationTypes: string
{
    case BIRTHDAY = 'birthday';
    case REMINDER = 'reminder';
    case INVITATION = 'invitation';
}
