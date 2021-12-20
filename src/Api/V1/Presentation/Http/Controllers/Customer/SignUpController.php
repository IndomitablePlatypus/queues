<?php

namespace Queues\Api\V1\Presentation\Http\Controllers\Customer;

use Queues\Api\V1\Presentation\Http\Controllers\ApiController;
use Queues\Api\V1\Presentation\Http\Controllers\Customer\Requests\SignUpRequest;

class SignUpController extends ApiController
{
    public function __invoke(SignUpRequest $request)
    {
        return $this->respond($request->all());
    }
}
