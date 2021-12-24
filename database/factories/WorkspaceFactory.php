<?php

namespace Database\Factories;

use Codderz\Platypus\Infrastructure\Support\GuidBasedImmutableId;
use Illuminate\Database\Eloquent\Factories\Factory;

class WorkspaceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'workspace_id' => GuidBasedImmutableId::makeValue(),
            'keeper_id' => GuidBasedImmutableId::makeValue(),
            'profile' => [
                'name' => $this->faker->company(),
                'description' => $this->faker->text(),
                'address' => $this->faker->address(),
            ],
        ];
    }
}
