<?php

namespace Queues\Api\V1\Tests\Feature;

use App\Models\User;
use Cardz\Support\MobileAppGateway\Config\Routes\RouteName;
use Cardz\Support\MobileAppGateway\Tests\Shared\Fixtures\UserLoginInfo;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\Sanctum;
use Queues\Api\V1\Config\Routing\Routing;
use Queues\Api\V1\Tests\TestApplicationTrait;
use Queues\Tests\BaseTestCase;

class SignOutTest extends BaseTestCase
{
    use TestApplicationTrait;

    public function test_customer_sign_out_fails_on_unauthenticated()
    {
        $response = $this->get(Routing::for(Routing::SIGN_OUT));
        $response->assertUnauthorized();
    }

    public function test_customer_can_sign_out()
    {
        /** @var User $user */
        $user = User::factory()->make();
        $user->save();

        $token = $user->createToken($this->faker->word());
        $this->withToken($token->plainTextToken);
        dd($this->defaultHeaders);

        $response = $this->get(Routing::for(Routing::SIGN_OUT));
        $response->assertSuccessful();

        /** @var Model $model */
        $model = Sanctum::$personalAccessTokenModel;
        $this->assertEmpty($model::query()->where('tokenable_id', '=', $user->id)->get());
    }

}
