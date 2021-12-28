<?php

namespace Queues\Api\V1\Presentation\Http\Controllers\Plans;

use Queues\Api\V1\Presentation\Http\Controllers\ApiController;
use Queues\Api\V1\Presentation\Http\Controllers\Plans\Requests\GetRequest;

class PlansGetController extends ApiController
{
    public function __invoke(GetRequest $request)
    {
        return $this->respond(
            $this
                ->user()
                ->getWorkspace($request->workspaceId)
        );
    }
}
