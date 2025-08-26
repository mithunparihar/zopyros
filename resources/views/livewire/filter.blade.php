<form id="FilterBar" class="offcanvas offcanvas-start" data-bs-scroll="false" id="FilterBar" tabindex="-1">
    <div class="d-flex justify-content-between d-lg-none py-2 mb-2 fw-bold text-u position-sticky top-0 fs-5 z-3"><span
            class="d-flex align-items-center gap-2">Filter <button class="Refresh" title="Refresh"><svg viewBox="0 0 38 29">
                    <polyline points="13 9 5 13 1 5" />
                    <polyline points="25 22 33 18 37 26" />
                    <path d="M5,18a15,19,0,0,0,28,0" />
                    <path d="M33,13A15,19,0,0,0,5,13" />
                </svg></button></span> <button type="button" class="btn-close d-md-none" data-bs-dismiss="offcanvas"
            aria-label="Close"></button>
    </div>
    <div class="offcanvas-body" id="allFilter">
        {{-- <div class="FilterOp">
            <a data-bs-toggle="collapse" class="collapsed" id="Locality" href="#Location" aria-expanded="false"
                aria-controls="Location">Price Range</a>
            <div id="Location" class="collapse" aria-labelledby="Locality" data-bs-parent="#allFilter">
                <div class="ullist">
                    <div class="price-filter">
                        <div class="slider-container">
                            <input type="range" id="minRange" min="0" max="10000" step="100"
                                value="0">
                            <input type="range" id="maxRange" min="0" max="{{ $maxprice }}" step="100"
                                value="{{ $maxprice }}">
                        </div>
                        <div class="range-values">&#8377; <span id="minVal">0</span> – &#8377; <span
                                id="maxVal">{{ $maxprice }}</span></div>
                    </div>
                </div>
            </div>
        </div> --}}
        @foreach ($variants as $variant)
            <div class="FilterOp">
                <a data-bs-toggle="collapse" class="collapsed" id="ProSpaces" href="#variant{{ $variant->id }}"
                    aria-expanded="false" aria-controls="{{ $variant->title }}">{{ $variant->title }}</a>
                <div id="variant{{ $variant->id }}" class="collapse" aria-labelledby="ProSpaces"
                    data-bs-parent="#allFilter">
                    <div class="ullist">
                        @foreach ($variant->childs as $g => $label)
                            <label class="form-check form-check-label lh-normal" onclick="$('#FilterBar').submit();">
                                <span>
                                    <input class="form-check-input border-black border-opacity-50" type="checkbox"
                                        @checked(in_array($label->id, request('variant_type', []))) value="{{ $label->id }}" name="variant_type[]"
                                        id="Gues<?= $g ?>"> {{ $label->title }}
                                </span>
                                <span>{{ $label->productsVariants()->whereHas('productInfo', function ($qwse) use ($category) {
                                        $qwse->whereHas('categories', function ($qert) use ($category) {
                                                $qert->wherecategoryId($category->id);
                                            })->active();
                                    })->distinct('product_id')->count() }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
            </div>
        @endforeach

        <div class="dropdown FilterDrop DropdownS FilterSort">
            <a class="dropdown-toggle d-none d-md-flex" role="button" data-bs-toggle="dropdown" aria-haspopup="true"
                aria-expanded="false" title="Sort By"><i>Sort By</i></a>
            <a href="#SortByDropb" class="dropdown-toggle d-md-none" data-bs-toggle="offcanvas"
                aria-controls="SortByDropb"><svg viewBox="0 0 14 18">
                    <line x1="3" y1="1" x2="3" y2="3" />
                    <line x1="3" y1="9" x2="3" y2="17" />
                    <circle cx="3" cy="6" r="2" />
                    <line x1="11" y1="15" x2="11" y2="17" />
                    <line x1="11" y1="9" x2="11" y2="1" />
                    <circle cx="11" cy="12" r="2" />
                </svg> Sort By</a>
            <div class="offcanvas offcanvas-bottom dropdown-menu Sort p-1 py-2" id="SortByDropb">
                <div class="ullist">
                    <label for="sort1" onclick="$('#FilterBar').submit();">
                        <input class="form-check-input border-black border-opacity-50" type="radio"
                            @checked(request('sort') == 'a-z') value="a-z" name="sort" id="sort1">
                        A to Z
                    </label>

                    <label for="sort2" onclick="$('#FilterBar').submit();">
                        <input class="form-check-input border-black border-opacity-50" type="radio"
                            @checked(request('sort') == 'z-a') value="z-a" name="sort" id="sort2">
                        Z to A
                    </label>

                    <label for="sort3" onclick="$('#FilterBar').submit();">
                        <input class="form-check-input border-black border-opacity-50" type="radio"
                            @checked(request('sort') == 'newest') value="newest" name="sort" id="sort3">
                        Newest First
                    </label>
                </div>
            </div>
        </div>

    </div>
</form>

@push('js')
    <script>
        const filterURL = "{{ url()->current() }}";
    </script>
    <script src="{{ asset('frontend/js/filter.js') }}"></script>
@endpush
