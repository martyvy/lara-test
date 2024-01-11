<?php

namespace Tests\Feature;

use Domains\Notifications\Jobs\SendNotificationJob;
use Domains\Notifications\Notifications\Birthday;
use Domains\Notifications\Notifications\Invitation;
use Domains\Notifications\Notifications\Reminder;
use Domains\Notifications\Sender;
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
                'provider' => 'mail',
            ],
            [
                'channel' => 'sms',
                'type' => 'birthday',
                'params_array' => $params,
                'params' => json_encode($params),
                'notification_class' => Birthday::class,
                'queue' => 'nt:sms-queue',
                'provider' => 'vonage',
            ],
            [
                'channel' => 'slack',
                'type' => 'invitation',
                'params_array' => $params,
                'params' => json_encode($params),
                'notification_class' => Invitation::class,
                'queue' => 'nt:slack-queue',
                'provider' => 'slack',
            ],
            // TODO: add all cases
        ];

        foreach ($tests as $test) {
            Queue::fake();
            $this->artisan('notification:push', [
                    'channel' => $test['channel'],
                    'type' => $test['type'],
                    'params' => $test['params'],
                ])
                ->expectsConfirmation('Track notification?', 'no')
                ->assertSuccessful();
            Queue::assertPushed(SendNotificationJob::class, function (SendNotificationJob $job) use ($test) {
                return $job->notification::class === $test['notification_class']
                    && $job->notification->message->params == $test['params_array']
                    && $job->queue == $test['queue']
                    && in_array($test['provider'], array_keys($job->sender->routes));
            });
            Queue::assertCount(1);
        }
    }
}
