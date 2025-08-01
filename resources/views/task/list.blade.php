<div class="d-flex flex-column gap-3">
    @forelse($tasks as $task)
        <div class="card">
            <div class="card-header d-flex align-items-center">
                <div class="me-2">
                    {{ $task->status->html() }}
                </div>
                <h6 class="mb-0 fw-bold">{{ $task->title }}</h6>
                <div class="ms-auto small">
                    <select name="status" class="form-select update-status" data-task-id="{{ $task->id }}">
                        @foreach($statusOptions as $value => $label)
                            <option value="{{ $value }}" @selected($value == $task->status->value)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="card-body">
                {{ $task->description ?? 'No description provided.' }}

                <div class="d-flex justify-content-between">
                    <div class="text-muted small mt-2">
                        Created: {{ $task->created_at->diffForHumans() }}
                    </div>
                    <div class="text-muted small mt-2">
                        Updated: {{ $task->updated_at->diffForHumans() }}
                    </div>
                    <div class="text-muted small mt-2">
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
    @empty
        <div class="text-center py-4">
            No tasks available.
        </div>
    @endforelse
</div>
