<?php

namespace App\Http\Controllers;

use App\Enums\TaskStatus;
use App\Services\TaskService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('home', [
            'allTaskStatus' => TaskStatus::options(),
        ]);
    }

    public function kanban(TaskService $taskService)
    {
        return view('kanban', [
            'allTaskStatus' => TaskStatus::options(),
            'tasks' => $taskService->getTasks(auth()->id()),
        ]);
    }
}
