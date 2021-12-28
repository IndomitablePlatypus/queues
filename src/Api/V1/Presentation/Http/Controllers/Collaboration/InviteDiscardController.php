<?php

namespace Queues\Api\V1\Presentation\Http\Controllers\Collaboration;

use Queues\Api\V1\Presentation\Http\Controllers\ApiController;
use Queues\Api\V1\Presentation\Http\Controllers\Collaboration\Requests\InviteRequest;

class InviteDiscardController extends ApiController
{
    public function __invoke(InviteRequest $request)
    {
        return $this->respond(
            $this
                ->user()
                ->getOwnWorkspace($request->workspaceId)
                ->getInvite($request->inviteId)
                ->discard()
        );
    }
}
