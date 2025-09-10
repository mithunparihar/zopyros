@extends('layouts.app')
@section('content')
<main>
    <section class="pt-4">
        <div class="container">
            <x-breadcrumb :lists="$breadcrumb = ['Search ' . (request('q') ?? '') => url()->current(),]" />
            @if (!empty(request('q')))
                <h1 class="Heading h2 mb-4">Search "{{ request('q') ?? '' }}"</h1>
            @endif
            <div class="row row-gap-4">
                @if ($categories->isNotEmpty())
                <div class="col-lg-3">
                    <div class="position-sticky top-0">
                        <h2 class="text-u fs-4 border-bottom border-light border-opacity-10 py-3 mb-4">Categories</h2>
                        <ul class="p-0 m-0 d-flex flex-column row-gap-2 small">
                        @foreach ($categories as $categor)
                            <li><a href="{{ route('category', ['category' => $categor->fullURL()]) }}" class="fw-normal">{{ $categor->title }}</a></li>
                        @endforeach
                        </ul>
                    </div>
                </div>
                @endif
                <div class="{{ $categories->isNotEmpty() ? 'col-lg-9' : 'col-12' }}">
                    <div class="row row-gap-4">
                    @if ($products->isNotEmpty())
                        @foreach ($products as $product)
                        <div class="ProList-item col-lg-4 col-sm-6">
                            @livewire('product-box', ['product' => $product], key('PRD-' . $product->id))
                        </div>
                        @endforeach
                        <div class="pagination d-flex justify-content-center">{{ $products->onEachSide(0)->withQueryString()->links() }}</div>
                    @else
                        <div class="col-12 border-top border-bottom py-3 text-center"><p class="mb-0">We couldn't find any results matching your request.</p></div>
                    @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection
@push('css')
<x-meta :options="[
    'imgpath' => '',
    'img' => '',
    'title' => 'Search : ' . \Content::ProjectName(),
    'keywords' => '',
    'description' => '',
    'breadcrumb' => $breadcrumb ?? '',
]" />
@endpush