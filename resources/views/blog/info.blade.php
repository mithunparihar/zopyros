@extends('layouts.app')
@section('content')
    <main>
        <section class="pt-4">
            <div class="container">
                <x-breadcrumb :lists="$breadcrumb = [
                    'Blog' => route('blog'),
                    $blog->name => url()->current(),
                ]" />
                <h1 class="Heading h2 mb-4">{{ $blog->name }}</h1>
                <div class="row mt-3">
                    <div class="col-lg-9 col-md-8">
                        <div class="DetailTop mb-4">
                            <x-image-preview fetchpriority="low" loading="lazy" class="border border-dark"
                                imagepath="blog/banner" width="690" height="500" :image="$blog->banner ?? ''" />
                        </div>
                        <div class="sharebox notbg align-items-cneter mb-4 border-top border-bottom border-dark py-2">
                            <div class="row justify-content-between align-items-center">
                                <div class="col-auto"><span
                                        class="d-block text-u text-secondary">{{ \CommanFunction::dateformat($blog->post_date) }}</span>
                                </div>
                                <div class="col-auto text-end">
                                    <div id="social-links">
                                        {!! Share::page($blog->slug, $blog->name)->facebook()->twitter()->linkedin()->whatsapp()->reddit() !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="CmsPage mt-3">
                            {!! $blog->description !!}
                            @if ($tableofcontents->isNotEmpty($tableofcontents))
                                @foreach ($tableofcontents as $tableofconten)
                                    <div id="tableofconten{{ $tableofconten->id }}">
                                        <h{{ $tableofconten->heading_type }}>
                                            {{ $tableofconten->title }}
                                            </h{{ $tableofconten->heading_type }}>
                                            {!! $tableofconten->description !!}
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        <div class="sharebox notbg align-items-cneter mt-4 border-top border-dark py-2">
                            <div class="row justify-content-between align-items-center">
                                <div class="col-auto"><span
                                        class="d-block text-u text-secondary">{{ \CommanFunction::dateformat($blog->post_date) }}</span>
                                </div>
                                <div class="col-auto text-end">
                                    <div id="social-links">
                                        {!! Share::page($blog->slug, $blog->name)->facebook()->twitter()->linkedin()->whatsapp()->reddit() !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="border-top border-bottom border-dark py-3 PreNext">
                            <div class="row justify-content-between">
                                <div class="col">
                                    @if ($previous)
                                        <a href="{{ route('blog', ['alias' => $previous->slug]) }}"
                                            class="d-inline-flex gap-2 align-items-center">
                                            <i class="fal fa-angle-left"></i>
                                            <span>
                                                <h2 class="h5 m-0 fw-bold">{{ $previous->name ?? '' }}</h2>
                                                <small
                                                    class="d-block text-u text-secondary">{{ \CommanFunction::dateformat($previous->post_date ?? '') }}</small>
                                            </span>
                                        </a>
                                    @endif
                                </div>
                                <div class="col">
                                    @if ($next)
                                        <a href="{{ route('blog', ['alias' => $next->slug]) }}"
                                            class="d-inline-flex gap-2">
                                            <i class="fal fa-angle-right"></i>
                                            <span>
                                                <h2 class="h5 m-0 fw-bold">{{ $next->name ?? '' }}</h2>
                                                <small
                                                    class="d-block text-u text-secondary">{{ \CommanFunction::dateformat($next->post_date ?? '') }}</small>
                                            </span>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 mt-lg-0 rightp">
                        <div class="position-sticky ms-xl-3">
                            @if ($tableofcontents->isNotEmpty($tableofcontents))
                                <div class="mb-4 d-none d-md-block">
                                    <h3 class="thm1">Table Of Content</h3>
                                    <div class="list-group list-group-flush border border-dark">
                                        @foreach ($tableofcontents as $tableofcontent)
                                            <a href="#tableofconten{{ $tableofcontent->id }}" class="list-group-item">
                                                {{ $tableofcontent->title }}</a>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <div class="mb-4 d-none d-md-block">
                                <h3 class="thm1">Categories</h3>
                                <div class="list-group list-group-flush border border-dark">
                                    @foreach ($categories as $categor)
                                        <a href="{{ route('blog.category', ['category' => $categor->slug]) }}"
                                            class="list-group-item"> {{ $categor->title }}</a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
@push('css')
    <x-meta :options="[
        'imgpath' => 'blog/banner',
        'img' => $blog->banner,
        'title' => !empty($blog->meta_title) ? $blog->meta_title : $blog->name,
        'keywords' => !empty($blog->meta_keywords) ? $blog->meta_keywords : $blog->name,
        'description' => !empty($blog->meta_description) ? $blog->meta_description : $blog->name,
        'breadcrumb' => $breadcrumb ?? '',
    ]" />
    <link rel="stylesheet" href="{{ \App\Enums\Url::CSS }}blog.min.css" fetchpriority="high">
    <link rel="preload" as="style" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/11.0.5/swiper-bundle.min.css"
        fetchpriority="high" onload="this.rel='stylesheet'"
        integrity="sha512-rd0qOHVMOcez6pLWPVFIv7EfSdGKLt+eafXh4RO/12Fgr41hDQxfGvoi1Vy55QIVcQEujUE1LQrATCLl2Fs+ag=="
        crossorigin="anonymous" referrerpolicy="no-referrer">
@endpush
@push('js')
    <link rel="preload" as="style" href="https://pro.fontawesome.com/releases/v5.15.4/css/all.css"
        onload="this.rel='stylesheet'" crossorigin="anonymous">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/11.0.5/swiper-bundle.min.js"
        integrity="sha512-Ysw1DcK1P+uYLqprEAzNQJP+J4hTx4t/3X2nbVwszao8wD+9afLjBQYjz7Uk4ADP+Er++mJoScI42ueGtQOzEA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        var BlogBox = new Swiper(".BlogBox", {
            spaceBetween: 20,
            slidesPerView: 1,
            loop: false,
            scrollbar: {
                el: ".swiper-scrollbar",
                hide: false,
                draggable: true
            },
            navigation: {
                nextEl: ".blog-next",
                prevEl: ".blog-prev"
            },
            breakpoints: {
                '280': {
                    slidesPerView: 1.8,
                    spaceBetween: 6
                },
                '350': {
                    slidesPerView: 2,
                    spaceBetween: 8
                },
                '450': {
                    slidesPerView: 2,
                    spaceBetween: 12
                },
                '575': {
                    slidesPerView: 2.5,
                    spaceBetween: 15
                },
                '768': {
                    slidesPerView: 3
                },
                '992': {
                    slidesPerView: 3.5
                },
                '1200': {
                    slidesPerView: 4
                }
            }
        });
    </script>
@endpush
