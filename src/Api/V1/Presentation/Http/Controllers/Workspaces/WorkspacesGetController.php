<?php

namespace Queues\Api\V1\Presentation\Http\Controllers\Workspaces;

use Illuminate\Http\Request;
use Queues\Api\V1\Presentation\Http\Controllers\ApiController;
use Queues\Api\V1\Presentation\Http\Controllers\Workspaces\Requests\GetRequest;

class WorkspacesGetController extends ApiController
{
    public function __invoke(GetRequest $request)
    {
        $workspaces = $this->user()->workspaces()->get();
        return $this->respond($workspaces);
    }
}
