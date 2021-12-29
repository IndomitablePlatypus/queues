<?php

namespace Database\Factories;

use Carbon\Carbon;
use Codderz\Platypus\Infrastructure\Support\GuidBasedImmutableId;
use Illuminate\Database\Eloquent\Factories\Factory;

class CardFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'card_id' => GuidBasedImmutableId::makeValue(),
            'plan_id' => GuidBasedImmutableId::makeValue(),
            'customer_id' => GuidBasedImmutableId::makeValue(),
            'description' => $this->faker->text(),
            'issued_at' => Carbon::now(),
            'satisfied_at' => null,
            'completed_at' => null,
            'revoked_at' => null,
            'blocked_at' => null,
            'achievements' => [],
            'requirements' => [],
        ];
    }
}
