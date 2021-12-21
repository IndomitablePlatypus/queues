<?php

namespace Queues\Api\V1\Application\Services;

use App\Models\User;
use Codderz\Platypus\Infrastructure\Support\ArrayPresenterTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\Sanctum;

class ClearTokenService
{
    use ArrayPresenterTrait;

    public function deleteAllTokens(User $user)
    {
        $this->query()
            ->where('tokenable_id', '=', $user->id)
            ->delete();
    }

    public function deleteOldTokens(User $user, string $tokenName): void
    {
        $tokenId = $this->query()
            ->where('tokenable_id', '=', $user->id)
            ->where('name', '=', $tokenName)
            ->latest()
            ->first()
            ?->id;

        if ($tokenId === null) {
            return;
        }

        $this->query()
            ->where('tokenable_id', '=', $user->id)
            ->where('name', '=', $tokenName)
            ->whereKeyNot($tokenId)
            ->delete();
    }

    protected function query(): Builder
    {
        /** @var Model $tokenModel */
        $tokenModel = Sanctum::$personalAccessTokenModel;
        return $tokenModel::query();
    }
}
