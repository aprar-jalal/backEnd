<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\JobSeeker;

class JobSeekerFactory extends Factory
{
    protected $model = JobSeeker::class;

    public function definition(): array
    {
        return [
            'role_id' => $this->faker->unique()->numberBetween(1, 100),
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'picture' => null,
            'major' => $this->faker->word,
            'background_image' => null,
            'resume' => null,
            'profile_description' => $this->faker->sentence,
            'skills' => json_encode([$this->faker->word, $this->faker->word]),
            'degree' => $this->faker->randomElement(['Bachelor', 'Master', 'PhD']),
            'years_of_experience' => $this->faker->numberBetween(0, 15),
        ];
    }
}
