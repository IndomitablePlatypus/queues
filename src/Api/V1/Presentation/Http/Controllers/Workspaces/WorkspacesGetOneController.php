<?php

namespace Queues\Api\V1\Presentation\Http\Controllers\Workspaces;

use App\OpenApi\Responses\BusinessWorkspaceResponse;
use App\OpenApi\Responses\Errors\AuthenticationExceptionResponse;
use App\OpenApi\Responses\Errors\NotFoundResponse;
use App\OpenApi\Responses\Errors\UnexpectedExceptionResponse;
use App\OpenApi\SecuritySchemes\BearerTokenSecurityScheme;
use Queues\Api\V1\Config\Routing\RouteName;
use Queues\Api\V1\Presentation\Http\Controllers\ApiController;
use Queues\Api\V1\Presentation\Http\Controllers\Workspaces\Requests\GetOneRequest;
use Queues\Api\V1\Presentation\Http\Responses\BusinessWorkspace;
use Ramsey\Uuid\Guid\Guid;
use Vyuldashev\LaravelOpenApi\Attributes as OpenApi;

#[OpenApi\PathItem]
class WorkspacesGetOneController extends ApiController
{
    /**
     * Get a workspace
     *
     * Returns workspace where the current user is a collaborator.
     * Requires user to be authorized to work in this workspace.
     * @param Guid $workspaceId Workspace GUID
     */
    #[OpenApi\Operation(id: RouteName::GET_WORKSPACE, tags: ['business', 'workspace'], security: BearerTokenSecurityScheme::class)]
    #[OpenApi\Response(factory: BusinessWorkspaceResponse::class, statusCode: 200)]
    #[OpenApi\Response(factory: AuthenticationExceptionResponse::class, statusCode: 401)]
    #[OpenApi\Response(factory: NotFoundResponse::class, statusCode: 404)]
    #[OpenApi\Response(factory: UnexpectedExceptionResponse::class, statusCode: 500)]
    public function __invoke(GetOneRequest $request)
    {
        return $this->respond(BusinessWorkspace::of(
            $this
                ->user()
                ->getWorkspace($request->workspaceId)
        ));
    }
}
