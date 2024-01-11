<?php

namespace Domains\Notifications\DTO;

use Domains\Notifications\Enums\NotificationChannels;
use Domains\Notifications\Enums\NotificationTypes;

class Message
{
    public readonly NotificationTypes $type;
    public readonly NotificationChannels $channel;
    public readonly array $params;
    public function __construct(
        string $type,
        string $channel,
        array $params,
    )
    {
        $this->type = NotificationTypes::from($type);
        $this->channel = NotificationChannels::from($channel);
        $this->params = $params;
    }
}
