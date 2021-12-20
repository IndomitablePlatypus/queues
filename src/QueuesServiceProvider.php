<?php

namespace Queues;

use Illuminate\Support\ServiceProvider;

final class QueuesServiceProvider extends ServiceProvider
{
    public static function providers(): array
    {
        return [
            self::class,

        ];
    }

    public function register()
    {
    }

    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/Api/V1/Config/Routing/api.php');
    }
}
