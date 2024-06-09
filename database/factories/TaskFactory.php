<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->text(24),
            'description' => $this->faker->text(135),
            'start_date' => $this->faker->dateTimeBetween('-1 days', 'now')->format('Y-m-d\TH:i'),
            'end_date' => $this->faker->dateTimeBetween('+1 days', '+3 days')->format('Y-m-d\TH:i'),
            'status' => $this->faker->randomElement(['todo', 'done', 'failed']),
        ];
    }
}
