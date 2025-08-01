<div class="form-group mb-3">
    <label for="{{ $id ?? $name }}" class="form-label">{{ __($label) }}</label>
    <textarea class="form-control" id="{{ $id ?? $name }}" name="{{ $name }}" rows="3"
              placeholder="{{ __($label ?? $placeholder) }}"  @required(!empty($required))>{{ $value ?? '' }}</textarea>
</div>
