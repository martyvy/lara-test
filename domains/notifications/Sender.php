<?php

namespace Domains\Notifications;

use Illuminate\Notifications\AnonymousNotifiable;

class Sender extends AnonymousNotifiable
{
    public function __construct(array $config)
    {
        $this->route($config['provider'], $config['route']);
    }

    public function providers(): array
    {
        return array_keys($this->routes);
    }
}
