<div class="d-flex flex-column gap-3">
    @forelse($tasks as $task)
        @component('task.card', [
            'statusOptions' => $statusOptions,
            'task' => $task,
        ])
            @slot('before_title')
                <div class="me-2">
                    {{ $task->status->html() }}
                </div>
            @endslot
            @slot('after_title')
                <div class="ms-auto small">
                    <select name="status" class="form-select update-status" data-task-id="{{ $task->id }}">
                        @foreach($statusOptions as $value => $label)
                            <option value="{{ $value }}" @selected($value == $task->status->value)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
            @endslot
        @endcomponent
    @empty
        <div class="text-center py-4">
            No tasks available.
        </div>
    @endforelse
</div>
