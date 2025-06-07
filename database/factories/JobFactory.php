<?php

namespace Database\Factories;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Job>
 */
class JobFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'employer_id' => $this->faker->numberBetween(1, 10),
            'job_title' => $this->faker->jobTitle(),
            'description' => $this->faker->paragraph(),
            'location' => $this->faker->city(),
            'salary' => $this->faker->numberBetween(5000, 20000),
            'job_type' => $this->faker->randomElement(['full-time', 'part-time', 'contract', 'temporary', 'internship']),
            'workplace' => $this->faker->randomElement(['Onsite', 'Remote', 'Hybrid']),
        ];
    }
}
