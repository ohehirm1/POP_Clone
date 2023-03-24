<?php

namespace Database\Factories;

use App\Enums\Role;
use App\Models\Business;
use App\Models\Participant;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Allocation>
 */
class AllocationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'business_id' => fake()->randomElement(Business::where('verified_at', '<>', null)->get()->pluck('id')),
            'participant_id' => fake()->randomElement(Participant::where('verified_at', '<>', null)->get()->pluck('id')),
            'support_item' => fake()->numerify('03_##_##_#_#'),
            'start_date' => now()->subDays(5)->format('Y-m-d'),
            'end_date' => now()->format('Y-m-d'),
            'price_charged' => fake()->numerify('##.##'),
            'allocated_amount' => fake()->numerify('###.##'),
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

    public function participant_verified()
    {
        return $this->state(function (array $attributes) {
            return [
                'participant_verified_at' => now(),
            ];
        });
    }
}
