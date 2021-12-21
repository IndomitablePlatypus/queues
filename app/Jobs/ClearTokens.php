<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Queues\Api\V1\Application\Services\ClearTokenService;

class ClearTokens implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        protected User $user,
        protected ?string $tokenName = null,
    ) {
    }

    public function handle(ClearTokenService $clearTokenService): void
    {
        $userId = $this->user->id;
        Log::info(sprintf('ClearTokens: user %s, tokenName: %s', $userId, $this->tokenName));

        $this->tokenName
            ? $clearTokenService->deleteOldTokens($this->user, $this->tokenName)
            : $clearTokenService->deleteAllTokens($this->user);
    }
}
