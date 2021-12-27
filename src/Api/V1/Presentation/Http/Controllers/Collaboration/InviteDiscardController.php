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
            ->getWorkspace($request->workspaceId)
            ->getInvite($request->inviteId)
            ->delete();

        return $this->respond();
    }
}
