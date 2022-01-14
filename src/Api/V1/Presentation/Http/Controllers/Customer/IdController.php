<?php

namespace Queues\Api\V1\Presentation\Http\Controllers\Customer;

use Queues\Api\V1\Presentation\Http\Controllers\ApiController;

class IdController extends ApiController
{
    public function __invoke()
    {
        return $this->respond(
            $this
                ->user()
                ->id
        );
    }
}
