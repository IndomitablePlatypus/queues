<?php

namespace Queues\Api\V1\Presentation\Http\Controllers\Collaboration;

use Queues\Api\V1\Presentation\Http\Controllers\ApiController;
use Queues\Api\V1\Presentation\Http\Controllers\Collaboration\Requests\CollaborationFireRequest;

class CollaborationFireController extends ApiController
{
    public function __invoke(CollaborationFireRequest $request)
    {
        return $this->respond(
            $this
                ->user()
                ->getOwnWorkspace($request->workspaceId)
                ->fire($request->collaboratorId)
        );
    }
}
