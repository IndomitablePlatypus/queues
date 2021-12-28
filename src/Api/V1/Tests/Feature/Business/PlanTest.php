<?php

namespace Feature\Business;

use App\Jobs\EstablishRelation;
use App\Models\Plan;
use App\Models\User;
use App\Models\Workspace;
use Queues\Api\V1\Config\Routing\Routing;
use Queues\Api\V1\Domain\RelationType;
use Queues\Api\V1\Tests\RoutingTestTrait;
use Queues\Api\V1\Tests\TestApplicationTrait;
use Queues\Tests\BaseTestCase;

class PlanTest extends BaseTestCase
{
    use TestApplicationTrait, RoutingTestTrait;

    public function test_collaborator_can_add_plan()
    {
        /** @var User $collaborator */
        $collaborator = User::factory()->make();
        $workspace = Workspace::factory()->make();

        $collaborator->save();
        $workspace->save();

        EstablishRelation::dispatchSync($collaborator->id, $workspace->id, RelationType::MEMBER());
        $this->tokenize($collaborator);

        $plan = Plan::factory()->make(['workspace_id' => $workspace->id]);

        $response = $this->rPost(
            Routing::PLANS_ADD(),
            ['workspaceId' => $workspace->id],
            ['description' => $plan->description],
        );
        $response->assertSuccessful();

        $workspaceId = $this->rGet(
            Routing::PLANS_GET_ONE(),
            ['workspaceId' => $workspace->id, 'planId' => $response->json('plan_id')],
        )->json('workspace_id');
        $this->assertEquals($workspace->id, $workspaceId);
    }

    public function test_non_collaborator_cannot_add_plan()
    {
        /** @var User $collaborator */
        $collaborator = User::factory()->make();
        $workspace = Workspace::factory()->make();

        $collaborator->save();
        $workspace->save();

        $this->tokenize($collaborator);

        $plan = Plan::factory()->make(['workspace_id' => $workspace->id]);

        $response = $this->rPost(
            Routing::PLANS_ADD(),
            ['workspaceId' => $workspace->id],
            ['description' => $plan->description],
        );
        $response->assertNotFound();
    }

}
