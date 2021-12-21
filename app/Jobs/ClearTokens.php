<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Laravel\Sanctum\Sanctum;

class ClearTokens implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        protected User $user,
        protected string $tokenName,
    ) {
    }

    public function handle(): void
    {
        $userId = $this->user->id;
        Log::info(sprintf('ClearTokens: user %s, tokenName: %s', $userId, $this->tokenName));

        /** @var Model $tokenModel */
        $tokenModel = Sanctum::$personalAccessTokenModel;
        $tokenId = $tokenModel::query()
            ->where('tokenable_id', '=', $userId)
            ->where('name', '=', $this->tokenName)
            ->latest()
            ->first()
            ?->id;

        if ($tokenId === null) {
            return;
        }

        $tokenModel::query()
            ->where('tokenable_id', '=', $userId)
            ->where('name', '=', $this->tokenName)
            ->whereKeyNot($tokenId)
            ->delete();
    }
}
