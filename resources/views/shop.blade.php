@extends('layouts.app')
@section('content')
    @php
        $breadcrumb = ['Shop' => route('shop')];
    @endphp
    <main>
        <section class="PagePro pt-4">
            <div class="container">
                <x-breadcrumb :lists="$breadcrumb" />
                <h1 class="Heading h2">Our Products</h1>
                <div class="grey TopFilter shadow-sm my-4 px-2">
                    @livewire('filter')
                </div>
                <button class="dropdown-toggle d-lg-none d-flex align-items-center" type="button" data-bs-toggle="offcanvas"
                    data-bs-target="#FilterBar" aria-label="MenuBar"><svg viewBox="0 0 17 17">
                        <polygon points="10 16 10 9 16 1 1 1 7 9 7 14 10 16" />
                    </svg> Filter</button>
                {{-- Item Lists Here --}}
                <div class="row mt-4 mb-5 row-gap-4" id="items-list"></div>
            </div>
        </section>
    </main>
@endsection
@push('css')
    <x-meta :options="[
        'imgpath' => '',
        'img' => '',
        'title' => 'Our Products : ' . \Content::ProjectName(),
        'keywords' => 'Our Products : ' . \Content::ProjectName(),
        'description' => 'Our Products : ' . \Content::ProjectName(),
        'breadcrumb' => $breadcrumb ?? '',
    ]" />
    <link rel="stylesheet" href="{{ \App\Enums\Url::CSS }}shop.min.css" fetchpriority="high">
@endpush
@push('js')
    <script>
        const minSlider = document.getElementById("minRange");
        const maxSlider = document.getElementById("maxRange");
        const minVal = document.getElementById("minVal");
        const maxVal = document.getElementById("maxVal");
        const minGap = 100;
        const maxLimit = parseInt(minSlider.max);

        function updateSlider() {
            let min = parseInt(minSlider.value);
            let max = parseInt(maxSlider.value);
            if (max - min <= minGap) {
                if (event.target === minSlider) {
                    min = max - minGap;
                    minSlider.value = min;
                } else {
                    max = min + minGap;
                    maxSlider.value = max;
                }
            }
            minVal.textContent = min;
            maxVal.textContent = max;
            const minPercent = (min / maxLimit) * 100;
            const maxPercent = (max / maxLimit) * 100;
            const fill =
                `linear-gradient(to right, #ddd ${minPercent}%, light-dark(var(--thm), var(--thm1)) ${minPercent}%, light-dark(var(--thm), var(--thm1)) ${maxPercent}%, #ddd ${maxPercent}%)`;
            minSlider.style.background = fill;
            maxSlider.style.background = fill;
        }
        [minRange, maxRange].forEach(el => el.addEventListener("input", updateSlider));
        updateSlider();
    </script>
@endpush
