<?php

namespace Queues\Api\V1\Presentation\Http\Controllers\Workspaces;

use App\OpenApi\Responses\BusinessWorkspacesResponse;
use App\OpenApi\Responses\Errors\AuthenticationExceptionResponse;
use App\OpenApi\Responses\Errors\UnexpectedExceptionResponse;
use App\OpenApi\SecuritySchemes\BearerTokenSecurityScheme;
use Queues\Api\V1\Config\Routing\RouteName;
use Queues\Api\V1\Presentation\Http\Controllers\ApiController;
use Queues\Api\V1\Presentation\Http\Controllers\Workspaces\Requests\GetRequest;
use Queues\Api\V1\Presentation\Http\Responses\BusinessWorkspaces;
use Vyuldashev\LaravelOpenApi\Attributes as OpenApi;

#[OpenApi\PathItem]
class WorkspacesGetController extends ApiController
{
    /**
     * Get workspaces
     *
     * Returns all workspaces where the current user is a collaborator.
     */
    #[OpenApi\Operation(id: RouteName::GET_WORKSPACES, tags: ['business', 'workspace'], security: BearerTokenSecurityScheme::class)]
    #[OpenApi\Response(factory: BusinessWorkspacesResponse::class, statusCode: 200)]
    #[OpenApi\Response(factory: AuthenticationExceptionResponse::class, statusCode: 401)]
    #[OpenApi\Response(factory: UnexpectedExceptionResponse::class, statusCode: 500)]
    public function __invoke(GetRequest $request)
    {
        return $this->respond(BusinessWorkspaces::of(...
            $this
                ->user()
                ->getWorkspaces()
                ->all()
        ));
    }
}
