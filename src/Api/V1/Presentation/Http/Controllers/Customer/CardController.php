<?php

namespace Queues\Api\V1\Presentation\Http\Controllers\Customer;

use Queues\Api\V1\Presentation\Http\Controllers\ApiController;
use Queues\Api\V1\Presentation\Http\Controllers\Customer\Requests\CardRequest;

class CardController extends ApiController
{
    public function __invoke(CardRequest $request)
    {
        return $this->respond(
            $this
                ->user()
                ->getCard($request->cardId)
        );
    }
}
