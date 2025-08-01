@extends('layouts.app', [
    'title' => $title
])

@push('head')
    @vite(['resources/js/tasks.js'])
    {{ $pushHead ?? '' }}
@endpush

@section('content')
    <div class="container">
        {{ $slot }}
    </div>

    <!-- Add Task Modal -->
    <div class="modal fade" id="addTaskModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addTaskModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="addTaskModalLabel">Add Task</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('task.store') }}" id="formAddTask">
                        @include('task.form', ['task' => null, 'statusOptions' => $allTaskStatus])
                        @isset($kanban)
                            <input type="hidden" name="kanban" value="1"/>
                        @endisset
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" form="formAddTask">Add Task</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Edit Task Modal -->
    <div class="modal fade" id="editTaskModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editTaskModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="editTaskModalLabel">Edit Task</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="#" id="formUpdateTask">
                        @include('task.form', ['task' => null, 'statusOptions' => $allTaskStatus, 'prefix' => 'edit_'])
                        @isset($kanban)
                            <input type="hidden" name="kanban" value="1"/>
                        @endisset
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" form="formUpdateTask">Update Task</button>
                </div>
            </div>
        </div>
    </div>
@endsection
