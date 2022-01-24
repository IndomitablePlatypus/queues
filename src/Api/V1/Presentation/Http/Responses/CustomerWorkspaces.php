<?php

namespace Queues\Api\V1\Presentation\Http\Responses;

use App\Models\Workspace;
use JsonSerializable;

class CustomerWorkspaces implements JsonSerializable
{
    /** @var Workspace[] */
    protected array $workspaces;

    public function __construct(array $workspaces)
    {
        $this->workspaces = $workspaces;
    }

    public static function of(Workspace ...$workspaces): static
    {
        return new static($workspaces);
    }

    public function jsonSerialize(): array
    {
        return [
            ...array_map(fn($workspace) => $this->serializeWorkspace($workspace), $this->workspaces),
        ];
    }

    protected function serializeWorkspace(Workspace $workspace): array
    {
        return [
            'workspaceId' => $workspace->workspace_id,
            'name' => $workspace->name,
            'description' => $workspace->description,
            'address' => $workspace->address,
        ];
    }

}
