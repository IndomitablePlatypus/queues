<?php

namespace Queues\Api\V1\Presentation\Http\Controllers\Requirements;

use App\OpenApi\Requests\Customer\ChangeRequirementDescriptionRequestBody;
use App\OpenApi\Responses\BusinessPlanResponse;
use App\OpenApi\Responses\Errors\AuthenticationExceptionResponse;
use App\OpenApi\Responses\Errors\NotFoundResponse;
use App\OpenApi\Responses\Errors\UnexpectedExceptionResponse;
use App\OpenApi\Responses\Errors\ValidationErrorResponse;
use Queues\Api\V1\Config\Routing\RouteName;
use Queues\Api\V1\Presentation\Http\Controllers\ApiController;
use Queues\Api\V1\Presentation\Http\Controllers\Requirements\Requests\ChangeRequirementRequest;
use Queues\Api\V1\Presentation\Http\Responses\BusinessPlan;
use Ramsey\Uuid\Guid\Guid;
use Vyuldashev\LaravelOpenApi\Attributes as OpenApi;

#[OpenApi\PathItem]
class RequirementsChangeController extends ApiController
{
    /**
     * Change plan requirement description
     *
     * Changes the requirement description. Description changes are propagated to the relevant cards.
     * Requires user to be authorized to work in the current workspace.
     * @param Guid $workspaceId Workspace GUID
     * @param Guid $planId Plan GUID
     * @param Guid $requirementId Requirement GUID
     */
    #[OpenApi\Operation(id: RouteName::CHANGE_PLAN_REQUIREMENT, tags: ['business', 'plan', 'requirement'])]
    #[OpenApi\RequestBody(factory: ChangeRequirementDescriptionRequestBody::class)]
    #[OpenApi\Response(factory: BusinessPlanResponse::class, statusCode: 200)]
    #[OpenApi\Response(factory: AuthenticationExceptionResponse::class, statusCode: 401)]
    #[OpenApi\Response(factory: NotFoundResponse::class, statusCode: 404)]
    #[OpenApi\Response(factory: ValidationErrorResponse::class, statusCode: 422)]
    #[OpenApi\Response(factory: UnexpectedExceptionResponse::class, statusCode: 500)]
    public function __invoke(ChangeRequirementRequest $request)
    {
        return $this->respond(BusinessPlan::of(
            $this
                ->user()
                ->getWorkspace($request->workspaceId)
                ->getPlan($request->planId)
                ->getRequirement($request->requirementId)
                ->setDescription($request->description)
                ->persistInPlan()
        ));
    }
}
