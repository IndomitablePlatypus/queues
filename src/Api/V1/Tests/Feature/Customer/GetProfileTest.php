<?php

namespace Queues\Api\V1\Tests\Feature\Customer;

use App\Models\User;
use Queues\Api\V1\Config\Routing\RouteName;
use Queues\Api\V1\Tests\RoutingTestTrait;
use Queues\Api\V1\Tests\TestApplicationTrait;
use Queues\Tests\BaseTestCase;

class GetProfileTest extends BaseTestCase
{
    use TestApplicationTrait, RoutingTestTrait;

    public function test_customer_can_get_profile(): void
    {
        /** @var User $user */
        $user = User::factory()->make();
        $user->save();
        $this->tokenize($user);

        $response = $this->rGet(RouteName::CUSTOMER_PROFILE);
        $response->assertSuccessful();
        $this->assertEquals($user->id, $response->json('profileId'));
        $this->assertEquals($user->name, $response->json('name'));
        $this->assertEquals($user->username, $response->json('identity'));
    }

}
