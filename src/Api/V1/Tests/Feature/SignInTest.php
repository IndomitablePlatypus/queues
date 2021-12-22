<?php

namespace Queues\Api\V1\Tests\Feature;

use App\Models\User;
use Queues\Api\V1\Config\Routing\Routing;
use Queues\Api\V1\Tests\TestApplicationTrait;
use Queues\Tests\BaseTestCase;

class SignInTest extends BaseTestCase
{
    use TestApplicationTrait;

    public function test_customer_sign_in_fails_on_validation()
    {
        $response = $this->post(Routing::SIGN_IN());
        $response->assertJsonValidationErrorFor('username');
        $response->assertJsonValidationErrorFor('password');
    }

    public function test_customer_can_sign_in()
    {
        /** @var User $user */
        $user = User::factory()->make();
        $user->save();
        $response = $this->post(Routing::SIGN_IN(), [
            'username' => $user->username,
            'password' => 'password',
        ]);
        $response->assertSuccessful();
    }

}
