<?php

namespace Queues\Api\V1\Presentation\Http\Controllers\Customer;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Queues\Api\V1\Presentation\Http\Controllers\ApiController;
use Queues\Api\V1\Presentation\Http\Controllers\Customer\Requests\SignUpRequest;

class SignUpController extends ApiController
{
    public function __invoke(SignUpRequest $request)
    {
        $user = new User($request->toArray());
        $user->save();
        Auth::login($user);
        $plainTextToken = $user->createToken($request->userAgent())->plainTextToken;
        return $this->respond($plainTextToken);
    }
}
