<label {{ $attributes->merge(['class' => 'form-label']) }}>{!! $slot !!}
    @if ($attributes['asterisk'])
        <small class="text-danger"> * </small>
    @endif
</label>
