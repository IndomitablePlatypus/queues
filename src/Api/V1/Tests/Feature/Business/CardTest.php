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
use Queues\Api\V1\Config\Routing\RouteName;
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
            RouteName::ISSUE_CARD,
            ['workspaceId' => $workspace->id],
            ['customerId' => GuidBasedImmutableId::makeValue(), 'planId' => $plan->id]
        );
        $response->assertSuccessful();

        $planId = $this->rGet(
            RouteName::GET_CARD,
            ['workspaceId' => $workspace->id, 'cardId' => $response->json('cardId')],
        )->json('planId');
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
            RouteName::COMPLETE_CARD,
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
            RouteName::REVOKE_CARD,
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
            RouteName::BLOCK_CARD,
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
            RouteName::UNBLOCK_CARD,
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
            RouteName::GET_CARD,
            ['workspaceId' => $workspace->id, 'cardId' => $card->id],
        );
        $response->assertSuccessful();
        $this->assertCount(1, $response->json('requirements'));

        $response = $this->rPost(
            RouteName::NOTE_ACHIEVEMENT,
            ['workspaceId' => $workspace->id, 'cardId' => $card->id],
            ['achievementId' => $requirement->id, 'description' => $requirement->description],
        );
        $response->assertSuccessful();
        $this->assertCount(1, $response->json('achievements'));
    }

    public function test_collaborator_can_dismss_achievement()
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

        $card = Card::factory()->make([
            'plan_id' => $plan->id,
            'requirements' => Plan::compactRequirements([$requirement]),
            'achievements' => [['achievementId' => $requirement->id, 'description' => $requirement->description]],
            'satisfied_at' => Carbon::now(),
        ])->persist();

        EstablishRelation::dispatchSync($collaborator->id, $workspace->id, RelationType::MEMBER());
        $this->tokenize($collaborator);

        $response = $this->rGet(
            RouteName::GET_CARD,
            ['workspaceId' => $workspace->id, 'cardId' => $card->id],
        );
        $response->assertSuccessful();
        $this->assertCount(1, $response->json('achievements'));

        $response = $this->rDelete(
            RouteName::DISMISS_ACHIEVEMENT,
            ['workspaceId' => $workspace->id, 'cardId' => $card->id, 'achievementId' => $requirement->id],
        );
        $response->assertSuccessful();
        $this->assertCount(0, $response->json('achievements'));
        $this->assertNull($response->json('satisfied_at'));
    }

}
