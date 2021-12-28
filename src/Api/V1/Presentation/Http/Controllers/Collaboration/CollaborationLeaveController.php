<?php

namespace Queues\Api\V1\Presentation\Http\Controllers\Collaboration;

use App\Jobs\CeaseRelation;
use App\Models\Relation;
use Queues\Api\V1\Domain\RelationType;
use Queues\Api\V1\Presentation\Http\Controllers\ApiController;
use Queues\Api\V1\Presentation\Http\Controllers\Collaboration\Requests\CollaborationLeaveRequest;

class CollaborationLeaveController extends ApiController
{
    public function __invoke(CollaborationLeaveRequest $request)
    {
        $relation = Relation::query()
            ->where('collaborator_id', '=', $this->user()->id)
            ->where('workspace_id', '=', $request->workspaceId)
            ->where('relation_type', '=', RelationType::MEMBER())
            ->firstOrFail();

        CeaseRelation::dispatch($relation->collaborator_id, $relation->workspace_id, RelationType::MEMBER());
        return $this->respond();
    }
}
