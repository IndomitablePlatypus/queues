<?php

namespace Queues\Api\V1\Presentation\Http\Controllers\Workspaces;

use Queues\Api\V1\Presentation\Http\Controllers\ApiController;
use Queues\Api\V1\Presentation\Http\Controllers\Workspaces\Requests\GetRequest;

class WorkspacesGetController extends ApiController
{
    public function __invoke(GetRequest $request)
    {
        return $this->respond(
            $this
                ->user()
                ->getWorkspaces()
        );
    }
}
