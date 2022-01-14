<?php

namespace Queues\Api\V1\Presentation\Http\Controllers\Customer;

use App\OpenApi\Responses\Errors\AuthenticationExceptionResponse;
use App\OpenApi\Responses\Errors\NotFoundResponse;
use App\OpenApi\Responses\Errors\UnexpectedExceptionResponse;
use App\OpenApi\Responses\IssuedCardResponse;
use App\OpenApi\SecuritySchemes\BearerTokenSecurityScheme;
use Queues\Api\V1\Config\Routing\RouteName;
use Queues\Api\V1\Presentation\Http\Controllers\ApiController;
use Queues\Api\V1\Presentation\Http\Controllers\Customer\Requests\CardRequest;
use Ramsey\Uuid\Guid\Guid;
use Vyuldashev\LaravelOpenApi\Attributes as OpenApi;

#[OpenApi\PathItem]
class CardController extends ApiController
{
    /**
     * User card
     *
     * Returns an active card, owned by the current user, by its id.
     * @param Guid $cardId Card GUID
     */
    #[OpenApi\Operation(id: RouteName::CUSTOMER_CARD, tags: ['customer'], security: BearerTokenSecurityScheme::class)]
    #[OpenApi\Response(factory: IssuedCardResponse::class, statusCode: 200)]
    #[OpenApi\Response(factory: AuthenticationExceptionResponse::class, statusCode: 401)]
    #[OpenApi\Response(factory: NotFoundResponse::class, statusCode: 404)]
    #[OpenApi\Response(factory: UnexpectedExceptionResponse::class, statusCode: 500)]
    public function __invoke(CardRequest $request)
    {
        return $this->respond(
            $this
                ->user()
                ->getCard($request->cardId)
        );
    }
}
