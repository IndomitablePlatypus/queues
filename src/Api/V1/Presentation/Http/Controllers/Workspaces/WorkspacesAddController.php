<?php

namespace Queues\Api\V1\Presentation\Http\Controllers\Workspaces;

use App\OpenApi\Requests\Customer\AddWorkspaceRequestBody;
use App\OpenApi\Responses\BusinessWorkspaceResponse;
use App\OpenApi\Responses\Errors\AuthenticationExceptionResponse;
use App\OpenApi\Responses\Errors\UnexpectedExceptionResponse;
use App\OpenApi\Responses\Errors\ValidationErrorResponse;
use App\OpenApi\SecuritySchemes\BearerTokenSecurityScheme;
use Queues\Api\V1\Config\Routing\RouteName;
use Queues\Api\V1\Domain\RelationType;
use Queues\Api\V1\Presentation\Http\Controllers\ApiController;
use Queues\Api\V1\Presentation\Http\Controllers\Workspaces\Requests\AddWorkspaceRequest;
use Queues\Api\V1\Presentation\Http\Responses\BusinessWorkspace;
use Vyuldashev\LaravelOpenApi\Attributes as OpenApi;

#[OpenApi\PathItem]
class WorkspacesAddController extends ApiController
{
    /**
     * Add a new workspace
     *
     * Returns the newly created workspace where the current user is an owner.
     */
    #[OpenApi\Operation(id: RouteName::ADD_WORKSPACE, tags: ['business', 'workspace'], security: BearerTokenSecurityScheme::class)]
    #[OpenApi\RequestBody(factory: AddWorkspaceRequestBody::class)]
    #[OpenApi\Response(factory: BusinessWorkspaceResponse::class, statusCode: 200)]
    #[OpenApi\Response(factory: AuthenticationExceptionResponse::class, statusCode: 401)]
    #[OpenApi\Response(factory: ValidationErrorResponse::class, statusCode: 422)]
    #[OpenApi\Response(factory: UnexpectedExceptionResponse::class, statusCode: 500)]
    public function __invoke(AddWorkspaceRequest $request)
    {
        return $this->respond(BusinessWorkspace::of(
            $this
                ->user()
                ->addWorkspace($request->toArray())
                ->persist()
                ->relateTo($this->userId(), RelationType::KEEPER())
        ));
    }
}
