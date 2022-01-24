<?php

namespace Queues\Api\V1\Presentation\Http\Controllers\Customer;

use App\Models\Workspace;
use App\OpenApi\Requests\Customer\RegisterRequestBody;
use App\OpenApi\Responses\ApiAccessTokenResponse;
use App\OpenApi\Responses\Errors\UnexpectedExceptionResponse;
use App\OpenApi\Responses\Errors\UserAlreadyRegisteredExceptionResponse;
use App\OpenApi\Responses\Errors\ValidationErrorResponse;
use Illuminate\Http\Request;
use Queues\Api\V1\Config\Routing\RouteName;
use Queues\Api\V1\Presentation\Http\Controllers\ApiController;
use Queues\Api\V1\Presentation\Http\Responses\CustomerWorkspaces;
use Vyuldashev\LaravelOpenApi\Attributes as OpenApi;

#[OpenApi\PathItem]
class WorkspacesAllController extends ApiController
{
    /**
     * Register user
     *
     * Registers new user with email OR phone, password, device name (for token). Returns new auth token.
     */
    #[OpenApi\Operation(id: RouteName::REGISTER, tags: ['customer'])]
    #[OpenApi\RequestBody(factory: RegisterRequestBody::class)]
    #[OpenApi\Response(factory: ApiAccessTokenResponse::class, statusCode: 200)]
    #[OpenApi\Response(factory: UserAlreadyRegisteredExceptionResponse::class, statusCode: 400)]
    #[OpenApi\Response(factory: ValidationErrorResponse::class, statusCode: 422)]
    #[OpenApi\Response(factory: UnexpectedExceptionResponse::class, statusCode: 500)]
    public function __invoke(Request $request)
    {
        $workspaces = Workspace::all();
        return $this->respond(CustomerWorkspaces::of(...$workspaces));
    }
}
