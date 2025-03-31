<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Company>
 */
class CompanyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $model = \App\Models\Company::class;

        return [
            'name' => fake()->company(),
            'email' => fake()->unique()->safeEmail(),
            'username' => fake()->unique()->userName(),
            'notif_incidence' => fake()->boolean(),
            'password' => fake()->password(),
            'subscription_id' => 0,
            'token_access' => fake()->uuid(),
            'remember_token' => fake()->uuid(),
            'created_at' => now(),
            'updated_at' => now()
        ];
    }
}
