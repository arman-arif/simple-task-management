<div class="card {{ empty($kanban) ? '' : 'kanban-card' }}" data-task-id="{{ $task->id }}">
    <div class="card-header d-flex align-items-center">
        {{ $before_title ?? '' }}
        <h6 class="mb-0 fw-bold">{{ $task->title }}</h6>
        {{ $after_title ?? '' }}
    </div>
    <div class="card-body">
        <div class="task-content">
            {{ $task->description ?? 'No description provided.' }}

            <div class="d-flex justify-content-between {{ empty($kanban) ? 'flex-row' : 'flex-column' }} mt-3">
                <div class="text-muted small">
                    Created: {{ $task->created_at->diffForHumans() }}
                </div>
                <div class="text-muted small">
                    Updated: {{ $task->updated_at->diffForHumans() }}
                </div>
                <div class="text-muted small">
                    Due on: {{ $task->due_date->format('D, d M Y') }}
                </div>
            </div>

            <div class="mt-3">
                <button type="button" class="btn btn-sm btn-secondary edit-task" data-task-id="{{ $task->id }}">
                    <i class="bi bi-pencil"></i> Edit
                </button>
                <button type="button" class="btn btn-sm btn-danger delete-task" data-task-id="{{ $task->id }}">
                    <i class="bi bi-trash"></i> Delete
                </button>
            </div>
        </div>
    </div>
</div>
