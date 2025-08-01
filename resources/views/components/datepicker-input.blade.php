<div class="form-group mb-3">
    <label for="{{ $id ?? $name }}" class="form-label">{{ __($label) }}</label>
    <input type="date" class="form-control datepicker" id="{{ $id ?? $name }}" name="{{ $name }}"
           placeholder="{{ __($placeholder ?? $label) }}" @required(!empty($required)) value="{{ $value ?? '' }}">
</div>
