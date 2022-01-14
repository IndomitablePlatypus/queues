<?php

namespace Feature\Business;

use App\Jobs\EstablishRelation;
use App\Models\Invite;
use App\Models\User;
use App\Models\Workspace;
use Codderz\Platypus\Infrastructure\Support\GuidBasedImmutableId;
use Queues\Api\V1\Config\Routing\RouteName;
use Queues\Api\V1\Domain\RelationType;
use Queues\Api\V1\Tests\RoutingTestTrait;
use Queues\Api\V1\Tests\TestApplicationTrait;
use Queues\Tests\BaseTestCase;

class InviteTest extends BaseTestCase
{
    use TestApplicationTrait, RoutingTestTrait;

    public function test_keeper_can_invite()
    {
        /** @var User $keeper */
        $keeper = User::factory()->make();
        $workspace = Workspace::factory()->make(['keeper_id' => $keeper->id]);

        $keeper->save();
        $workspace->save();

        EstablishRelation::dispatchSync($keeper->id, $workspace->id, RelationType::KEEPER());
        $this->tokenize($keeper);

        $response = $this->rPost(RouteName::PROPOSE_INVITE, ['workspaceId' => $workspace->id]);
        $response->assertSuccessful();
    }

    public function test_collaborator_cannot_invite()
    {
        $keeperId = GuidBasedImmutableId::makeValue();

        /** @var User $collaborator */
        $collaborator = User::factory()->make();
        $workspace = Workspace::factory()->make(['keeper_id' => $keeperId]);

        $collaborator->save();
        $workspace->save();

        EstablishRelation::dispatchSync($keeperId, $workspace->id, RelationType::KEEPER());
        EstablishRelation::dispatchSync($collaborator->id, $workspace->id, RelationType::MEMBER());

        $this->tokenize($collaborator);

        $response = $this->rPost(RouteName::PROPOSE_INVITE, ['workspaceId' => $workspace->id]);
        $response->assertNotFound();
    }

    public function test_user_cannot_invite()
    {
        $keeperId = GuidBasedImmutableId::makeValue();

        /** @var User $user */
        $user = User::factory()->make();
        $workspace = Workspace::factory()->make(['keeper_id' => $keeperId]);

        $user->save();
        $workspace->save();

        $this->tokenize($user);

        $response = $this->rPost(RouteName::PROPOSE_INVITE, ['workspaceId' => $workspace->id]);
        $response->assertNotFound();
    }

    public function test_keeper_can_discard_invite()
    {
        /** @var User $keeper */
        $keeper = User::factory()->make();
        $workspace = Workspace::factory()->make(['keeper_id' => $keeper->id]);
        $invite = Invite::factory()->make(['workspace_id' => $workspace->id]);

        $keeper->save();
        $workspace->save();
        $invite->save();

        EstablishRelation::dispatchSync($keeper->id, $workspace->id, RelationType::KEEPER());

        $this->tokenize($keeper);

        $response = $this->rDelete(RouteName::DISCARD_INVITE, ['workspaceId' => $workspace->id, 'inviteId' => $invite->id]);
        $response->assertSuccessful();
    }

    public function test_user_can_accpet_invite()
    {
        $keeper = User::factory()->make();
        /** @var User $user */
        $user = User::factory()->make();
        $workspace = Workspace::factory()->make(['keeper_id' => $keeper->id]);
        $invite = Invite::factory()->make(['workspace_id' => $workspace->id]);

        $keeper->save();
        $user->save();
        $workspace->save();
        $invite->save();

        EstablishRelation::dispatchSync($keeper->id, $workspace->id, RelationType::KEEPER());

        $this->tokenize($user);

        $response = $this->rPut(RouteName::ACCEPT_INVITE, ['workspaceId' => $workspace->id, 'inviteId' => $invite->id]);
        $response->assertSuccessful();
    }

}
