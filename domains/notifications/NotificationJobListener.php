<?php

namespace Domains\Notifications;


use Domains\Notifications\Jobs\SendNotificationJob;
use Illuminate\Contracts\Queue\Job;
use Illuminate\Support\Facades\Redis;
use Throwable;

class NotificationJobListener
{
    public static function before(Job $job): void
    {
        self::appendNotificationLog($job, 'Job started');

    }

    public static function after(Job $job): void
    {
        self::appendNotificationLog($job, 'Job finished');
    }

    public static function fail(Job $job): void
    {
        self::appendNotificationLog($job, 'Job failed');
    }

    public static function exception(Throwable $exception, string $id)
    {
        Redis::publish("nt:track:$id", json_encode([
            'title' => $exception->getMessage(),
            'attempts_left' => 'N/A',
            'log' => $exception->getTrace()
        ]));
    }

    private static function appendNotificationLog(Job $job, string $title)
    {
        $payload = $job->payload();
        /** @var SendNotificationJob $command */
        $command = unserialize($payload['data']['command']);
        $id = $command->notification->id;

        Redis::publish("nt:track:$id", json_encode([
            'title' => $title,
            'attempts_left' => $payload['maxTries'] - $payload['attempts'],
            'log' => ''
        ]));
    }
}
