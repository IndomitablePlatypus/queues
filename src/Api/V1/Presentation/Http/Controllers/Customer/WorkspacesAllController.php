<?php

namespace Queues\Api\V1\Presentation\Http\Controllers\Customer;

use App\Models\Workspace;
use App\OpenApi\Responses\CustomerWorkspacesResponse;
use App\OpenApi\Responses\Errors\UnexpectedExceptionResponse;
use Illuminate\Http\Request;
use Queues\Api\V1\Config\Routing\RouteName;
use Queues\Api\V1\Presentation\Http\Controllers\ApiController;
use Queues\Api\V1\Presentation\Http\Responses\CustomerWorkspaces;
use Vyuldashev\LaravelOpenApi\Attributes as OpenApi;

#[OpenApi\PathItem]
class WorkspacesAllController extends ApiController
{
    /**
     * Workspaces
     *
     * Returns all workspaces
     */
    #[OpenApi\Operation(id: RouteName::CUSTOMER_WORKSPACES, tags: ['customer'])]
    #[OpenApi\Response(factory: CustomerWorkspacesResponse::class, statusCode: 200)]
    #[OpenApi\Response(factory: UnexpectedExceptionResponse::class, statusCode: 500)]
    public function __invoke(Request $request)
    {
        $workspaces = Workspace::all();
        return $this->respond(CustomerWorkspaces::of(...$workspaces));
    }
}
