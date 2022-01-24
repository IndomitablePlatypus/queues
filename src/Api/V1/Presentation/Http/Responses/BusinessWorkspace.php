<?php

namespace Queues\Api\V1\Presentation\Http\Responses;

use App\Models\Workspace;
use JsonSerializable;

class BusinessWorkspace implements JsonSerializable
{
    public function __construct(protected Workspace $workspace)
    {
    }

    public static function of(Workspace $workspace): static
    {
        return new static($workspace);
    }

    public function jsonSerialize(): array
    {
        return [
            'workspaceId' => $this->workspace->workspace_id,
            'keeperId' => $this->workspace->keeper_id,
            'name' => $this->workspace->profile['name'],
            'description' => $this->workspace->profile['description'],
            'address' => $this->workspace->profile['address'],
        ];
    }

}
