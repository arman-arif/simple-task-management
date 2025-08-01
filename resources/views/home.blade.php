<x-task-container title="Task List" :allTaskStatus="$allTaskStatus">
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
                    <div class="d-flex flex-wrap flex-sm-nowrap justify-content-center gap-3 pb-4">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Search Task" name="keyword" id="search"/>
                            <button class="btn border" type="button" id="clearButton">
                                <i class="bi bi-x-lg"></i>
                            </button>
                        </div>
                        <div class="input-group" style="width: 300px">
                            <span class="input-group-text">Sort by:</span>
                            <select class="form-select" id="sortBy">
                                <option value="latest" selected>Latest</option>
                                <option value="oldest">Oldest</option>
                            </select>
                        </div>
                    </div>
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
</x-task-container>
