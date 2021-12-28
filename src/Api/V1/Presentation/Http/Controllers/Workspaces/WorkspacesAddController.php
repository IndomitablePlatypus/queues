<?php

namespace Queues\Api\V1\Presentation\Http\Controllers\Workspaces;

use Queues\Api\V1\Domain\RelationType;
use Queues\Api\V1\Presentation\Http\Controllers\ApiController;
use Queues\Api\V1\Presentation\Http\Controllers\Workspaces\Requests\AddWorkspaceRequest;

class WorkspacesAddController extends ApiController
{
    public function __invoke(AddWorkspaceRequest $request)
    {
        return $this->respond(
            $this
                ->user()
                ->addWorkspace($request->toArray())
                ->persist()
                ->relateTo($this->userId(), RelationType::KEEPER())
        );
    }
}
