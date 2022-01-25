<?php

namespace Queues\Api\V1\Tests\Feature;

use App\Models\User;
use Queues\Api\V1\Config\Routing\RouteName;
use Queues\Api\V1\Tests\RoutingTestTrait;
use Queues\Api\V1\Tests\TestApplicationTrait;
use Queues\Tests\BaseTestCase;

class GetTokenTest extends BaseTestCase
{
    use TestApplicationTrait, RoutingTestTrait;

    public function test_customer_get_token_fails_on_validation(): void
    {
        $response = $this->rPost(RouteName::GET_TOKEN);
        $response->assertJsonValidationErrorFor('identity');
        $response->assertJsonValidationErrorFor('password');
        $response->assertJsonValidationErrorFor('deviceName');
    }

    public function test_customer_can_get_token(): void
    {
        /** @var User $user */
        $user = User::factory()->make();
        $user->save();
        $response = $this->rPost(RouteName::GET_TOKEN, [
            'identity' => $user->username,
            'password' => User::factory()->password,
            'deviceName' => $this->faker->word(),
        ]);
        $response->assertSuccessful();
    }

}
