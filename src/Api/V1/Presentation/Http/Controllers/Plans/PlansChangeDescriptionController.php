<?php

namespace Queues\Api\V1\Presentation\Http\Controllers\Plans;

use Queues\Api\V1\Presentation\Http\Controllers\ApiController;
use Queues\Api\V1\Presentation\Http\Controllers\Plans\Requests\ChangePlanProfileRequest;

class PlansChangeDescriptionController extends ApiController
{
    public function __invoke(ChangePlanProfileRequest $request)
    {
        return $this->respond(
            $this
                ->user()
                ->getWorkspace($request->workspaceId)
                ->getPlan($request->planId)
                ->setProfile($request->name, $request->description)
                ->persist()
        );
    }
}
