<?php

namespace Feature\Business;

use App\Jobs\EstablishRelation;
use App\Models\Plan;
use App\Models\Requirement;
use App\Models\User;
use App\Models\Workspace;
use Queues\Api\V1\Config\Routing\RouteName;
use Queues\Api\V1\Domain\RelationType;
use Queues\Api\V1\Tests\RoutingTestTrait;
use Queues\Api\V1\Tests\TestApplicationTrait;
use Queues\Tests\BaseTestCase;

class RequirementTest extends BaseTestCase
{
    use TestApplicationTrait, RoutingTestTrait;

    public function test_collaborator_can_add_requirement()
    {
        /** @var User $collaborator */
        $collaborator = User::factory()->make();
        $workspace = Workspace::factory()->make();
        $plan = Plan::factory()->make(['workspace_id' => $workspace->id]);

        $collaborator->save();
        $workspace->save();
        $plan->save();

        EstablishRelation::dispatchSync($collaborator->id, $workspace->id, RelationType::MEMBER());
        $this->tokenize($collaborator);

        $response = $this->rPost(
            RouteName::ADD_PLAN_REQUIREMENT,
            ['workspaceId' => $workspace->id, 'planId' => $plan->id],
            ['description' => Requirement::factory()->make()->description],
        );
        $response->assertSuccessful();

        $requirements = $this->rGet(
            RouteName::GET_PLAN,
            ['workspaceId' => $workspace->id, 'planId' => $plan->id],
        )->json('requirements');

        $this->assertCount(1, $requirements);
    }

    public function test_collaborator_can_change_requirement()
    {
        /** @var User $collaborator */
        $collaborator = User::factory()->make();
        $workspace = Workspace::factory()->make();
        $plan = Plan::factory()->make(['workspace_id' => $workspace->id]);
        $requirement = Requirement::factory()->make(['plan_id' => $plan->id]);

        $collaborator->save();
        $workspace->save();
        $plan->save();
        $requirement->save();

        EstablishRelation::dispatchSync($collaborator->id, $workspace->id, RelationType::MEMBER());
        $this->tokenize($collaborator);

        $response = $this->rPut(
            RouteName::CHANGE_PLAN_REQUIREMENT,
            ['workspaceId' => $workspace->id, 'planId' => $plan->id, 'requirementId' => $requirement->id],
            ['description' => 'changed'],
        );
        $response->assertSuccessful();

        $requirements = $this->rGet(
            RouteName::GET_PLAN,
            ['workspaceId' => $workspace->id, 'planId' => $plan->id],
        )->json('requirements');

        $this->assertEquals('changed', $requirements[0]['description']);
    }

    public function test_collaborator_can_delete_requirement()
    {
        /** @var User $collaborator */
        $collaborator = User::factory()->make();
        $workspace = Workspace::factory()->make();
        $plan = Plan::factory()->make(['workspace_id' => $workspace->id]);
        $requirement = Requirement::factory()->make(['plan_id' => $plan->id]);

        $collaborator->save();
        $workspace->save();
        $plan->save();
        $requirement->save();

        EstablishRelation::dispatchSync($collaborator->id, $workspace->id, RelationType::MEMBER());
        $this->tokenize($collaborator);

        $response = $this->rDelete(
            RouteName::REMOVE_PLAN_REQUIREMENT,
            ['workspaceId' => $workspace->id, 'planId' => $plan->id, 'requirementId' => $requirement->id],
        );
        $response->assertSuccessful();

        $requirements = $this->rGet(
            RouteName::GET_PLAN,
            ['workspaceId' => $workspace->id, 'planId' => $plan->id],
        )->json('requirements');

        $this->assertCount(0, $requirements);
    }

}
