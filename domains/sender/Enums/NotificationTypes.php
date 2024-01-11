<?php

namespace Domains\Sender\Enums;

enum NotificationTypes: string
{
    case BIRTHDAY = 'birthday';
    case REMINDER = 'reminder';
    case INVITATION = 'invitation';
}
