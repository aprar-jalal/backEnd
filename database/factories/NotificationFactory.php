<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Notification>
 */
class NotificationFactory extends Factory
{
    use HasFactory;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $id = 1;
        $from = User::where('user_id',$id);
        return [
            'user_id' => '1' ,
            'message' => $this->faker->paragraph($nbSentences = 1, $variableNbSentences = true),
            'from' => $from->get()->first()->email,
            'isOpened' => $this->faker->boolean(50), // 50% chance it's read
        ];
    }


}
