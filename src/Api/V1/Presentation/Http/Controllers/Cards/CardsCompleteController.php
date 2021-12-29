<?php

namespace Queues\Api\V1\Presentation\Http\Controllers\Cards;

use Queues\Api\V1\Presentation\Http\Controllers\ApiController;
use Queues\Api\V1\Presentation\Http\Controllers\Cards\Requests\CardRequest;
use Queues\Api\V1\Presentation\Http\Controllers\Cards\Requests\IssueCardRequest;

class CardsCompleteController extends ApiController
{
    public function __invoke(CardRequest $request)
    {
        return $this->respond(
            $this
                ->user()
                ->getWorkspace($request->workspaceId)
                ->getCard($request->cardId)
                ->complete()
                ->persist()
        );
    }
}
