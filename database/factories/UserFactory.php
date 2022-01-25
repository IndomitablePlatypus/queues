<?php

namespace Database\Factories;

use Codderz\Platypus\Infrastructure\Support\GuidBasedImmutableId;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    public string $password = 'password';
    public string $passwordHash = '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi';

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id' => GuidBasedImmutableId::makeValue(),
            'username' => $this->faker->unique()->userName(),
            'password' => $this->passwordHash,
            'name' => $this->faker->name(),
        ];
    }

}
