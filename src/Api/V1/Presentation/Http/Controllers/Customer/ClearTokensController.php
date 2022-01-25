<?php

namespace Queues\Api\V1\Presentation\Http\Controllers\Customer;

use App\Jobs\ClearTokens;
use App\OpenApi\Responses\ClearTokensResponse;
use App\OpenApi\Responses\Errors\AuthenticationExceptionResponse;
use App\OpenApi\Responses\Errors\UnexpectedExceptionResponse;
use Illuminate\Http\Request;
use Queues\Api\V1\Config\Routing\RouteName;
use Queues\Api\V1\Presentation\Http\Controllers\ApiController;
use Vyuldashev\LaravelOpenApi\Attributes as OpenApi;

#[OpenApi\PathItem]
class ClearTokensController extends ApiController
{
    /**
     * Clear user tokens
     *
     * Removes all existing access tokens for the current user. (I.e. logout)
     */
    #[OpenApi\Operation(id: RouteName::CLEAR_TOKENS, tags: ['customer'])]
    #[OpenApi\Response(factory: ClearTokensResponse::class, statusCode: 200)]
    #[OpenApi\Response(factory: AuthenticationExceptionResponse::class, statusCode: 401)]
    #[OpenApi\Response(factory: UnexpectedExceptionResponse::class, statusCode: 500)]
    public function __invoke(Request $request)
    {
        $user = $request->user();
        ClearTokens::dispatch($user);
        return $this->respond($user->id);
    }
}
