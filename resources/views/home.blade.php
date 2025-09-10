@extends('layouts.app')
@section('content')
    <main>
        @if ($sliders->isNotEmpty())
            <div class="Slider mt-3">
                <div id="HomeBanner" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000"
                    data-bs-pause="false">
                    <span class="TextBg"><span>ZOPYROS Collection</span></span>
                    <div class="carousel-inner">
                        @foreach ($sliders as $slider)
                            <div class="carousel-item {{ $loop->index == 0 ? 'active' : '' }}">
                                <div class="img">
                                    <x-image-preview id="blah2" fetchpriority="{{ $loop->index == 0 ? 'high' : 'low' }}"
                                        loading="{{ $loop->index == 0 ? 'eager' : 'lazy' }}" class="defaultimg" alt="{{$slider->image}}"
                                        imagepath="banner" width="1000" height="800" :image="$slider->image" />
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @if (count($sliders) > 1)
                        <button class="carousel-control-prev" type="button" data-bs-target="#HomeBanner"
                            data-bs-slide="prev" aria-label="Prev"><span class="carousel-control-prev-icon"
                                aria-hidden="true"></span></button>
                        <button class="carousel-control-next" type="button" data-bs-target="#HomeBanner"
                            data-bs-slide="next" aria-label="Next"><span class="carousel-control-next-icon"
                                aria-hidden="true"></span></button>
                    @endif
                </div>
            </div>
        @endif
        <section class="Home">
            <div class="container row justify-content-center">
                <div class="col-xl-10 text-center">
                    @if (!empty(\Content::cmsData(1)->heading))
                        <span class="SubTitle">{{ \Content::cmsData(1)->heading }}</span>
                    @endif
                    <h1 class="Heading h1 mb-5">{{ \Content::cmsData(1)->title }}</h1>
                    {!! \Content::cmsData(1)->description !!}
                    <a href="{{ route('about') }}" class="btn btn-o-thm1">Discover About</a>
                </div>
            </div>
        </section>

        @if ($categories->isNotEmpty())
            <section class="SecCat Home">
                <img loading="lazy" fetchpriority="low" src="{{ \App\Enums\Url::IMG }}bgsvg.svg" alt="bgsvg"
                    width="1600" height="800" class="bgimg opacity-10">
                <div class="container row row-gap-3 justify-content-between">
                    <div class="col-auto">
                        @if (!empty(\Content::cmsData(2)->heading))
                            <span class="SubTitle">{{ \Content::cmsData(2)->heading }}</span>
                        @endif
                        <h2 class="Heading h1">{{ \Content::cmsData(2)->title }}</h2>
                    </div>
                    <div class="col-auto d-flex gap-2 align-items-end">
                        <div class="swiper-button d-md-flex d-none h-auto">
                            <div class="swiper-button-prev cat-prev"></div>
                            <div class="swiper-button-next cat-next"></div>
                        </div>
                    </div>
                </div>
                <div class="ProCat EndTuch swiper my-lg-5 my-4">
                    <div class="swiper-wrapper">
                        @foreach ($categories as $category)
                            @livewire('category-box', ['category' => $category, 'class' => 'swiper-slide'], key('CAT-' . $category->id))
                        @endforeach
                    </div>
                </div>
                <div class="text-center">
                    <div class="swiper-button d-flex justify-content-center d-md-none">
                        <div class="swiper-button-prev cat-prevm"></div>
                        <div class="swiper-button-next cat-nextm"></div>
                    </div>
                    <a href="{{ route('categories') }}" class="btn btn-o-thm1 m-lg-0">Explore All Categories</a>
                </div>
            </section>
        @endif

        @if ($products->isNotEmpty())
            <section class="SecProDucts">
                <div class="container">
                    <div class="text-center">
                        @if (!empty(\Content::cmsData(3)->heading))
                            <span class="SubTitle">{{ \Content::cmsData(3)->heading }}</span>
                        @endif
                        <h2 class="Heading h1 mb-5">{{ \Content::cmsData(3)->heading }}</h2>
                        <div class="ProList row row-gap-4">
                            @foreach ($products as $product)
                                <div class="ProList-item col-lg-4 col-sm-6">
                                    @livewire('product-box', ['product' => $product], key('PRD-' . $product->id))
                                </div>
                            @endforeach
                        </div>
                        <a href="{{ route('shop') }}" class="btn btn-o-thm1">Explore All Products</a>
                    </div>
                </div>
            </section>
        @endif

        @if ($counters->isNotEmpty())
            <section class="SecCounter">
                <div class="container row row-gap-5 justify-content-between">
                    @foreach ($counters as $counter)
                        <div class="col-md-auto col-6 text-center">
                            <h3 class="fw-semibold"><span class="counter-value lh-1"
                                    data-count="{{ $counter->counter }}">0</span>+</h3>
                            <h4 class="fw-normal font1 thm1">{{ $counter->title }}</h4>
                        </div>
                    @endforeach
                </div>
            </section>
        @endif

        @if (!empty($videoBanner))
            <section class="SecVideo p-0">
                <div class="Video StartTuch">
                    <div class="VideoImg">
                        @php
                            $explode = explode('.', $videoBanner->image);
                            $ext = end($explode);
                        @endphp
                        @if (in_array($ext, ['mp4', 'webp']))
                            <video autoplay muted loop playsinline preload="metadata"
                                src="{{ \Image::showFile('banner', 0, $videoBanner->image) }}" loading="lazy"
                                id="myVideo">
                            </video>
                        @else
                            <x-image-preview fetchpriority="low" loading="lazy" class="defaultimg" imagepath="banner" alt="{{$videoBanner->image}}"
                                width="1600" height="500" :image="$videoBanner->image" />
                        @endif

                    </div>
                </div>
            </section>
        @endif

        @if ($blogs->isNotEmpty())
            <section>
                <div class="container row row-gap-3 justify-content-between">
                    <div class="col-auto">
                        @if (!empty(\Content::cmsData(4)->heading))
                            <span class="SubTitle">{{ \Content::cmsData(4)->heading }}</span>
                        @endif
                        <h2 class="Heading h1">{{ \Content::cmsData(4)->title }}</h2>
                    </div>
                    <div class="col-auto d-flex gap-2 align-items-end">
                        <div class="swiper-button d-md-flex d-none h-auto">
                            <div class="swiper-button-prev blog-prev"></div>
                            <div class="swiper-button-next blog-next"></div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="BlogS swiper my-lg-5 my-4">
                            <div class="swiper-wrapper">
                                @foreach ($blogs as $blog)
                                    @livewire('blog-box', ['blog' => $blog, 'class' => 'swiper-slide'], key('BLG-' . $blog->id))
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-center">
                    <div class="swiper-button d-flex justify-content-center d-md-none">
                        <div class="swiper-button-prev blog-prevm"></div>
                        <div class="swiper-button-next blog-nextm"></div>
                    </div>
                    <a href="{{ route('blog') }}" class="btn btn-o-thm1 m-lg-0">Explore All Blog</a>
                </div>
            </section>
        @endif

        @livewire('contact-box')

        @if (!empty($banner))
            <section class="pb-0 SecVideo Home">
                <div class="EndTuch Video">
                    <div class="VideoImg">
                        <x-image-preview fetchpriority="low" loading="lazy" class="defaultimg" imagepath="banner"
                            width="1600" height="900" :image="$banner->image" alt="{{$banner->image}}" />
                    </div>
                    <div class="VideoText StartTuch text-end">
                        <div class="row align-items-center justify-content-end h-100">
                            <div class="col-xxl-7 col-md-9">
                                <span class="SubTitle">{{ $banner->short_description }}</span>
                                <h2 class="Heading h1">{{ $banner->image_alt }}</h2>
                                @if (!empty($banner->url))
                                    <a class="btn btn-thm1" href="{{ $banner->url }}">Discover More</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @endif

        @if ($testimonials->isNotEmpty())
            <section class="overflow-hidden">
                <img loading="lazy" fetchpriority="low" src="{{ \App\Enums\Url::IMG }}bgsvg.svg" alt="bgsvg" width="1600"
                    height="800" class="bgimg opacity-10">
                <div class="container row justify-content-between align-items-center row-gap-4">
                    <div class="col-lg-5 text-lg-start">
                        @if (!empty(\Content::cmsData(6)->heading))
                            <span class="SubTitle">{{ \Content::cmsData(6)->heading }}</span>
                        @endif
                        <h2 class="Heading h1 mb-lg-4">{{ \Content::cmsData(6)->title }}</h2>
                        <a href="{{route('testimonials')}}" class="btn btn-o-thm1 d-none d-lg-inline-flex">View More</a>
                    </div>
                    <div class="col-lg-7">
                        <div class="TestiMonial Testis swiper">
                            <div class="swiper-wrapper">
                                @foreach ($testimonials as $testimonial)
                                    <div class="swiper-slide TestiBox">
                                        <div class="imgbx">
                                            <div class="img">
                                                <x-image-preview fetchpriority="low" loading="lazy" class="defaultimg"
                                                    imagepath="testimonial" width="300" height="300" alt="{{$testimonial->image ?? ''}}"
                                                    :image="$testimonial->image ?? ''" />
                                            </div>
                                        </div>
                                        <div class="text mt-3 text-start">
                                            {!! $testimonial->description !!}
                                            <div class="nametext mt-3">
                                                <h3 class="h5 mb-0 text-u thm1">{{ $testimonial->title }}</h3>
                                                <span class="star fs-5"
                                                    data-title="{{ (int) $testimonial->designation }}"></span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="swiper-pagination"></div>
                        </div>
                        <div class="text-center d-lg-none"><a href="{{route('testimonials')}}" class="btn btn-o-thm1">View More</a></div>
                    </div>
                </div>
            </section>
        @endif

    </main>
