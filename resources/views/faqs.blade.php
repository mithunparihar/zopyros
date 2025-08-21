@extends('layouts.app')
@section('content')
    @php
        $breadCrumb = ['FAQs' => route('faqs')];
        $metaTitle = \Content::meta(7)->title;
        $metaKeywords = \Content::meta(7)->keywords;
        $metaDescription = \Content::meta(7)->description;
        if ($category) {
            $breadCrumb = array_merge($breadCrumb, [$category->title => route('faqs')]);
            $metaTitle = $category->meta_title ?? $category->title;
            $metaKeywords = $category->meta_keywords ?? $category->title;
            $metaDescription = $category->meta_description ?? $category->title;
        }
    @endphp
    <main>
        <section class="pt-4">
            <div class="container">
                <x-breadcrumb :lists="$breadCrumb" />
                <div class="row justify-content-between row-gap-3 mb-4 align-items-center">
                    <div class="col-lg-auto">
                        <h1 class="Heading h2">
                            @if ($category)
                                {{ $category->heading }}
                            @else
                                {{ \Content::cmsData(17)->title }}
                            @endif
                        </h1>
                    </div>
                </div>
                <div class="row justify-content-center mt-4">
                    <div class="col-xl-9 col-lg-8 FAQsD">
                        @foreach ($lists as $list)
                            <details name="accordion" {{ $loop->index == 0 ? 'open' : '' }}>
                                <summary>{{ $list->title }}</summary>
                                <div class="text CmsPage">
                                    {!! $list->description !!}
                                </div>
                            </details>
                        @endforeach
                    </div>
                    <div class="col-xl-3 col-lg-4">
                        <div class="card faqcat rounded-0">
                            <div class="card-header">
                                <input type="search" class="form-control SearchBox SearchInput"
                                    placeholder="How can we help?">
                            </div>
                            <div class="card-body list">
                                @foreach ($categories as $catego)
                                    <a href="{{ route('faqs', ['category' => $catego->alias]) }}">{{ $catego->title }}</a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="CmsPage">
                    @if ($category)
                        {!! $category->description !!}
                    @else
                        {!! \Content::cmsData(17)->description !!}
                    @endif
                </div>
            </div>
        </section>
    </main>
@endsection
@push('css')
    <x-meta :options="[
        'imgpath' => '',
        'img' => '',
        'title' => $metaTitle,
        'keywords' => $metaKeywords,
        'description' => $metaDescription,
        'breadcrumb' => $breadcrumb ?? '',
    ]" />
    <link rel="stylesheet" href="{{ \App\Enums\Url::CSS }}pages.min.css" fetchpriority="high">
@endpush
