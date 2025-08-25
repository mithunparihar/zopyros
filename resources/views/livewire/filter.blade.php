<div class="offcanvas offcanvas-start" data-bs-scroll="false" id="FilterBar" tabindex="-1">
    <div class="d-flex justify-content-between d-lg-none py-2 mb-2 fw-bold text-u position-sticky top-0 fs-5 z-3"><span
            class="d-flex align-items-center gap-2">Filter <button class="Refresh" title="Refresh"><svg viewBox="0 0 38 29">
                    <polyline points="13 9 5 13 1 5" />
                    <polyline points="25 22 33 18 37 26" />
                    <path d="M5,18a15,19,0,0,0,28,0" />
                    <path d="M33,13A15,19,0,0,0,5,13" />
                </svg></button></span> <button type="button" class="btn-close d-md-none" data-bs-dismiss="offcanvas"
            aria-label="Close"></button></div>
    <div class="offcanvas-body" id="allFilter">
        <div class="FilterOp">
            <a data-bs-toggle="collapse" class="collapsed" id="Locality" href="#Location" aria-expanded="false"
                aria-controls="Location">Price Range</a>
            <div id="Location" class="collapse" aria-labelledby="Locality" data-bs-parent="#allFilter">
                <div class="ullist">
                    <div class="price-filter">
                        <div class="slider-container">
                            <input type="range" id="minRange" min="0" max="10000" step="100"
                                value="0">
                            <input type="range" id="maxRange" min="0" max="{{$maxprice}}" step="100"
                                value="{{$maxprice}}">
                        </div>
                        <div class="range-values">&#8377; <span id="minVal">0</span> – &#8377; <span
                                id="maxVal">{{$maxprice}}</span></div>
                    </div>
                </div>
            </div>
        </div>
        @foreach ($variants as $variant)
            <div class="FilterOp">
                <a data-bs-toggle="collapse" class="collapsed" id="ProSpaces" href="#variant{{ $variant->id }}"
                    aria-expanded="false" aria-controls="{{ $variant->title }}">{{ $variant->title }}</a>
                <div id="variant{{ $variant->id }}" class="collapse" aria-labelledby="ProSpaces"
                    data-bs-parent="#allFilter">
                    <div class="ullist">
                        @foreach ($variant->categories as $g => $label)
                            <label class="form-check form-check-label lh-normal">
                                <span>
                                    <input class="form-check-input border-black border-opacity-50" type="checkbox"
                                        value="" id="Gues<?= $g ?>"> {{ $label->title }}
                                </span>
                                <span>{{ $label->products()->distinct('product_id')->count() }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

@push('js')
    <script>
        const filterURL = "{{ url()->current() }}";
    </script>
    <script src="{{ asset('frontend/js/filter.js') }}"></script>
@endpush
