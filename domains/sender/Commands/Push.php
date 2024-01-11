<?php

namespace Domains\Sender\Commands;

use Domains\Sender\Enums\NotificationChannels;
use Domains\Sender\Enums\NotificationTypes;
use Domains\Sender\SenderService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class Push extends Command
{
    protected $signature = 'sender:push {channel} {type} {params}';

    protected $description = 'Send new message';

    public function handle(SenderService $senderService)
    {
        $channel = NotificationChannels::from($this->argument('channel'));
        $type = NotificationTypes::from($this->argument('type'));
        $params = json_decode($this->argument('params'), true, flags: JSON_THROW_ON_ERROR);

        $senderService->send($channel, $type, $params);
    }
}