@endsection

@push('css')
    <x-meta :options="[
        'imgpath' => '',
        'img' => '',
        'title' => \Content::meta(1)->title ?? '',
        'keywords' => \Content::meta(1)->keywords ?? '',
        'description' => \Content::meta(1)->description ?? '',
        'breadcrumb' => $breadcrumb ?? '',
    ]" />
    <link rel="stylesheet" href="{{ \App\Enums\Url::CSS }}index.min.css" fetchpriority="high">
    <link rel="preload" as="style" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/11.0.5/swiper-bundle.min.css"
        fetchpriority="high" onload="this.rel='stylesheet'"
        integrity="sha512-rd0qOHVMOcez6pLWPVFIv7EfSdGKLt+eafXh4RO/12Fgr41hDQxfGvoi1Vy55QIVcQEujUE1LQrATCLl2Fs+ag=="
        crossorigin="anonymous" referrerpolicy="no-referrer">
@endpush
@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/11.0.5/swiper-bundle.min.js" fetchpriority="low"
        integrity="sha512-Ysw1DcK1P+uYLqprEAzNQJP+J4hTx4t/3X2nbVwszao8wD+9afLjBQYjz7Uk4ADP+Er++mJoScI42ueGtQOzEA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/masonry/4.2.2/masonry.pkgd.min.js" fetchpriority="low"
        integrity="sha512-JRlcvSZAXT8+5SQQAvklXGJuxXTouyq8oIMaYERZQasB8SBDHZaUbeASsJWpk0UUrf89DP3/aefPPrlMR1h1yQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{ \App\Enums\Url::JS }}index.js" fetchpriority="low"></script>
@endpush
