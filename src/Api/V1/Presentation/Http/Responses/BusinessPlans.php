<?php

namespace Queues\Api\V1\Presentation\Http\Responses;

use App\Models\Plan;
use JsonSerializable;

class BusinessPlans implements JsonSerializable
{
    /** @var Plan[] */
    protected array $plans;

    public function __construct(array $plans)
    {
        $this->plans = $plans;
    }

    public static function of(Plan ...$plans): static
    {
        return new static($plans);
    }

    public function jsonSerialize(): array
    {
        return [
            ...array_map(fn($plan) => BusinessPlan::of($plan)->jsonSerialize(), $this->plans),
        ];
    }

}
