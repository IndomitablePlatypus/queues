<?php

namespace Queues\Api\V1\Presentation\Http\Controllers\Workspaces;

use App\Jobs\EstablishRelation;
use App\Models\Workspace;
use Queues\Api\V1\Domain\RelationType;
use Queues\Api\V1\Presentation\Http\Controllers\ApiController;
use Queues\Api\V1\Presentation\Http\Controllers\Workspaces\Requests\AddWorkspaceRequest;

class WorkspacesAddController extends ApiController
{
    public function __invoke(AddWorkspaceRequest $request)
    {
        $user = $this->user();
        $workspace = $user->addWorkspace($request->toArray())->persist();
        EstablishRelation::dispatch($workspace->keeper_id, $workspace->workspace_id, RelationType::KEEPER());
        return $this->respond($workspace);
    }
}
