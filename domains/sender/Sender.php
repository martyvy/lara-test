<?php

namespace Domains\Sender;

use Illuminate\Notifications\AnonymousNotifiable;
use JetBrains\PhpStorm\NoReturn;

class Sender extends AnonymousNotifiable
{
    #[NoReturn] public function __construct(array $config)
    {
        $this->route($config['provider'], $config['route']);
    }
}
