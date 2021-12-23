<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

class DeferredRabbitInit implements ShouldQueue
{
    protected int $retryInSeconds = 10;

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
        } catch (\Throwable $exception) {
            $this->release($this->retryInSeconds);
            Log::error('QUEUE REFUSE: ' . $exception->getMessage());
        }
    }
}
