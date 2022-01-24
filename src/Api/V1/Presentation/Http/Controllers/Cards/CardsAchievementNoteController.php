<?php

namespace Queues\Api\V1\Presentation\Http\Controllers\Cards;

use App\OpenApi\Requests\Customer\NoteCardAchievementRequestBody;
use App\OpenApi\Responses\BusinessCardResponse;
use App\OpenApi\Responses\Errors\AuthenticationExceptionResponse;
use App\OpenApi\Responses\Errors\DomainExceptionResponse;
use App\OpenApi\Responses\Errors\NotFoundResponse;
use App\OpenApi\Responses\Errors\UnexpectedExceptionResponse;
use App\OpenApi\Responses\Errors\ValidationErrorResponse;
use Queues\Api\V1\Config\Routing\RouteName;
use Queues\Api\V1\Presentation\Http\Controllers\ApiController;
use Queues\Api\V1\Presentation\Http\Controllers\Cards\Requests\NoteAchievementRequest;
use Queues\Api\V1\Presentation\Http\Responses\BusinessCard;
use Ramsey\Uuid\Guid\Guid;
use Vyuldashev\LaravelOpenApi\Attributes as OpenApi;

#[OpenApi\PathItem]
class CardsAchievementNoteController extends ApiController
{
    /**
     * Note achievement to the card
     *
     * Marks one of the Plan requirements as achieved in the customer card.
     * Card will be marked as satisfied shortly after the last requirement is marked.
     * Meaning the card owner is now legible for the bonus.
     * Requires user to be authorized to work in the current workspace.
     * @param Guid $workspaceId Workspace GUID
     * @param Guid $cardId Card GUID
     */
    #[OpenApi\Operation(id: RouteName::NOTE_ACHIEVEMENT, tags: ['business', 'card'])]
    #[OpenApi\RequestBody(factory: NoteCardAchievementRequestBody::class)]
    #[OpenApi\Response(factory: BusinessCardResponse::class, statusCode: 200)]
    #[OpenApi\Response(factory: DomainExceptionResponse::class, statusCode: 400)]
    #[OpenApi\Response(factory: AuthenticationExceptionResponse::class, statusCode: 401)]
    #[OpenApi\Response(factory: NotFoundResponse::class, statusCode: 404)]
    #[OpenApi\Response(factory: ValidationErrorResponse::class, statusCode: 422)]
    #[OpenApi\Response(factory: UnexpectedExceptionResponse::class, statusCode: 500)]
    public function __invoke(NoteAchievementRequest $request)
    {
        return $this->respond(BusinessCard::of(
            $this
                ->user()
                ->getWorkspace($request->workspaceId)
                ->getCard($request->cardId)
                ->noteAchievement($request->achievementId, $request->description)
                ->persist()
        ));
    }
}
