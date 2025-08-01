<div class="form-group mb-3">
    <label for="{{ $id ?? $name }}" class="form-label">{{ __($label) }}</label>
    <input type="{{ $type ?? 'text' }}" class="form-control" id="{{ $id ?? $name }}" name="{{ $name }}"
           placeholder="{{ __($placeholder ?? $label) }}" @required(!empty($required)) value="{{ $value ?? '' }}">
</div>
