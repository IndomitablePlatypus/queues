<?php

namespace Queues\Api\V1\Presentation\Http\Controllers\Cards;

use App\OpenApi\Responses\BusinessCardResponse;
use App\OpenApi\Responses\Errors\AuthenticationExceptionResponse;
use App\OpenApi\Responses\Errors\DomainExceptionResponse;
use App\OpenApi\Responses\Errors\NotFoundResponse;
use App\OpenApi\Responses\Errors\UnexpectedExceptionResponse;
use Queues\Api\V1\Config\Routing\RouteName;
use Queues\Api\V1\Presentation\Http\Controllers\ApiController;
use Queues\Api\V1\Presentation\Http\Controllers\Cards\Requests\CardRequest;
use Queues\Api\V1\Presentation\Http\Responses\BusinessCard;
use Ramsey\Uuid\Guid\Guid;
use Vyuldashev\LaravelOpenApi\Attributes as OpenApi;

#[OpenApi\PathItem]
class CardsBlockController extends ApiController
{
    /**
     * Block card
     *
     * Marks card as blocked, meaning the owner cannot use it temporarily until it's unblocked.
     * Requires user to be authorized to work in the current workspace.
     * @param Guid $workspaceId Workspace GUID
     * @param Guid $cardId Card GUID
     */
    #[OpenApi\Operation(id: RouteName::BLOCK_CARD, tags: ['business', 'card'])]
    #[OpenApi\Response(factory: BusinessCardResponse::class, statusCode: 200)]
    #[OpenApi\Response(factory: DomainExceptionResponse::class, statusCode: 400)]
    #[OpenApi\Response(factory: AuthenticationExceptionResponse::class, statusCode: 401)]
    #[OpenApi\Response(factory: NotFoundResponse::class, statusCode: 404)]
    #[OpenApi\Response(factory: UnexpectedExceptionResponse::class, statusCode: 500)]
    public function __invoke(CardRequest $request)
    {
        return $this->respond(BusinessCard::of(
            $this
                ->user()
                ->getWorkspace($request->workspaceId)
                ->getCard($request->cardId)
                ->block()
                ->persist()
        ));
    }
}
