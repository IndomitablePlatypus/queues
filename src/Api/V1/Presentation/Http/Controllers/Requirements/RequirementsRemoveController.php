<?php

namespace Queues\Api\V1\Presentation\Http\Controllers\Requirements;

use App\OpenApi\Responses\BusinessPlanResponse;
use App\OpenApi\Responses\Errors\AuthenticationExceptionResponse;
use App\OpenApi\Responses\Errors\NotFoundResponse;
use App\OpenApi\Responses\Errors\UnexpectedExceptionResponse;
use Queues\Api\V1\Config\Routing\RouteName;
use Queues\Api\V1\Presentation\Http\Controllers\ApiController;
use Queues\Api\V1\Presentation\Http\Controllers\Requirements\Requests\RemoveRequirementRequest;
use Queues\Api\V1\Presentation\Http\Responses\BusinessPlan;
use Ramsey\Uuid\Guid\Guid;
use Vyuldashev\LaravelOpenApi\Attributes as OpenApi;

#[OpenApi\PathItem]
class RequirementsRemoveController extends ApiController
{
    /**
     * Remove plan requirement
     *
     * Removes the requirement from the plan. Requirement changes are propagated to the relevant cards.
     * Requires user to be authorized to work in the current workspace.
     * @param Guid $workspaceId Workspace GUID
     * @param Guid $planId Plan GUID
     * @param Guid $requirementId Requirement GUID
     */
    #[OpenApi\Operation(id: RouteName::REMOVE_PLAN_REQUIREMENT, tags: ['business', 'plan', 'requirement'])]
    #[OpenApi\Response(factory: BusinessPlanResponse::class, statusCode: 200)]
    #[OpenApi\Response(factory: AuthenticationExceptionResponse::class, statusCode: 401)]
    #[OpenApi\Response(factory: NotFoundResponse::class, statusCode: 404)]
    #[OpenApi\Response(factory: UnexpectedExceptionResponse::class, statusCode: 500)]
    public function __invoke(RemoveRequirementRequest $request)
    {
        return $this->respond(BusinessPlan::of(
            $this
                ->user()
                ->getWorkspace($request->workspaceId)
                ->getPlan($request->planId)
                ->getRequirement($request->requirementId)
                ->remove()
                ->persistInPlan()
        ));
    }
}
