<?php

namespace Queues\Api\V1\Tests\Feature;

use Queues\Api\V1\Config\Routing\Routing;
use Queues\Api\V1\Tests\RoutingTestTrait;
use Queues\Api\V1\Tests\TestApplicationTrait;
use Queues\Tests\BaseTestCase;

class SignUpTest extends BaseTestCase
{
    use TestApplicationTrait, RoutingTestTrait;

    public function test_customer_sign_up_fails_on_validation(): void
    {
        $response = $this->rPost(Routing::SIGN_UP);
        $response->assertJsonValidationErrorFor('username');
        $response->assertJsonValidationErrorFor('password');
        $response->assertJsonValidationErrorFor('name');
    }

    public function test_customer_can_sign_up(): void
    {
        $response = $this->rPost(Routing::SIGN_UP, [
            'username' => $this->faker->userName(),
            'password' => $this->faker->password(),
            'name' => $this->faker->name(),
        ]);
        $response->assertSuccessful();
    }

}
