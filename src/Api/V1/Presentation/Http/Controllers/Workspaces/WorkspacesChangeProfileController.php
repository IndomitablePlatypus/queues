<?php

namespace Queues\Api\V1\Presentation\Http\Controllers\Workspaces;

use Queues\Api\V1\Presentation\Http\Controllers\ApiController;
use Queues\Api\V1\Presentation\Http\Controllers\Workspaces\Requests\ChangeWorkspaceProfileRequest;

class WorkspacesChangeProfileController extends ApiController
{
    public function __invoke(ChangeWorkspaceProfileRequest $request)
    {
        $workspace = $this->user()->getWorkspace($request->workspaceId);
        $workspace->fill($request->toArray());
        $workspace->save();
        return $this->respond($workspace);
    }
}
