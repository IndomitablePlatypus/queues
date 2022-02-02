<?php

namespace Queues\Api\V1\Tests\Feature\Customer;

use Queues\Api\V1\Config\Routing\RouteName;
use Queues\Api\V1\Tests\RoutingTestTrait;
use Queues\Api\V1\Tests\TestApplicationTrait;
use Queues\Tests\BaseTestCase;

class RegisterTest extends BaseTestCase
{
    use TestApplicationTrait, RoutingTestTrait;

    public function test_customer_registration_fails_on_validation(): void
    {
        $response = $this->rPost(RouteName::REGISTER);
        $response->assertJsonValidationErrorFor('phone');
        $response->assertJsonValidationErrorFor('password');
        $response->assertJsonValidationErrorFor('deviceName');
    }

    public function test_customer_can_register(): void
    {
        $response = $this->rPost(RouteName::REGISTER, [
            'phone' => $this->faker->phoneNumber(),
            'password' => $this->faker->password(),
            'name' => $this->faker->name(),
            'deviceName' => $this->faker->word(),
        ]);
        $response->assertSuccessful();
    }

}
