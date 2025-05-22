<?php

namespace Database\Factories;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employer>
 */
class EmployerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    public function definition(): array
    {
        return [
            'user_id' => $this->faker->numberBetween(1, 10),
            'company_name' => $this->faker->company(),
            'description' => $this->faker->paragraph(),
            'industry' => $this->faker->randomElement(['Software', 'Finance', 'Retail']),
            'logo_url' => $this->faker->imageUrl(),
            'verified' => $this->faker->boolean(),
            'company_size' => $this->faker->randomElement(['1-10', '10-50', '50-100']),
            'established_date' => $this->faker->date(),
        ];
    }
}
