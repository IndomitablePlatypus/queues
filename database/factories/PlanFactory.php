<?php

namespace Database\Factories;

use Carbon\Carbon;
use Codderz\Platypus\Infrastructure\Support\GuidBasedImmutableId;
use Illuminate\Database\Eloquent\Factories\Factory;

class PlanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'plan_id' => GuidBasedImmutableId::makeValue(),
            'workspace_id' => GuidBasedImmutableId::makeValue(),
            'profile' => [
                'name' => $this->faker->sentence(),
                'description' => $this->faker->text(),
            ],
            'launched_at' => null,
            'stopped_at' => null,
            'archived_at' => null,
            'expiration_date' => null,
        ];
    }
}
