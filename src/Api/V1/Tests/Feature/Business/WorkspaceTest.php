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

class WorkspaceTest extends BaseTestCase
{
    use TestApplicationTrait, RoutingTestTrait;

    public function test_workspace_can_be_added(): void
    {

        /** @var User $user */
        $user = User::factory()->make();
        $user->save();
        $this->tokenize($user);

        /** @var Workspace $workspace */
        $workspace = Workspace::factory()->make(['keeper_id' => $user->id]);
        $response = $this->rPost(Routing::WORKSPACES_ADD, $workspace->profile);
        $response->assertSuccessful();
        $workspaceId = $response->json('workspace_id');

        $workspace = Workspace::query()->find($workspaceId);
        $this->assertEquals($user->id, $workspace->keeper_id);
    }

    public function test_workspace_profile_can_be_updated(): void
    {
        /** @var User $user */
        $user = User::factory()->make();
        $workspace = Workspace::factory()->make(['keeper_id' => $user->id]);
        $user->save();
        $workspace->save();
        EstablishRelation::dispatchSync($user->id, $workspace->id, RelationType::KEEPER());
        $this->tokenize($user);

        $profile = array_merge($workspace->profile, ['description' => 'changed']);
        $response = $this->rPut(Routing::WORKSPACES_CHANGE_PROFILE, ['workspaceId' => $workspace->id], $profile);
        $response->assertSuccessful();
    }

}

