<?php

namespace Queues\Api\V1\Presentation\Http\Controllers\Collaboration;

use Queues\Api\V1\Presentation\Http\Controllers\ApiController;
use Queues\Api\V1\Presentation\Http\Controllers\Collaboration\Requests\InviteRequest;

class InviteDiscardController extends ApiController
{
    public function __invoke(InviteRequest $request)
    {
        $this
            ->user()
            ->getOwnWorkspace($request->workspaceId)
            ->getInvite($request->inviteId)
            ->delete();

        return $this->respond();
    }
}
