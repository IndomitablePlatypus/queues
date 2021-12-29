<?php

namespace Queues\Api\V1\Presentation\Http\Controllers\Requirements;

use Queues\Api\V1\Presentation\Http\Controllers\ApiController;
use Queues\Api\V1\Presentation\Http\Controllers\Requirements\Requests\AddRequirementRequest;

class RequirementsAddController extends ApiController
{
    public function __invoke(AddRequirementRequest $request)
    {
        return $this->respond(
            $this
                ->user()
                ->getWorkspace($request->workspaceId)
                ->getPlan($request->planId)
                ->addRequirement($request->description)
                ->persist()
        );
    }
}
