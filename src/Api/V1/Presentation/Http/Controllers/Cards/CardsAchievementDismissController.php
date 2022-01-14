<?php

namespace Queues\Api\V1\Presentation\Http\Controllers\Cards;

use App\OpenApi\Responses\BusinessCardResponse;
use App\OpenApi\Responses\Errors\AuthenticationExceptionResponse;
use App\OpenApi\Responses\Errors\DomainExceptionResponse;
use App\OpenApi\Responses\Errors\NotFoundResponse;
use App\OpenApi\Responses\Errors\UnexpectedExceptionResponse;
use Queues\Api\V1\Config\Routing\RouteName;
use Queues\Api\V1\Presentation\Http\Controllers\ApiController;
use Queues\Api\V1\Presentation\Http\Controllers\Cards\Requests\NoteAchievementRequest;
use Ramsey\Uuid\Guid\Guid;
use Vyuldashev\LaravelOpenApi\Attributes as OpenApi;

#[OpenApi\PathItem]
class CardsAchievementDismissController extends ApiController
{
    /**
     * Dismiss achievement from the card
     *
     * Removes achievement and removes satisfaction mark from the card if necessary.
     * Can only be done until the card owner received their bonus.
     * Requires user to be authorized to work in the current workspace.
     * @param Guid $workspaceId Workspace GUID
     * @param Guid $cardId Card GUID
     * @param Guid $achievementId Achievement GUID
     */
    #[OpenApi\Operation(id: RouteName::DISMISS_ACHIEVEMENT, tags: ['business', 'card'])]
    #[OpenApi\Response(factory: BusinessCardResponse::class, statusCode: 200)]
    #[OpenApi\Response(factory: DomainExceptionResponse::class, statusCode: 400)]
    #[OpenApi\Response(factory: AuthenticationExceptionResponse::class, statusCode: 401)]
    #[OpenApi\Response(factory: NotFoundResponse::class, statusCode: 404)]
    #[OpenApi\Response(factory: UnexpectedExceptionResponse::class, statusCode: 500)]
    public function __invoke(NoteAchievementRequest $request)
    {
        return $this->respond(
            $this
                ->user()
                ->getWorkspace($request->workspaceId)
                ->getCard($request->cardId)
                ->dismissAchievement($request->achievementId)
                ->persist()
        );
    }
}
