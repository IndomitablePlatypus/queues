<?php

namespace Queues\Api\V1\Presentation\Http\Controllers\Customer;

use App\Jobs\ClearTokens;
use App\Models\User;
use App\OpenApi\Requests\Customer\GetTokenRequestBody;
use App\OpenApi\Responses\ApiAccessTokenResponse;
use App\OpenApi\Responses\Errors\AuthenticationExceptionResponse;
use App\OpenApi\Responses\Errors\UnexpectedExceptionResponse;
use App\OpenApi\Responses\Errors\ValidationErrorResponse;
use Queues\Api\V1\Config\Routing\RouteName;
use Queues\Api\V1\Presentation\Http\Controllers\ApiController;
use Queues\Api\V1\Presentation\Http\Controllers\Customer\Requests\SignInRequest;
use Vyuldashev\LaravelOpenApi\Attributes as OpenApi;

#[OpenApi\PathItem]
class SignInController extends ApiController
{
    /**
     * Get user token
     *
     * Returns new API user token (for basic bearer auth). Requires identity, password and device name.
     */
    #[OpenApi\Operation(id: RouteName::GET_TOKEN, tags: ['customer'])]
    #[OpenApi\RequestBody(factory: GetTokenRequestBody::class)]
    #[OpenApi\Response(factory: ApiAccessTokenResponse::class, statusCode: 200)]
    #[OpenApi\Response(factory: AuthenticationExceptionResponse::class, statusCode: 401)]
    #[OpenApi\Response(factory: ValidationErrorResponse::class, statusCode: 422)]
    #[OpenApi\Response(factory: UnexpectedExceptionResponse::class, statusCode: 500)]
    public function __invoke(SignInRequest $request)
    {
        $user = User::findByCredentialsOrFail($request->username, $request->password);
        $token = $user->createToken($request->userAgent());
        ClearTokens::dispatch($user, $token->accessToken->name);
        return $this->respond($token->plainTextToken);
    }
}
