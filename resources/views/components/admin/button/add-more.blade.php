<a {{ $attributes->merge() }} class="btn rounded-pill {{ $attributes['button'] ?? 'btn-dark' }}  btn-sm btn-md">
    <i class="{{ $attributes['icon'] ?? 'fas fa-plus' }} me-1"></i> {!! $slot !!}</a>
