<?php

namespace Queues\Api\V1\Tests\Feature;

use Queues\Api\V1\Config\Routing\Routing;
use Queues\Tests\BaseTestCase;

class SignUpTest extends BaseTestCase
{
    public function test_sign_up_fails_on_validation()
    {
        $response = $this->post(Routing::for(Routing::SIGN_UP));
        $response->assertJsonValidationErrorFor('login');
        $response->assertJsonValidationErrorFor('password');
    }

    public function test_customer_can_sign_up()
    {
        $response = $this->post(Routing::for(Routing::SIGN_UP), [
            'login' => $this->faker->userName(),
            'password' => $this->faker->password(),
        ]);
        $response->assertSuccessful();
    }

}
