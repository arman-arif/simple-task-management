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

    public function getTasks($userId = null, $status = null, $keyword = null, $sort = null)
    {
        return Task::query()
            ->whereUserId($userId)
            ->when($status, function ($query, $status) {
                $query->where('status', $status);
            })
            ->when($keyword, function ($query, $keyword) {
                $query->where(function ($query) use ($keyword) {
                    $query->orWhere('title', 'like', "%{$keyword}%");
                    $query->orWhere('description', 'like', "%{$keyword}%");
                });
            })
            ->when($sort, function ($query, $sort) {
                match ($sort) {
                    'oldest' => $query->oldest(),
                    default => $query->latest(),
                };
            })
            ->get();
    }

    public function createTask(array $data, $userId = null): Task
    {
        $data['user_id'] = $userId ?? auth()->id();

        return Task::create($data);
    }
}
