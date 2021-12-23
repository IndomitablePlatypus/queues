<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

class DeferredRabbitInit implements ShouldQueue, ShouldBeUnique
{
    public $backoff = 5;

    public $tries = 20;

    public $uniqueFor = 100;

    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct()
    {
    }

    public function handle(): void
    {
        try {
            $name = config('queue.connections.rabbitmq.queue');
            Artisan::call('rabbitmq:queue-declare', ['name' => $name]);
            Log::info('QUEUE CONNECT: ' . $name);
            $this->delete();
        } catch (\Throwable $exception) {
            Log::error('QUEUE REFUSE: ' . $exception->getMessage());
            throw $exception;
        }
    }
}
