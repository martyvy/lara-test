<?php

namespace Domains\Notifications\Jobs;

use Domains\Notifications\NotificationJobListener;
use Domains\Notifications\Notifications\BaseNotification;
use Domains\Notifications\Sender;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Throwable;

class SendNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;

    public int $timeout = 30;

    public function __construct(
        public BaseNotification $notification,
        public Sender $sender,
    ) {}

    public function handle(): void
    {
        $this->sender->notify($this->notification);
    }

    public function failed(Throwable $e): void
    {
        NotificationJobListener::exception($e, $this->notification->id);
    }
}
