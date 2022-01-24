<?php

namespace Queues\Api\V1\Presentation\Http\Controllers\Requirements;

use App\OpenApi\Requests\Customer\AddRequirementRequestBody;
use App\OpenApi\Responses\BusinessPlanResponse;
use App\OpenApi\Responses\Errors\AuthenticationExceptionResponse;
use App\OpenApi\Responses\Errors\AuthorizationExceptionResponse;
use App\OpenApi\Responses\Errors\DomainExceptionResponse;
use App\OpenApi\Responses\Errors\NotFoundResponse;
use App\OpenApi\Responses\Errors\UnexpectedExceptionResponse;
use App\OpenApi\Responses\Errors\ValidationErrorResponse;
use Queues\Api\V1\Config\Routing\RouteName;
use Queues\Api\V1\Presentation\Http\Controllers\ApiController;
use Queues\Api\V1\Presentation\Http\Controllers\Requirements\Requests\AddRequirementRequest;
use Queues\Api\V1\Presentation\Http\Responses\BusinessPlan;
use Ramsey\Uuid\Guid\Guid;
use Vyuldashev\LaravelOpenApi\Attributes as OpenApi;

#[OpenApi\PathItem]
class RequirementsAddController extends ApiController
{
    /**
     * Add plan requirement
     *
     * Adds a new requirement to the plan. Requirement changes are propagated to the relevant cards.
     * Requires user to be authorized to work in the current workspace.
     * @param Guid $workspaceId Workspace GUID
     * @param Guid $planId Plan GUID
     */
    #[OpenApi\Operation(id: RouteName::ADD_PLAN_REQUIREMENT, tags: ['business', 'plan', 'requirement'])]
    #[OpenApi\RequestBody(factory: AddRequirementRequestBody::class)]
    #[OpenApi\Response(factory: BusinessPlanResponse::class, statusCode: 200)]
    #[OpenApi\Response(factory: DomainExceptionResponse::class, statusCode: 400)]
    #[OpenApi\Response(factory: AuthenticationExceptionResponse::class, statusCode: 401)]
    #[OpenApi\Response(factory: NotFoundResponse::class, statusCode: 404)]
    #[OpenApi\Response(factory: ValidationErrorResponse::class, statusCode: 422)]
    #[OpenApi\Response(factory: UnexpectedExceptionResponse::class, statusCode: 500)]
    public function __invoke(AddRequirementRequest $request)
    {
        return $this->respond(BusinessPlan::of(
            $this
                ->user()
                ->getWorkspace($request->workspaceId)
                ->getPlan($request->planId)
                ->addRequirement($request->description)
                ->persistInPlan()
        ));
    }
}
