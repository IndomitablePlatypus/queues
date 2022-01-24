<?php

namespace Queues\Api\V1\Presentation\Http\Responses;

use App\Models\Workspace;
use JsonSerializable;

class BusinessWorkspaces implements JsonSerializable
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
            ...array_map(fn($workspace) => BusinessWorkspace::of($workspace)->jsonSerialize(), $this->workspaces),
        ];
    }

}
