<?php

namespace Queues\Api\V1\Presentation\Http\Controllers\Plans;

use Queues\Api\V1\Presentation\Http\Controllers\ApiController;
use Queues\Api\V1\Presentation\Http\Controllers\Plans\Requests\LaunchPlanRequest;

class PlansLaunchController extends ApiController
{
    public function __invoke(LaunchPlanRequest $request)
    {
        return $this->respond(
            $this
                ->user()
                ->getWorkspace($request->workspaceId)
                ->getPlan($request->planId)
                ->launch($request->expirationDate)
                ->persist()
        );
    }
}
