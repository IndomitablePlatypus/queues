<?php

namespace Queues\Api\V1\Presentation\Http\Controllers\Customer;

use App\Jobs\ClearTokens;
use Illuminate\Http\Request;
use Queues\Api\V1\Presentation\Http\Controllers\ApiController;

class SignOutController extends ApiController
{
    public function __invoke(Request $request)
    {
        $user = $request->user();
        ClearTokens::dispatch($user);
        return $this->respond();
    }
}
