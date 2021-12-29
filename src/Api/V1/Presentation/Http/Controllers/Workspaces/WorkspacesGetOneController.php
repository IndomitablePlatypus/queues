<?php

namespace Queues\Api\V1\Presentation\Http\Controllers\Workspaces;

use Queues\Api\V1\Presentation\Http\Controllers\ApiController;
use Queues\Api\V1\Presentation\Http\Controllers\Workspaces\Requests\GetOneRequest;

class WorkspacesGetOneController extends ApiController
{
    public function __invoke(GetOneRequest $request)
    {
        return $this->respond(
            $this
                ->user()
                ->getWorkspace($request->workspaceId)
        );
    }
}