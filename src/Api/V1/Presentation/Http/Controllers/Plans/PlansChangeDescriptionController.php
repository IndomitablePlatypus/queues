<?php

namespace Queues\Api\V1\Presentation\Http\Controllers\Plans;

use Queues\Api\V1\Presentation\Http\Controllers\ApiController;
use Queues\Api\V1\Presentation\Http\Controllers\Plans\Requests\ChangePlanDescriptionRequest;

class PlansChangeDescriptionController extends ApiController
{
    public function __invoke(ChangePlanDescriptionRequest $request)
    {
        return $this->respond(
            $this
                ->user()
                ->getWorkspace($request->workspaceId)
                ->getPlan($request->planId)
                ->setDescription($request->description)
                ->persist()
        );
    }
}
