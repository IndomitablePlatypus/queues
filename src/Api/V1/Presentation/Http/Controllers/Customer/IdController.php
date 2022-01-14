<?php

namespace Queues\Api\V1\Presentation\Http\Controllers\Customer;

use App\OpenApi\Responses\CustomerIdResponse;
use App\OpenApi\Responses\Errors\AuthenticationExceptionResponse;
use App\OpenApi\Responses\Errors\AuthorizationExceptionResponse;
use App\OpenApi\Responses\Errors\UnexpectedExceptionResponse;
use App\OpenApi\SecuritySchemes\BearerTokenSecurityScheme;
use Queues\Api\V1\Config\Routing\RouteName;
use Queues\Api\V1\Presentation\Http\Controllers\ApiController;
use Vyuldashev\LaravelOpenApi\Attributes as OpenApi;

#[OpenApi\PathItem]
class IdController extends ApiController
{
    /**
     * Get authorized user id
     *
     * Returns id of the authenticated user.
     */
    #[OpenApi\Operation(id: RouteName::CUSTOMER_ID, tags: ['customer'], security: BearerTokenSecurityScheme::class)]
    #[OpenApi\Response(factory: CustomerIdResponse::class, statusCode: 200)]
    #[OpenApi\Response(factory: AuthenticationExceptionResponse::class, statusCode: 401)]
    #[OpenApi\Response(factory: UnexpectedExceptionResponse::class, statusCode: 500)]
    public function __invoke()
    {
        return $this->respond(
            $this
                ->user()
                ->id
        );
    }
}
