<?php

namespace Database\Factories;

use Carbon\Carbon;
use Codderz\Platypus\Infrastructure\Support\GuidBasedImmutableId;
use Illuminate\Database\Eloquent\Factories\Factory;

class InviteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'invite_id' => GuidBasedImmutableId::makeValue(),
            'workspace_id' => GuidBasedImmutableId::makeValue(),
            'proposed_at' => Carbon::now(),
        ];
    }
}
