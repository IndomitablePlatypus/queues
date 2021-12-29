<?php

namespace Queues\Api\V1\Presentation\Http\Controllers\Cards;

use Queues\Api\V1\Presentation\Http\Controllers\ApiController;
use Queues\Api\V1\Presentation\Http\Controllers\Cards\Requests\IssueCardRequest;

class CardsIssueController extends ApiController
{
    public function __invoke(IssueCardRequest $request)
    {
        return $this->respond(
            $this
                ->user()
                ->getWorkspace($request->workspaceId)
                ->getPlan($request->planId)
                ->issueCard($request->customerId)
                ->persist()
        );
    }
}
