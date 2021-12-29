<?php

namespace Feature\Business;

use App\Jobs\EstablishRelation;
use App\Models\Plan;
use App\Models\User;
use App\Models\Workspace;
use Carbon\Carbon;
use Codderz\Platypus\Infrastructure\Support\GuidBasedImmutableId;
use Queues\Api\V1\Config\Routing\Routing;
use Queues\Api\V1\Domain\RelationType;
use Queues\Api\V1\Tests\RoutingTestTrait;
use Queues\Api\V1\Tests\TestApplicationTrait;
use Queues\Tests\BaseTestCase;

class CardTest extends BaseTestCase
{
    use TestApplicationTrait, RoutingTestTrait;

    public function test_collaborator_can_issue_card()
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
            Routing::CARDS_ISSUE(),
            ['workspaceId' => $workspace->id],
            ['customerId' => GuidBasedImmutableId::makeValue(), 'planId' => $plan->id]
        );
        $response->assertSuccessful();

        $planId = $this->rGet(
            Routing::CARDS_GET_ONE(),
            ['workspaceId' => $workspace->id, 'cardId' => $response->json('card_id')],
        )->json('plan_id');
        $this->assertEquals($plan->id, $planId);
    }
}
