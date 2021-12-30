<?php

namespace Feature\Business;

use App\Jobs\EstablishRelation;
use App\Jobs\RequirementsChanged;
use App\Models\Card;
use App\Models\Plan;
use App\Models\Requirement;
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
            Routing::CARDS_ISSUE,
            ['workspaceId' => $workspace->id],
            ['customerId' => GuidBasedImmutableId::makeValue(), 'planId' => $plan->id]
        );
        $response->assertSuccessful();

        $planId = $this->rGet(
            Routing::CARDS_GET_ONE,
            ['workspaceId' => $workspace->id, 'cardId' => $response->json('card_id')],
        )->json('plan_id');
        $this->assertEquals($plan->id, $planId);
    }

    public function test_collaborator_can_complete_card()
    {
        /** @var User $collaborator */
        $collaborator = User::factory()->make();
        $workspace = Workspace::factory()->make();
        $plan = Plan::factory()->make(['workspace_id' => $workspace->id]);
        $card = Card::factory()->make(['satisfied_at' => Carbon::now(), 'plan_id' => $plan->id]);

        $collaborator->save();
        $workspace->save();
        $plan->save();
        $card->save();

        EstablishRelation::dispatchSync($collaborator->id, $workspace->id, RelationType::MEMBER());
        $this->tokenize($collaborator);

        $response = $this->rPut(
            Routing::CARDS_COMPLETE,
            ['workspaceId' => $workspace->id, 'cardId' => $card->id]
        );
        $response->assertSuccessful();
    }

    public function test_collaborator_can_revoke_card()
    {
        /** @var User $collaborator */
        $collaborator = User::factory()->make();
        $workspace = Workspace::factory()->make();
        $plan = Plan::factory()->make(['workspace_id' => $workspace->id]);
        $card = Card::factory()->make(['satisfied_at' => Carbon::now(), 'plan_id' => $plan->id]);

        $collaborator->save();
        $workspace->save();
        $plan->save();
        $card->save();

        EstablishRelation::dispatchSync($collaborator->id, $workspace->id, RelationType::MEMBER());
        $this->tokenize($collaborator);

        $response = $this->rPut(
            Routing::CARDS_REVOKE,
            ['workspaceId' => $workspace->id, 'cardId' => $card->id]
        );
        $response->assertSuccessful();
    }

    public function test_collaborator_can_block_card()
    {
        /** @var User $collaborator */
        $collaborator = User::factory()->make();
        $workspace = Workspace::factory()->make();
        $plan = Plan::factory()->make(['workspace_id' => $workspace->id]);
        $card = Card::factory()->make(['satisfied_at' => Carbon::now(), 'plan_id' => $plan->id]);

        $collaborator->save();
        $workspace->save();
        $plan->save();
        $card->save();

        EstablishRelation::dispatchSync($collaborator->id, $workspace->id, RelationType::MEMBER());
        $this->tokenize($collaborator);

        $response = $this->rPut(
            Routing::CARDS_BLOCK,
            ['workspaceId' => $workspace->id, 'cardId' => $card->id]
        );
        $response->assertSuccessful();
    }

    public function test_collaborator_can_unblock_card()
    {
        /** @var User $collaborator */
        $collaborator = User::factory()->make();
        $workspace = Workspace::factory()->make();
        $plan = Plan::factory()->make(['workspace_id' => $workspace->id]);
        $card = Card::factory()->make(['blocked_at' => Carbon::now(), 'plan_id' => $plan->id]);

        $collaborator->save();
        $workspace->save();
        $plan->save();
        $card->save();

        EstablishRelation::dispatchSync($collaborator->id, $workspace->id, RelationType::MEMBER());
        $this->tokenize($collaborator);

        $response = $this->rPut(
            Routing::CARDS_UNBLOCK,
            ['workspaceId' => $workspace->id, 'cardId' => $card->id]
        );
        $response->assertSuccessful();
    }


    public function test_collaborator_can_note_achievement()
    {
        /** @var User $collaborator */
        $collaborator = User::factory()->make();
        $workspace = Workspace::factory()->make();
        $plan = Plan::factory()->make(['workspace_id' => $workspace->id]);
        $requirement = Requirement::factory()->make(['plan_id' => $plan->id]);
        $card = Card::factory()->make(['plan_id' => $plan->id]);

        $collaborator->save();
        $workspace->save();
        $plan->save();
        $requirement->save();
        $card->save();

        EstablishRelation::dispatchSync($collaborator->id, $workspace->id, RelationType::MEMBER());
        RequirementsChanged::dispatchSync($plan);
        $this->tokenize($collaborator);

        $response = $this->rGet(
            Routing::CARDS_GET_ONE,
            ['workspaceId' => $workspace->id, 'cardId' => $card->id],
        );
        $response->assertSuccessful();
        $this->assertCount(1, $response->json('requirements'));

        $newRequirement = Requirement::factory()->make(['plan_id' => $plan->id]);
        $response = $this->rPost(
            Routing::CARDS_NOTE_ACHIEVEMENT,
            ['workspaceId' => $workspace->id, 'cardId' => $card->id],
            ['achievementId' => $newRequirement->id, 'description' => $newRequirement->description],
        );
        $response->assertSuccessful();
        $this->assertCount(0, $response->json('achievements'));
    }

}
