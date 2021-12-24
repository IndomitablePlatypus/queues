<?php

namespace Queues\Api\V1\Presentation\Http\Controllers\Customer;

use App\Models\Workspace;
use Illuminate\Http\Request;
use Queues\Api\V1\Presentation\Http\Controllers\ApiController;

class WorkspacesAllController extends ApiController
{
    public function __invoke(Request $request)
    {
        $workspaces = Workspace::all();
        return $this->respond($workspaces);
    }
}
