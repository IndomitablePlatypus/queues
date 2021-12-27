<?php

namespace Queues\Api\V1\Presentation\Http\Controllers\Workspaces;

use Illuminate\Http\Request;
use Queues\Api\V1\Presentation\Http\Controllers\ApiController;
use Queues\Api\V1\Presentation\Http\Controllers\Workspaces\Requests\GetOneRequest;
use Queues\Api\V1\Presentation\Http\Controllers\Workspaces\Requests\GetRequest;

class WorkspacesGetOneController extends ApiController
{
    public function __invoke(GetOneRequest $request)
    {
        $workspace = $this->user()->getWorkspace($request->workspaceId);
        return $this->respond($workspace);
    }
}
