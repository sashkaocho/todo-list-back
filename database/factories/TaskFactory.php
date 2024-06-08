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
            'name' => $this->faker->word(),
            'description' => $this->faker->text(),
            'start_date' => $this->faker->dateTimeBetween('-1 days', 'now'),
            'end_date' => $this->faker->dateTimeBetween('+1 days', '+3 days'),
            'status' => $this->faker->randomElement(['todo', 'done', 'failed']),
        ];
    }
}
