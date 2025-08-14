<select {{ $attributes->merge(['class' => 'form-select']) }} >
    <option value="">Choose One</option>
    @if(!empty($attributes['lists']))
        @foreach ($attributes['lists'] ?? [] as $list)
            <option value="{{ $list['id'] }}">{{ $list['title'] }}</option>
        @endforeach
    @endif
</select>