<?php

namespace Queues\Api\V1\Presentation\Http\Controllers\Collaboration;

use App\Models\Invite;
use Queues\Api\V1\Presentation\Http\Controllers\ApiController;
use Queues\Api\V1\Presentation\Http\Controllers\Collaboration\Requests\InviteRequest;
use Vyuldashev\LaravelOpenApi\Attributes as OpenApi;

#[OpenApi\PathItem]
class InviteAcceptController extends ApiController
{
    public function __invoke(InviteRequest $request)
    {
        return $this->respond(
            Invite::query()
                ->findOrFail($request->inviteId)
                ?->accept($this->userId())
        );
    }
}
