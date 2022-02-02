<?php

namespace Queues\Api\V1\Tests\Feature\Customer;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\Sanctum;
use Queues\Api\V1\Config\Routing\RouteName;
use Queues\Api\V1\Tests\RoutingTestTrait;
use Queues\Api\V1\Tests\TestApplicationTrait;
use Queues\Tests\BaseTestCase;

class ClearTokensTest extends BaseTestCase
{
    use TestApplicationTrait, RoutingTestTrait;

    public function test_customer_sign_out_fails_on_unauthenticated(): void
    {
        $response = $this->rGet(RouteName::CLEAR_TOKENS);
        $response->assertUnauthorized();
    }

    public function test_customer_can_sign_out(): void
    {
        /** @var User $user */
        $user = User::factory()->make();
        $user->save();
        $this->tokenize($user);

        $response = $this->rGet(RouteName::CLEAR_TOKENS);
        $response->assertSuccessful();

        /** @var Model $model */
        $model = Sanctum::$personalAccessTokenModel;
        $this->assertEmpty($model::query()->where('tokenable_id', '=', $user->id)->get());
    }

}
