<?php

namespace Queues\Api\V1\Presentation\Http\Controllers\Collaboration;

use Queues\Api\V1\Presentation\Http\Controllers\ApiController;
use Queues\Api\V1\Presentation\Http\Controllers\Collaboration\Requests\InviteProposeRequest;

class InviteProposeController extends ApiController
{
    public function __invoke(InviteProposeRequest $request)
    {
        $invite = $this
            ->user()
            ->getWorkspace($request->workspaceId)
            ->invite()
            ->persist();

        return $this->respond($invite);
    }
}
