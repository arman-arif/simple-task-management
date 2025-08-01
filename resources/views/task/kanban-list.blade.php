@forelse($tasks  as $task)
    @include('task.card', [
        'statusOptions' => $statusOptions,
        'task' => $task,
        'kanban' => true,
    ])
@empty
    <div class="text-center not-available py-4">
        No tasks available.
    </div>
@endforelse
