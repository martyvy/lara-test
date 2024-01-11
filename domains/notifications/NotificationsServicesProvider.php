<?php

namespace Domains\Notifications;

use Domains\Notifications\Commands\Push;
use Domains\Notifications\Commands\Track;
use Domains\Notifications\Jobs\SendNotificationJob;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Queue\Events\JobFailed;
use Illuminate\Queue\Events\JobProcessed;
use Illuminate\Queue\Events\JobProcessing;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\ServiceProvider;

class NotificationsServicesProvider extends ServiceProvider implements DeferrableProvider
{
    public function register(): void
    {
        $this->app->bind(
            NotificationDispatcher::class,
            fn(Application $app) => new NotificationDispatcher(config('notifications'))
        );
        $this->commands([
            Push::class,
            Track::class,
        ]);
    }
    public function boot(): void
    {
        Queue::before(function (JobProcessing $event) {
            if ($event->job->payload()['displayName'] == SendNotificationJob::class) {
                NotificationJobListener::before($event->job);
            }
        });

        Queue::after(function (JobProcessed $event) {
            if ($event->job->payload()['displayName'] == SendNotificationJob::class) {
                NotificationJobListener::after($event->job);
            }
        });
        Queue::failing(function (JobFailed $event) {
            if ($event->job->payload()['displayName'] == SendNotificationJob::class) {
                NotificationJobListener::fail($event->job);
            }
        });
    }

    public function provides(): array
    {
        return [NotificationDispatcher::class, Push::class, Track::class];
    }


}
