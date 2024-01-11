<?php

namespace Domains\Sender;

use Domains\Sender\Commands\Push;
use Domains\Sender\Enums\NotificationTypes;
use Domains\Sender\Notifications\Birthday;
use Domains\Sender\Notifications\Invitation;
use Domains\Sender\Notifications\Reminder;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class SenderServicesProvider extends ServiceProvider implements DeferrableProvider
{
    public const NOTIFICATION_PREFIX = 'nt:';

    public function register(): void
    {
        $this->app->bind(
            SenderService::class,
            fn(Application $app) => new SenderService(config('notifications'))
        );

        $this->app->bind(
            self::NOTIFICATION_PREFIX . NotificationTypes::BIRTHDAY->value,
            fn(Application $app, array $params) => $app->make(Birthday::class, $params)
        );
        $this->app->bind(
            self::NOTIFICATION_PREFIX . NotificationTypes::REMINDER->value,
            fn(Application $app, array $params) => $app->make(Reminder::class, $params)
        );
        $this->app->bind(
            self::NOTIFICATION_PREFIX . NotificationTypes::INVITATION->value,
            fn(Application $app, array $params) => $app->make(Invitation::class, $params)
        );

        $this->commands([
            Push::class,
        ]);
    }
    public function boot(): void
    {

    }

    public function provides(): array
    {
        return [SenderService::class, Birthday::class, Reminder::class, Invitation::class, Push::class];
    }
}
