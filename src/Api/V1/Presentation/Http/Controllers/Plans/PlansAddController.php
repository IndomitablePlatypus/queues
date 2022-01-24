<?php

namespace Queues\Api\V1\Presentation\Http\Controllers\Plans;

use App\OpenApi\Requests\Customer\AddPlanRequestBody;
use App\OpenApi\Responses\BusinessPlanResponse;
use App\OpenApi\Responses\Errors\AuthenticationExceptionResponse;
use App\OpenApi\Responses\Errors\AuthorizationExceptionResponse;
use App\OpenApi\Responses\Errors\UnexpectedExceptionResponse;
use App\OpenApi\Responses\Errors\ValidationErrorResponse;
use Queues\Api\V1\Config\Routing\RouteName;
use Queues\Api\V1\Presentation\Http\Controllers\ApiController;
use Queues\Api\V1\Presentation\Http\Controllers\Plans\Requests\AddPlanRequest;
use Queues\Api\V1\Presentation\Http\Responses\BusinessPlan;
use Ramsey\Uuid\Guid\Guid;
use Vyuldashev\LaravelOpenApi\Attributes as OpenApi;

#[OpenApi\PathItem]
class PlansAddController extends ApiController
{
    /**
     * Add a new plan
     *
     * Adds a new plan to the current workspace.
     * Requires user to be authorized to work in the current workspace.
     * @param Guid $workspaceId Workspace GUID
     */
    #[OpenApi\Operation(id: RouteName::ADD_PLAN, tags: ['business', 'plan'])]
    #[OpenApi\RequestBody(factory: AddPlanRequestBody::class)]
    #[OpenApi\Response(factory: BusinessPlanResponse::class, statusCode: 200)]
    #[OpenApi\Response(factory: AuthenticationExceptionResponse::class, statusCode: 401)]
    #[OpenApi\Response(factory: ValidationErrorResponse::class, statusCode: 422)]
    #[OpenApi\Response(factory: UnexpectedExceptionResponse::class, statusCode: 500)]
    public function __invoke(AddPlanRequest $request)
    {
        return $this->respond(BusinessPlan::of(
            $this
                ->user()
                ->getWorkspace($request->workspaceId)
                ->addPlan($request->name, $request->description)
                ->persist()
        ));
    }
}
