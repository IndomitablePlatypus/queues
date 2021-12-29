<?php

namespace Database\Factories;

use Carbon\Carbon;
use Codderz\Platypus\Infrastructure\Support\GuidBasedImmutableId;
use Illuminate\Database\Eloquent\Factories\Factory;

class RequirementFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'requirement_id' => GuidBasedImmutableId::makeValue(),
            'plan_id' => GuidBasedImmutableId::makeValue(),
            'description' => $this->faker->text(),
        ];
    }
}
