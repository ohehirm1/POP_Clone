<?php

namespace Database\Factories;

use App\Enums\AuthRole;
use App\Enums\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Participant>
 */
class ParticipantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->safeEmail(),
            'email1' => fake()->randomElement([null, fake()->safeEmail()]),
            'email2' => fake()->randomElement([null, fake()->safeEmail()]),
            'ndis' => fake()->numerify('#########'),
            'auth_role' => fake()->randomElement(array_keys(AuthRole::cases())),
            'verified_at' => null,
            'created_by' => fake()->randomElement(User::whereRole(Role::Provider)->get()->pluck('id')),
        ];
    }

    public function verified()
    {
        return $this->state(function (array $attributes) {
            return [
                'verified_at' => now(),
            ];
        });
    }
}
