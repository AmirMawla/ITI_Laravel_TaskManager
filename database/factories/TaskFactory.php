<?php

namespace Database\Factories;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Task>
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
            'title' => fake()->sentence(),
            'description' => fake()->paragraph(),
            'completed' => fake()->boolean(),
            'due_date' => fake()->dateTimeBetween('now', '+1 year'),
            'priority' => fake()->randomElement(['Low', 'Medium', 'High']),
            'status' => fake()->randomElement(['To Do', 'In Progress', 'Completed']),
            'creator_id' => User::inRandomOrder()->first()?->id,
            'assigned_id' => User::inRandomOrder()->first()?->id,
            'color' => fake()->hexColor(),
        ];
    }
}
