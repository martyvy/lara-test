<?php

namespace Domains\Notifications\Commands;

use Domains\Notifications\DTO\Message;
use Domains\Notifications\NotificationDispatcher;
use Illuminate\Console\Command;

class Push extends Command
{
    protected $signature = 'notification:push {channel} {type} {params}';

    protected $description = 'Send new message';

    public function handle(NotificationDispatcher $notificationDispatcher): void
    {
        $message = new Message(
            $this->argument('type'),
            $this->argument('channel'),
            json_decode($this->argument('params'), true, JSON_THROW_ON_ERROR),
        );
        $id = $notificationDispatcher->dispatch($message);

        $this->info("Notification added to queue. Notification ID: $id");
        if ($this->confirm('Track notification?')) {
            $this->call(Track::class, ['id' => $id]);
        }

    }
}
