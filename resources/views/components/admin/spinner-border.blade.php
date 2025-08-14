<div wire:ignore
    {{ $attributes->merge(['class' => 'initial-loader position-absolute top-0 left-0 h-100 w-100 bg-white bg-opacity-75']) }}
    style="backdrop-filter:blur(5px)">
    <div class="h-100 w-100 d-flex align-items-center justify-content-center">
        <span class="spinner-border"></span>
    </div>
</div>
@push('js')
    <script>
        window.addEventListener('load', function() {
            const boxes = document.querySelectorAll('.initial-loader');
            boxes.forEach(box => {
                box.style.display = 'none';
            });
        });
    </script>
@endpush
