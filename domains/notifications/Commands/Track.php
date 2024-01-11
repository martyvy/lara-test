<?php

namespace Domains\Notifications\Commands;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;

class Track extends Command
{
    protected $signature = 'notification:track {id}';

    protected $description = 'Track message';

    public function handle(): void
    {
        $id = $this->argument('id');
        $this->comment("Tracking notifications with ID: $id");
        $this->comment('Tracking...');

        try {
            Redis::subscribe(["nt:track:$id"], function($message) {
                $message = json_decode($message, true, JSON_THROW_ON_ERROR);
                if ($message['log']) {
                    $this->error($message['title']);
                    if ($this->confirm('Show trace')) {
                        dd($message['log']);
                    }
                } else {
                    $this->info($message['title']);
                    $this->info("Attempt left: {$message['attempts_left']}");
                }
                $this->line('_____________________________________');
            });
        } catch (Exception) {
            $this->line('exit');
        }
    }
}
