<div class="breadcrumb mb-4">
    <a class="breadcrumb-item" href="{{ route('home') }}" aria-label="Home"></a>
    @foreach ($lists as $key => $list)
        /<a @if (!$loop->last) href="{{ $list }}" @endif
            class="breadcrumb-item">{{ $key }}</a>
    @endforeach

</div>
