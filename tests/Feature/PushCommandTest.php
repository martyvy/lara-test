<?php

namespace Tests\Feature;

use Domains\Sender\Notifications\Reminder;
use Illuminate\Notifications\Channels\MailChannel;
use Illuminate\Notifications\SendQueuedNotifications;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class PushCommandTest extends TestCase
{
    public function test_flow(): void
    {
        $params = ["some_params" => [1,2,3], "body_message" => "ReminderMessage"];
        $tests = [
            [
                'channel' => 'email',
                'type' => 'reminder',
                'params_array' => $params,
                'params' => json_encode($params),
                'notification_class' => Reminder::class,
                'queue' => 'nt:mail-queue',
                'provider' => MailChannel::class,
            ],
            // TODO: add all cases
        ];

        Queue::fake();

        foreach ($tests as $test) {
            $this->artisan('sender:push', [
                    'channel' => $test['channel'],
                    'type' => $test['type'],
                    'params' => $test['params'],
                ])
                ->assertSuccessful();
            Queue::assertPushed(SendQueuedNotifications::class, function (SendQueuedNotifications $job) use ($test) {
                return $job->notification::class === $test['notification_class']
                    && $job->notification->params == $test['params_array']
                    && $job->notification->queueName == $test['queue']
                    && $job->notification->providerName == $test['provider'];
            });
            Queue::assertCount(1);
        }
    }
}
