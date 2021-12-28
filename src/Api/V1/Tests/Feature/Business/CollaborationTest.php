<?php

namespace Feature\Business;

use App\Jobs\EstablishRelation;
use App\Models\Invite;
use App\Models\User;
use App\Models\Workspace;
use Codderz\Platypus\Infrastructure\Support\GuidBasedImmutableId;
use Queues\Api\V1\Config\Routing\Routing;
use Queues\Api\V1\Domain\RelationType;
use Queues\Api\V1\Tests\RoutingTestTrait;
use Queues\Api\V1\Tests\TestApplicationTrait;
use Queues\Tests\BaseTestCase;

class CollaborationTest extends BaseTestCase
{
    use TestApplicationTrait, RoutingTestTrait;


    public function test_keeper_can_fire_collaborator()
    {
        /** @var User $keeper */
        $keeper = User::factory()->make();
        /** @var User $collaborator */
        $collaborator = User::factory()->make();
        $workspace = Workspace::factory()->make(['keeper_id' => $keeper->id]);

        $keeper->save();
        $collaborator->save();
        $workspace->save();

        EstablishRelation::dispatchSync($keeper->id, $workspace->id, RelationType::KEEPER());
        EstablishRelation::dispatchSync($collaborator->id, $workspace->id, RelationType::MEMBER());
        $this->tokenize($keeper);

        $response = $this->rPost(Routing::COLLABORATION_FIRE(), ['workspaceId' => $workspace->id, 'collaboratorId' => $collaborator->id]);
        $response->assertSuccessful();
    }

    public function test_collaborator_cannot_fire_collaborator()
    {
        $keeperId = GuidBasedImmutableId::make();
        /** @var User $firstCollaborator */
        $firstCollaborator = User::factory()->make();
        /** @var User $secondCollaborator */
        $secondCollaborator = User::factory()->make();
        $workspace = Workspace::factory()->make(['keeper_id' => $keeperId]);

        $firstCollaborator->save();
        $secondCollaborator->save();
        $workspace->save();

        EstablishRelation::dispatchSync($keeperId, $workspace->id, RelationType::KEEPER());
        EstablishRelation::dispatchSync($firstCollaborator->id, $workspace->id, RelationType::MEMBER());
        EstablishRelation::dispatchSync($secondCollaborator->id, $workspace->id, RelationType::MEMBER());
        $this->tokenize($firstCollaborator);

        $response = $this->rPost(Routing::COLLABORATION_FIRE(), ['workspaceId' => $workspace->id, 'collaboratorId' => $secondCollaborator->id]);
        $response->assertNotFound();
    }

    public function test_collaborator_can_leave_collaboration()
    {
        $keeperId = GuidBasedImmutableId::make();

        /** @var User $collaborator */
        $collaborator = User::factory()->make();
        $workspace = Workspace::factory()->make(['keeper_id' => $keeperId]);

        $collaborator->save();
        $workspace->save();

        EstablishRelation::dispatchSync($keeperId, $workspace->id, RelationType::KEEPER());
        EstablishRelation::dispatchSync($collaborator->id, $workspace->id, RelationType::MEMBER());
        $this->tokenize($collaborator);

        $response = $this->rPost(Routing::COLLABORATION_LEAVE(), ['workspaceId' => $workspace->id, 'collaboratorId' => $collaborator->id]);
        $response->assertSuccessful();
    }


}
