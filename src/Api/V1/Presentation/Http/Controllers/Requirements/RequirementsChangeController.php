<?php

namespace Queues\Api\V1\Presentation\Http\Controllers\Requirements;

use Queues\Api\V1\Presentation\Http\Controllers\ApiController;
use Queues\Api\V1\Presentation\Http\Controllers\Requirements\Requests\ChangeRequirementRequest;
use Vyuldashev\LaravelOpenApi\Attributes as OpenApi;

#[OpenApi\PathItem]
class RequirementsChangeController extends ApiController
{
    public function __invoke(ChangeRequirementRequest $request)
    {
        return $this->respond(
            $this
                ->user()
                ->getWorkspace($request->workspaceId)
                ->getPlan($request->planId)
                ->getRequirement($request->requirementId)
                ->setDescription($request->description)
                ->persist()
        );
    }
}
