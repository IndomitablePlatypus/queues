<?php

namespace Feature\Business;

use App\Models\User;
use App\Models\Workspace;
use Queues\Api\V1\Config\Routing\Routing;
use Queues\Api\V1\Tests\TestApplicationTrait;
use Queues\Tests\BaseTestCase;

class WorkspaceTest extends BaseTestCase
{
    use TestApplicationTrait;

    public function test_workspace_can_be_added()
    {
        /** @var User $user */
        $user = User::factory()->make();
        $user->save();
        $token = $user->createToken($this->faker->word());
        $this->withToken($token->plainTextToken);

        /** @var Workspace $workspace */
        $workspace = Workspace::factory()->make();
        $workspace->keeper_id = $user->id;
        $response = $this->post(Routing::WORKSPACES_ADD(), $workspace->profile);
        $response->assertSuccessful();
    }

}
