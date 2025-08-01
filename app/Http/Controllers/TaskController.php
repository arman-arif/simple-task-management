<?php

namespace App\Http\Controllers;

use App\Enums\TaskStatus;
use App\Http\Requests\TaskStatusUpdateRequest;
use App\Http\Requests\TaskStoreRequest;
use App\Models\Task;
use App\Services\TaskService;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Gate;

class TaskController extends Controller
{
    public function __construct()
    {
        /*$this->middleware(function ($request, $next) {
            // middleware to check authorization
            return $next($request);
        })->except(['index']);*/
    }

    /**
     * Display a listing of the resource.
     */
    public function index(TaskService $taskService)
    {
        $tasks = $taskService->getTasks(
            request('status'),
            auth()->id()
        );

        return view('task.list', [
            'tasks' => $tasks,
            'statusOptions' => TaskStatus::options(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TaskStoreRequest $request, TaskService $taskService)
    {
        $data = $request->validated();

        $taskService->createTask($data);

        return response([
            'success' => true,
            'message' => __('Task added successfully.'),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        Gate::authorize('view-task', $task);

        return response([
            'success' => true,
            'data' => Arr::except($task->toArray(), ['user_id']),
        ]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(TaskStoreRequest $request, Task $task)
    {
        Gate::authorize('update-task', $task);

        $data = $request->validated();

        $task->update($data);

        return response([
            'success' => true,
            'message' => __('Task updated successfully.'),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        Gate::authorize('delete-task', $task);

        $task->delete();

        return response([
            'success' => true,
            'message' => __('Task deleted successfully.'),
        ]);
    }

    public function updateStatus(TaskStatusUpdateRequest $request, Task $task)
    {
        Gate::authorize('update-task', $task);

        $data = $request->validated();

        $task->update($data);

        return response([
            'success' => true,
            'message' => __('Task status updated successfully.'),
        ]);
    }
}
