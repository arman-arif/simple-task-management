@extends('layouts.app')

@push('head')
    @vite(['resources/js/tasks.js'])
@endpush

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <h5 class="card-title mb-0">
                            {{ __('Tasks') }}
                        </h5>
                        <div class="ms-auto">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#addTaskModal">
                                <i class="bi bi-plus-circle"></i>
                                {{ __('Add Task') }}
                            </button>
                        </div>
                    </div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <ul class="nav nav-pills gap-2 mb-3" id="task-tab" role="tablist">
                            @foreach($allTaskStatus as $statusValue => $taskStatus)
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link {{ $loop->index == 0 ? "active" : "" }}" id="task-{{Str::slug($taskStatus)}}-tab" data-bs-toggle="pill"
                                            data-bs-target="#task-{{Str::slug($taskStatus)}}" type="button" role="tab" aria-controls="task-{{Str::slug($taskStatus)}}"
                                            data-task-status="{{Str::slug($taskStatus)}}"
                                            aria-selected="{{ $loop->index == 0 ? "true" : "false" }}">{{$taskStatus}}
                                    </button>
                                </li>
                            @endforeach
                        </ul>
                        <div class="tab-content" id="task-tabContent">
                            @foreach($allTaskStatus as $taskStatus)
                                <div class="tab-pane fade {{ $loop->index == 0 ? "show active" : "" }}" id="task-{{Str::slug($taskStatus)}}" role="tabpanel"
                                     aria-labelledby="task-{{Str::slug($taskStatus)}}-tab" tabindex="0">
                                    <div class="text-center py-4">
                                        No tasks available.
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
