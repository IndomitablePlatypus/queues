<?php

namespace Queues\Api\V1\Presentation\Http\Controllers\Workspaces;

use App\OpenApi\Requests\Customer\ChangeWorkspaceProfileRequestBody;
use App\OpenApi\Responses\BusinessWorkspaceResponse;
use App\OpenApi\Responses\Errors\AuthenticationExceptionResponse;
use App\OpenApi\Responses\Errors\UnexpectedExceptionResponse;
use App\OpenApi\Responses\Errors\ValidationErrorResponse;
use App\OpenApi\SecuritySchemes\BearerTokenSecurityScheme;
use Queues\Api\V1\Config\Routing\RouteName;
use Queues\Api\V1\Presentation\Http\Controllers\ApiController;
use Queues\Api\V1\Presentation\Http\Controllers\Workspaces\Requests\ChangeWorkspaceProfileRequest;
use Queues\Api\V1\Presentation\Http\Responses\BusinessWorkspace;
use Ramsey\Uuid\Guid\Guid;
use Vyuldashev\LaravelOpenApi\Attributes as OpenApi;

#[OpenApi\PathItem]
class WorkspacesChangeProfileController extends ApiController
{
    /**
     * Change workspace description
     *
     * Changes the current workspace description.
     * Requires user to be the owner of the current workspace.
     * @param Guid $workspaceId Workspace GUID
     */
    #[OpenApi\Operation(id: RouteName::CHANGE_PROFILE, tags: ['business', 'workspace'], security: BearerTokenSecurityScheme::class)]
    #[OpenApi\RequestBody(factory: ChangeWorkspaceProfileRequestBody::class)]
    #[OpenApi\Response(factory: BusinessWorkspaceResponse::class, statusCode: 200)]
    #[OpenApi\Response(factory: AuthenticationExceptionResponse::class, statusCode: 401)]
    #[OpenApi\Response(factory: ValidationErrorResponse::class, statusCode: 422)]
    #[OpenApi\Response(factory: UnexpectedExceptionResponse::class, statusCode: 500)]
    public function __invoke(ChangeWorkspaceProfileRequest $request)
    {
        return $this->respond(BusinessWorkspace::of(
            $this
                ->user()
                ->getWorkspace($request->workspaceId)
                ->fill($request->toArray())
                ->persist()
        ));
    }
}
