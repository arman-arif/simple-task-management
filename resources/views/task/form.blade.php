<div>
    <x-text-input
        label="Task Title*"
        placeholder="Task Title"
        name="title"
        id="{{$prefix??''}}task_title"
        type="text"
    />
    <x-text-area-input
        label="Task Description"
        name="description"
        id="{{$prefix??''}}task_description"
        rows="3"
    />
    <x-select-input
        label="Task Status*"
        name="status"
        id="{{$prefix??''}}task_status"
    >
        @foreach($statusOptions as $value => $label)
            <option value="{{ $value }}">{{ $label }}</option>
        @endforeach
    </x-select-input>

    <x-datepicker-input
        label="Due Date*"
        placeholder="Due Date"
        name="due_date"
        id="{{$prefix??''}}task_due_date"
    />

</div>
