<?php

namespace Queues\Api\V1\Presentation\Http\Controllers\Customer;

use App\Jobs\ClearTokens;
use App\Models\User;
use Queues\Api\V1\Presentation\Http\Controllers\ApiController;
use Queues\Api\V1\Presentation\Http\Controllers\Customer\Requests\SignInRequest;

class SignInController extends ApiController
{
    public function __invoke(SignInRequest $request)
    {
        $user = User::findByCredentialsOrFail($request->username, $request->password);
        $token = $user->createToken($request->userAgent());
        ClearTokens::dispatch($user, $token->accessToken->name);
        return $this->respond($token->plainTextToken);
    }
}
