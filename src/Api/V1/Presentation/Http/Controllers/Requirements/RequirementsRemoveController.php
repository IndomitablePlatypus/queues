<?php

namespace Queues\Api\V1\Presentation\Http\Controllers\Requirements;

use Queues\Api\V1\Presentation\Http\Controllers\ApiController;
use Queues\Api\V1\Presentation\Http\Controllers\Requirements\Requests\RemoveRequirementRequest;

class RequirementsRemoveController extends ApiController
{
    public function __invoke(RemoveRequirementRequest $request)
    {
        return $this->respond(
            $this
                ->user()
                ->getWorkspace($request->workspaceId)
                ->getPlan($request->planId)
                ->getRequirement($request->requirementId)
                ->remove()
        );
    }
}
