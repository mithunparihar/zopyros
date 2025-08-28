@extends('layouts.app')
@section('content')
    <main>
        <section class="pt-4 Home">
            <div class="container">
                <x-breadcrumb :lists="$breadcrumb = [
                    'About Us' => url()->current(),
                ]" />
                <h1 class="Heading h2 mb-4">{{ \Content::cmsData(7)->title }}</h1>
                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="me-xxl-5 me-xl-4">
                            <x-image-preview fetchpriority="low" class="w-100" loading="lazy" imagepath="cms" width="690"
                                height="500" :image="\Content::cmsData(7)->image" />
                        </div>
                    </div>
                    <div class="col-12 col-md-6 CmsPage">{!! \Content::cmsData(7)->description !!}</div>
                </div>
            </div>
        </section>
        <section>
            <div class="container">
                <h2 class="Heading h2 mb-4">{{ \Content::cmsData(8)->title }}</h2>
                <div class="CmsPage">
                    <div class="col-md-5 col-xl-4 col-xxl-3 float-md-start position-relative me-md-4 mb-4">
                        <x-image-preview fetchpriority="low" class="w-100 rounded-4 shadow" loading="lazy" imagepath="cms"
                            width="450" height="450" :image="\Content::cmsData(8)->image" />
                    </div>
                    {!! \Content::cmsData(8)->description !!}
                </div>
            </div>
        </section>
        <section class="grey">
            <div class="container">
                <h2 class="Heading h2 mb-4">{{ \Content::cmsData(9)->title }}</h2>
                <div class="CmsPage">
                    <div class="col-md-5 col-xl-4 col-xxl-3 float-md-end position-relative ms-md-4 mb-4">
                        <x-image-preview fetchpriority="low" class="w-100 rounded-4 shadow" loading="lazy" imagepath="cms"
                            width="450" height="450" :image="\Content::cmsData(9)->image" />
                    </div>
                    {!! \Content::cmsData(9)->description !!}
                </div>
            </div>
        </section>

        @if ($clients->isNotEmpty())
            <div class="SecLogos py-4 border-bottom border-dark border-opacity-50">
                <div class="container-fluid p-0">
                    <div class="Logos">
                        <div class="swiper-wrapper">
                            @foreach ($clients as $client)
                                <div class="swiper-slide text-center">
                                    <x-image-preview width="200" height="54" imagepath="clients" :image="$client->image" />
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if ($awards->isNotEmpty())
            <section>
                <div class="container row row-gap-md-4 row-gap-3 justify-content-between">
                    <div class="col-md-auto">
                        <h2 class="Heading">Awards and Recognitions</h2>
                    </div>
                    <div class="col-12 order-md-last">
                        <div class="Awards swiper my-4">
                            <div class="swiper-wrapper">
                                @foreach ($awards as $award)
                                    <a href="{{ \Image::showFile('awards', 1000, $award->image) }}" data-fancybox="photo"
                                        class="card photo border border-dark shadow swiper-slide">
                                        <div class="card-body p-0">
                                            <x-image-preview fetchpriority="low" loading="lazy" class="defaultimg"
                                                imagepath="awards" width="300" height="300" :image="$award->image" />
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="col-md-auto d-flex gap-2 align-items-end justify-content-center">
                        <div class="swiper-button d-flex h-auto">
                            <div class="swiper-button-prev Aw-prev"></div>
                            <div class="swiper-button-next Aw-next"></div>
                        </div>
                    </div>
                    <div class="col-12 text-center order-md-last"><a href="{{ route('awards') }}"
                            class="btn btn-o-thm1 m-0">View All
                            Awards</a></div>
                </div>
            </section>
        @endif
    </main>
@endsection
@push('css')
    <x-meta :options="[
        'imgpath' => '',
        'img' => '',
        'title' => \Content::meta(2)->title ?? '',
        'keywords' => \Content::meta(2)->keywords ?? '',
        'description' => \Content::meta(2)->description ?? '',
        'breadcrumb' => $breadcrumb ?? '',
    ]" />
    <link rel="stylesheet" href="{{ \App\Enums\Url::CSS }}pages.min.css" fetchpriority="high">
    <link rel="preload" as="style" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/11.0.5/swiper-bundle.min.css"
        onload="this.rel='stylesheet'" fetchpriority="high"
        integrity="sha512-rd0qOHVMOcez6pLWPVFIv7EfSdGKLt+eafXh4RO/12Fgr41hDQxfGvoi1Vy55QIVcQEujUE1LQrATCLl2Fs+ag=="
        crossorigin="anonymous" referrerpolicy="no-referrer">
@endpush
@push('js')
    <link rel="preload" as="style" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css"
        fetchpriority="low" onload="this.rel='stylesheet'">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/11.0.5/swiper-bundle.min.js"
        integrity="sha512-Ysw1DcK1P+uYLqprEAzNQJP+J4hTx4t/3X2nbVwszao8wD+9afLjBQYjz7Uk4ADP+Er++mJoScI42ueGtQOzEA=="
        fetchpriority="low" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js" fetchpriority="low"></script>
    <script type="module" async>
        Fancybox.bind('[data-fancybox]', {});
        var Clogos = new Swiper(".Logos", {
            slidesPerView: 1.5,
            loop: true,
            speed: 5000,
            spaceBetween: 20,
            autoplay: {
                enabled: true,
                delay: 0,
                disableOnInteraction: false,
                pauseOnMouseEnter: true,
            },
            breakpoints: {
                '350': {
                    slidesPerView: 2
                },
                '420': {
                    slidesPerView: 2.5
                },
                '575': {
                    slidesPerView: 3
                },
                '768': {
                    slidesPerView: 4
                },
                '992': {
                    slidesPerView: 5
                },
                '1200': {
                    slidesPerView: 5
                },
                '1600': {
                    slidesPerView: 6
                }
            }
        });
        const AwardSlider = () => {
            let Awards = document.querySelectorAll('.Awards')
            let prevAw = document.querySelectorAll('.Aw-prev')
            let nextAw = document.querySelectorAll('.Aw-next')
            Awards.forEach((slider, index) => {
                let result = (slider.children[0].children.length > 1) ? true : false
                const swiper = new Swiper(slider, {
                    spaceBetween: 20,
                    slidesPerView: 1,
                    navigation: {
                        nextEl: nextAw[index],
                        prevEl: prevAw[index]
                    },
                    breakpoints: {
                        '280': {
                            slidesPerView: 1.2,
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
                            slidesPerView: 3.5
                        },
                        '992': {
                            slidesPerView: 4
                        }
                    }
                });
            })
        }
        window.addEventListener('load', AwardSlider);
    </script>
@endpush
