<?php

namespace App\Services;

use App\Models\Task;

class TaskService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function getTasks($status = null, $userId = null)
    {
        {
            return Task::query()
                ->whereUserId($userId)
                ->when($status, function ($query, $status) {
                    $query->where('status', $status);
                })
                ->latest()
                ->get();

        }
    }

    public function createTask(array $data, $userId = null): Task
    {
        $data['user_id'] = $userId ?? auth()->id();

        return Task::create($data);
    }
}
