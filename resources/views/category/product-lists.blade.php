@extends('layouts.app')
@section('content')
    @php
        $breadcrumb = ['Categories' => route('categories')];
        foreach ($explode as $key => $expl) {
            $serInfo = \App\Models\Category::whereAlias($expl)->active()->first();
            if ($serInfo) {
                $breadcrumb = array_merge($breadcrumb, [
                    $serInfo->title => route('category', ['category' => $serInfo->fullURL()]),
                ]);
            }
        }
    @endphp
    <main>
        <section class="PagePro pt-4">
            <div class="container">
                <x-breadcrumb :lists="$breadcrumb" />
                <h1 class="Heading h2 mb-4">{{ $category->title }}</h1>
                <p>{{ $category->short_description }}</p>
                <div class="grey TopFilter shadow-sm my-4 px-2">
                    @livewire('filter', ['category' => $category])
                </div>
                {{-- <div class="SearchS py-2">
                    <div class="d-flex SearchL gap-3">
                        <input type="search" name="hsearch" class="form-control SearchBox" auto
                            placeholder="Please Enter Product Name">
                    </div>
                    <div class="d-flex gap-2"> </div>
                </div> --}}
                <div class="row mt-4 mb-5 row-gap-4" id="items-list">
                    {{-- items Lists Here --}}
                </div>
                <div class="CmsPage">{!! $category->description !!}</div>

                @if ($faqs->isNotEmpty())
                    <div class="FAQsD mt-4">
                        <h2 class="">{{ $category->title }} FAQs</h2>
                        @foreach ($faqs as $faq)
                            <details name="accordion" {{$loop->index==0?'open':''}}>
                                <summary>{{$faq->title}}</summary>
                                <div class="text">
                                    {!! $faq->description !!}
                                </div>
                            </details>
                        @endforeach
                    </div>
                @endif
            </div>
        </section>
    </main>
@endsection
@push('css')
    <x-meta :options="[
        'imgpath' => 'categoires',
        'img' => $category->image,
        'title' => $category->meta_title ?? $category->title,
        'keywords' => $category->meta_keywords ?? $category->title,
        'description' => $category->meta_description ?? $category->title,
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
