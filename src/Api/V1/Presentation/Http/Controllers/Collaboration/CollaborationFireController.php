<?php

namespace Queues\Api\V1\Presentation\Http\Controllers\Collaboration;

use App\Jobs\CeaseRelation;
use Queues\Api\V1\Domain\RelationType;
use Queues\Api\V1\Presentation\Http\Controllers\ApiController;
use Queues\Api\V1\Presentation\Http\Controllers\Collaboration\Requests\CollaborationFireRequest;

class CollaborationFireController extends ApiController
{
    public function __invoke(CollaborationFireRequest $request)
    {
        $user = $this->user();
        $workspace = $user->getOwnWorkspace($request->workspaceId);

        CeaseRelation::dispatch($request->collaboratorId, $workspace->workspace_id, RelationType::MEMBER());
        return $this->respond();
    }
}
