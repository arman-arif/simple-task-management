<div class="form-group mb-3">
    <label for="{{ $id ?? $name }}" class="form-label">{{ __($label) }}</label>
    <select class="form-select" id="{{ $id ?? $name }}" name="{{ $name }}" @required(!empty($required))>
        {{ $slot }}
    </select>
</div>
