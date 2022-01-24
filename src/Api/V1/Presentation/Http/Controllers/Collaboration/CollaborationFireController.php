<?php

namespace Queues\Api\V1\Presentation\Http\Controllers\Collaboration;

use App\OpenApi\Responses\CollaboratorIdResponse;
use App\OpenApi\Responses\Errors\AuthenticationExceptionResponse;
use App\OpenApi\Responses\Errors\DomainExceptionResponse;
use App\OpenApi\Responses\Errors\NotFoundResponse;
use App\OpenApi\Responses\Errors\UnexpectedExceptionResponse;
use Queues\Api\V1\Config\Routing\RouteName;
use Queues\Api\V1\Presentation\Http\Controllers\ApiController;
use Queues\Api\V1\Presentation\Http\Controllers\Collaboration\Requests\CollaborationFireRequest;
use Ramsey\Uuid\Guid\Guid;
use Vyuldashev\LaravelOpenApi\Attributes as OpenApi;

#[OpenApi\PathItem]
class CollaborationFireController extends ApiController
{
    /**
     * Remove collaborator
     *
     * Fires the collaborator from the team. User with the given id will no longer be able to work in the workspace.
     * Requires the current user to be the owner of the workspace.
     * @param Guid $workspaceId Workspace GUID
     * @param Guid $collaboratorId Collaborator GUID
     */
    #[OpenApi\Operation(id: RouteName::FIRE_COLLABORATOR, tags: ['business', 'collaboration'])]
    #[OpenApi\Response(factory: CollaboratorIdResponse::class, statusCode: 200)]
    #[OpenApi\Response(factory: DomainExceptionResponse::class, statusCode: 400)]
    #[OpenApi\Response(factory: AuthenticationExceptionResponse::class, statusCode: 401)]
    #[OpenApi\Response(factory: NotFoundResponse::class, statusCode: 404)]
    #[OpenApi\Response(factory: UnexpectedExceptionResponse::class, statusCode: 500)]
    public function __invoke(CollaborationFireRequest $request)
    {
        return $this->respond(
            $this
                ->user()
                ->getOwnWorkspace($request->workspaceId)
                ->fire($request->collaboratorId)
        );
    }
}
