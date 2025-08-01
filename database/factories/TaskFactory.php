<?php

namespace Database\Factories;

use App\Enums\TaskStatus;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    protected $model = Task::class;

    public function definition(): array
    {
        $user = User::firstOr(function () {
            return User::factory()->create();
        });

        return [
            'user_id' => $user->id,
            'title' => fake()->words(4, true),
            'description' => fake()->sentence(),
            'status' => TaskStatus::Pending,
            'due_date' => fake()->dateTimeBetween('today', '+1 week'),
        ];
    }
}
