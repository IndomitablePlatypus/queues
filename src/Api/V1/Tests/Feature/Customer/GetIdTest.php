<?php

namespace Queues\Api\V1\Tests\Feature\Customer;

use App\Models\User;
use Queues\Api\V1\Config\Routing\RouteName;
use Queues\Api\V1\Tests\RoutingTestTrait;
use Queues\Api\V1\Tests\TestApplicationTrait;
use Queues\Tests\BaseTestCase;

class GetIdTest extends BaseTestCase
{
    use TestApplicationTrait, RoutingTestTrait;

    public function test_customer_can_get_id(): void
    {
        /** @var User $user */
        $user = User::factory()->make();
        $user->save();
        $this->tokenize($user);

        $response = $this->rGet(RouteName::CUSTOMER_ID);
        $response->assertSuccessful();
        $this->assertEquals($user->id, $response->json());
    }

}
