<?php

namespace Queues\Api\V1\Presentation\Http\Controllers\Customer;

use App\OpenApi\Responses\Errors\AuthenticationExceptionResponse;
use App\OpenApi\Responses\Errors\UnexpectedExceptionResponse;
use App\OpenApi\Responses\IssuedCardsResponse;
use App\OpenApi\SecuritySchemes\BearerTokenSecurityScheme;
use Queues\Api\V1\Config\Routing\RouteName;
use Queues\Api\V1\Presentation\Http\Controllers\ApiController;
use Vyuldashev\LaravelOpenApi\Attributes as OpenApi;

#[OpenApi\PathItem]
class CardsAllController extends ApiController
{
    /**
     * User cards
     *
     * Returns all active cards for the current user.
     */
    #[OpenApi\Operation(id: RouteName::CUSTOMER_CARDS, tags: ['customer'], security: BearerTokenSecurityScheme::class)]
    #[OpenApi\Response(factory: IssuedCardsResponse::class, statusCode: 200)]
    #[OpenApi\Response(factory: AuthenticationExceptionResponse::class, statusCode: 401)]
    #[OpenApi\Response(factory: UnexpectedExceptionResponse::class, statusCode: 500)]
    public function __invoke()
    {
        return $this->respond(
            $this
                ->user()
                ->getCards()
        );
    }
}
