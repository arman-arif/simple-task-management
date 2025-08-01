<x-task-container :title="__('Kanban Board')" :all-task-status="$allTaskStatus" kanban="true" >
    <div class="d-flex mb-4">
        <h2>Kanban Board</h2>
        <div class="ms-auto">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTaskModal">
                <i class="bi bi-plus-circle"></i>
                {{ __('Add Task') }}
            </button>
        </div>
    </div>
    <div class="d-md-flex gap-3 justify-content-center">
        @foreach($allTaskStatus as $statusValue => $taskStatus)
            <div class="col-md-4 mb-4">
                <div class="card kanban-board">
                    <div class="card-header d-flex align-items-center">
                        <h5 class="card-title mb-0">
                            {{ $taskStatus }}
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex flex-column justify-content-center gap-3 kanan-card-container" style="min-height: 200px"
                             id="{{ Str::slug($taskStatus) }}-card-container" data-task-status="{{ Str::slug($taskStatus) }}">
                            @include('task.kanban-list', [
                                'tasks' => $tasks->where('status', $statusValue),
                                'statusOptions' => $allTaskStatus,
                            ])
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <x-slot:push-head>
        @vite(['resources/js/kanban.js'])
    </x-slot:push-head>
</x-task-container>

