<?php

namespace Queues\Api\V1\Presentation\Http\Controllers\Collaboration;

use Queues\Api\V1\Presentation\Http\Controllers\ApiController;
use Queues\Api\V1\Presentation\Http\Controllers\Collaboration\Requests\InviteProposeRequest;
use Vyuldashev\LaravelOpenApi\Attributes as OpenApi;

#[OpenApi\PathItem]
class InviteProposeController extends ApiController
{
    public function __invoke(InviteProposeRequest $request)
    {
        return $this->respond(
            $this
                ->user()
                ->getOwnWorkspace($request->workspaceId)
                ->invite()
                ->persist()
        );
    }
}
