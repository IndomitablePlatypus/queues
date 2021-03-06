<?php

namespace Queues\Api\V1\Presentation\Http\Controllers\Plans;

use App\OpenApi\Responses\BusinessPlanResponse;
use App\OpenApi\Responses\Errors\AuthenticationExceptionResponse;
use App\OpenApi\Responses\Errors\AuthorizationExceptionResponse;
use App\OpenApi\Responses\Errors\NotFoundResponse;
use App\OpenApi\Responses\Errors\UnexpectedExceptionResponse;
use Queues\Api\V1\Config\Routing\RouteName;
use Queues\Api\V1\Presentation\Http\Controllers\ApiController;
use Queues\Api\V1\Presentation\Http\Controllers\Plans\Requests\PlanRequest;
use Queues\Api\V1\Presentation\Http\Responses\BusinessPlan;
use Ramsey\Uuid\Guid\Guid;
use Vyuldashev\LaravelOpenApi\Attributes as OpenApi;

#[OpenApi\PathItem]
class PlansArchiveController extends ApiController
{
    /**
     * Archive a plan
     *
     * Archives plan. Archived plans are invisible by normal means. Plans are archived automatically on their expiration date.
     * Requires user to be authorized to work in the current workspace.
     * @param Guid $workspaceId Workspace GUID
     * @param Guid $planId Plan GUID
     */
    #[OpenApi\Operation(id: RouteName::ARCHIVE_PLAN, tags: ['business', 'plan'])]
    #[OpenApi\Response(factory: BusinessPlanResponse::class, statusCode: 200)]
    #[OpenApi\Response(factory: AuthenticationExceptionResponse::class, statusCode: 401)]
    #[OpenApi\Response(factory: NotFoundResponse::class, statusCode: 404)]
    #[OpenApi\Response(factory: UnexpectedExceptionResponse::class, statusCode: 500)]
    public function __invoke(PlanRequest $request)
    {
        return $this->respond(BusinessPlan::of(
            $this
                ->user()
                ->getWorkspace($request->workspaceId)
                ->getPlan($request->planId)
                ->archive()
                ->persist()
        ));
    }
}
