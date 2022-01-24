<?php

namespace Queues\Api\V1\Presentation\Http\Responses;

use App\Models\Plan;
use JsonSerializable;

class BusinessPlan implements JsonSerializable
{
    public function __construct(protected Plan $plan)
    {
    }

    public static function of(Plan $plan): static
    {
        return new static($plan);
    }

    public function jsonSerialize(): array
    {
        return [
            'planId' => $this->plan->plan_id,
            'workspaceId' => $this->plan->workspace_id,
            'name' => $this->plan->profile['name'],
            'description' => $this->plan->profile['description'],
            'isLaunched' => $this->plan->launched_at !== null,
            'isStopped' => $this->plan->stopped_at !== null,
            'isArchived' => $this->plan->archived_at !== null,
            'expirationDate' => $this->plan->expiration_date,
            'requirements' => Plan::compactRequirements($this->plan->getRequirements()->all()),
        ];
    }

}
