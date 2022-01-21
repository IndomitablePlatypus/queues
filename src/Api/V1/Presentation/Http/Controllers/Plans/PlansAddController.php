<?php

namespace Queues\Api\V1\Presentation\Http\Controllers\Plans;

use Queues\Api\V1\Presentation\Http\Controllers\ApiController;
use Queues\Api\V1\Presentation\Http\Controllers\Plans\Requests\AddPlanRequest;

class PlansAddController extends ApiController
{
    public function __invoke(AddPlanRequest $request)
    {
        return $this->respond(
            $this
                ->user()
                ->getWorkspace($request->workspaceId)
                ->addPlan($request->name, $request->description)
                ->persist()
        );
    }
}
