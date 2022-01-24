<?php

namespace Queues\Api\V1\Presentation\Http\Controllers\Plans;

use App\OpenApi\Responses\BusinessPlansResponse;
use App\OpenApi\Responses\Errors\AuthenticationExceptionResponse;
use App\OpenApi\Responses\Errors\UnexpectedExceptionResponse;
use Queues\Api\V1\Config\Routing\RouteName;
use Queues\Api\V1\Presentation\Http\Controllers\ApiController;
use Queues\Api\V1\Presentation\Http\Controllers\Plans\Requests\GetRequest;
use Queues\Api\V1\Presentation\Http\Responses\BusinessPlans;
use Ramsey\Uuid\Guid\Guid;
use Vyuldashev\LaravelOpenApi\Attributes as OpenApi;

#[OpenApi\PathItem]
class PlansGetController extends ApiController
{
    /**
     * Get plans
     *
     * Returns all plans in the current workspace.
     * Requires user to be authorized to work in the current workspace.
     * @param Guid $workspaceId Workspace GUID
     */
    #[OpenApi\Operation(id: RouteName::GET_PLANS, tags: ['business', 'plan'])]
    #[OpenApi\Response(factory: BusinessPlansResponse::class, statusCode: 200)]
    #[OpenApi\Response(factory: AuthenticationExceptionResponse::class, statusCode: 401)]
    #[OpenApi\Response(factory: UnexpectedExceptionResponse::class, statusCode: 500)]
    public function __invoke(GetRequest $request)
    {
        return $this->respond(BusinessPlans::of(...
            $this
                ->user()
                ->getWorkspace($request->workspaceId)
                ->getPlans()
                ->all()
        ));
    }
}
