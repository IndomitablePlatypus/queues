<?php

namespace Feature\Business;

use App\Jobs\EstablishRelation;
use App\Models\Plan;
use App\Models\User;
use App\Models\Workspace;
use Carbon\Carbon;
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
            Routing::PLANS_ADD,
            ['workspaceId' => $workspace->id],
            ['description' => $plan->description],
        );
        $response->assertSuccessful();

        $workspaceId = $this->rGet(
            Routing::PLANS_GET_ONE,
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
            Routing::PLANS_ADD,
            ['workspaceId' => $workspace->id],
            ['description' => $plan->description],
        );
        $response->assertNotFound();
    }

    public function test_collaborator_can_launch_plan()
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

        $expirationDate = Carbon::now()->addDays(60);

        $response = $this->rPut(
            Routing::PLANS_LAUNCH,
            ['workspaceId' => $workspace->id, 'planId' => $plan->id],
            ['expirationDate' => $expirationDate],
        );
        $response->assertSuccessful();

        $planExpirationDate = $this->rGet(
            Routing::PLANS_GET_ONE,
            ['workspaceId' => $workspace->id, 'planId' => $plan->id],
        )->json('expiration_date');
        $this->assertEquals($expirationDate->format('Y-m-d\TH:i:s.000000\Z'), $planExpirationDate);
    }

    public function test_collaborator_can_stop_plan()
    {
        /** @var User $collaborator */
        $collaborator = User::factory()->make();
        $workspace = Workspace::factory()->make();
        $plan = Plan::factory()->make(['workspace_id' => $workspace->id, 'launched_at' => Carbon::now()]);

        $collaborator->save();
        $workspace->save();
        $plan->save();

        EstablishRelation::dispatchSync($collaborator->id, $workspace->id, RelationType::MEMBER());
        $this->tokenize($collaborator);

        $response = $this->rPut(
            Routing::PLANS_STOP,
            ['workspaceId' => $workspace->id, 'planId' => $plan->id],
        );
        $response->assertSuccessful();

        $launchedAt = $this->rGet(
            Routing::PLANS_GET_ONE,
            ['workspaceId' => $workspace->id, 'planId' => $plan->id],
        )->json('launched_at');
        $this->assertNull($launchedAt);
    }

    public function test_collaborator_can_archive_plan()
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

        $response = $this->rPut(
            Routing::PLANS_ARCHIVE,
            ['workspaceId' => $workspace->id, 'planId' => $plan->id],
        );
        $response->assertSuccessful();

        $archivedAt = $this->rGet(
            Routing::PLANS_GET_ONE,
            ['workspaceId' => $workspace->id, 'planId' => $plan->id],
        )->json('archived_at');
        $this->assertNotNull($archivedAt);
    }

    public function test_collaborator_cannot_launch_archived_plan()
    {
        /** @var User $collaborator */
        $collaborator = User::factory()->make();
        $workspace = Workspace::factory()->make();
        $plan = Plan::factory()->make(['workspace_id' => $workspace->id, 'archived_at' => Carbon::now()]);

        $collaborator->save();
        $workspace->save();
        $plan->save();

        EstablishRelation::dispatchSync($collaborator->id, $workspace->id, RelationType::MEMBER());
        $this->tokenize($collaborator);

        $response = $this->rPut(
            Routing::PLANS_LAUNCH,
            ['workspaceId' => $workspace->id, 'planId' => $plan->id],
            ['expirationDate' => Carbon::now()->addDays(2)],
        );
        $response->assertStatus(500);
        $response->assertSee('Logic exception');
    }

}
