<?php

namespace Queues\Api\V1\Presentation\Http\Controllers\Workspaces;

use Illuminate\Http\Request;
use Queues\Api\V1\Presentation\Http\Controllers\ApiController;
use Queues\Api\V1\Presentation\Http\Controllers\Workspaces\Requests\GetRequest;

class WorkspacesGetOneController extends ApiController
{
    public function __invoke(GetRequest $request)
    {
        $workspace = $request->user()->workspace($request->workspaceId)->firstOrFail();
        return $this->respond($workspace);
    }
}
