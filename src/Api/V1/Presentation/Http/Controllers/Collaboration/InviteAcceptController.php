<?php

namespace Queues\Api\V1\Presentation\Http\Controllers\Collaboration;

use App\Jobs\EstablishRelation;
use Queues\Api\V1\Domain\RelationType;
use Queues\Api\V1\Presentation\Http\Controllers\ApiController;
use Queues\Api\V1\Presentation\Http\Controllers\Collaboration\Requests\InviteRequest;

class InviteAcceptController extends ApiController
{
    public function __invoke(InviteRequest $request)
    {
        $this
            ->user()
            ->getWorkspace($request->workspaceId)
            ->getInvite($request->inviteId)
            ->delete();

        EstablishRelation::dispatch($this->user()->id, $request->workspaceId, RelationType::MEMBER());
        return $this->respond();
    }
}
