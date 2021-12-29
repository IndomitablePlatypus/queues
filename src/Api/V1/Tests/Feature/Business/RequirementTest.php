<?php

namespace Feature\Business;

use App\Jobs\EstablishRelation;
use App\Models\Plan;
use App\Models\Requirement;
use App\Models\User;
use App\Models\Workspace;
use Carbon\Carbon;
use Queues\Api\V1\Config\Routing\Routing;
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
            Routing::REQUIREMENTS_ADD(),
            ['workspaceId' => $workspace->id, 'planId' => $plan->id],
            ['description' => Requirement::factory()->make()->description],
        );
        $response->assertSuccessful();

        $requirements = $this->rGet(
            Routing::PLANS_GET_ONE(),
            ['workspaceId' => $workspace->id, 'planId' => $plan->id],
        )->json('requirements');

        $this->assertCount(1, $requirements);
    }
}
