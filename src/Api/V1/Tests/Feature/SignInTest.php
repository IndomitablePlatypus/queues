<?php

namespace Queues\Api\V1\Tests\Feature;

use App\Models\User;
use Queues\Api\V1\Config\Routing\RouteName;
use Queues\Api\V1\Tests\RoutingTestTrait;
use Queues\Api\V1\Tests\TestApplicationTrait;
use Queues\Tests\BaseTestCase;

class SignInTest extends BaseTestCase
{
    use TestApplicationTrait, RoutingTestTrait;

    public function test_customer_sign_in_fails_on_validation(): void
    {
        $response = $this->rPost(RouteName::GET_TOKEN);
        $response->assertJsonValidationErrorFor('username');
        $response->assertJsonValidationErrorFor('password');
    }

    public function test_customer_can_sign_in(): void
    {
        /** @var User $user */
        $user = User::factory()->make();
        $user->save();
        $response = $this->rPost(RouteName::GET_TOKEN, [
            'username' => $user->username,
            'password' => 'password',
        ]);
        $response->assertSuccessful();
    }

}
