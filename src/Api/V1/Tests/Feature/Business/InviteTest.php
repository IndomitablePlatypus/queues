<?php

namespace Feature\Business;

use App\Jobs\EstablishRelation;
use App\Models\User;
use App\Models\Workspace;
use Queues\Api\V1\Config\Routing\Routing;
use Queues\Api\V1\Domain\RelationType;
use Queues\Api\V1\Tests\RoutingTestTrait;
use Queues\Api\V1\Tests\TestApplicationTrait;
use Queues\Tests\BaseTestCase;

class InviteTest extends BaseTestCase
{
    use TestApplicationTrait, RoutingTestTrait;


    public function test_keeper_can_invite()
    {
        /** @var User $user */
        $user = User::factory()->make();
        $workspace = Workspace::factory()->make(['keeper_id' => $user->id]);
        $user->save();
        $workspace->save();
        EstablishRelation::dispatchSync($user->id, $workspace->id, RelationType::KEEPER());
        $this->tokenize($user);

        $response = $this->rPost(Routing::INVITE_PROPOSE(), ['workspaceId' => $workspace->id]);
        $response->assertSuccessful();
    }
}
