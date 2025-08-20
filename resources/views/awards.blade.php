@extends('layouts.app')
@section('content')
    <main>
        <section class="pt-4">
            <div class="container">
                <x-breadcrumb :lists="[
                    'Awards and Recognitions' => url()->current()
                ]"/>
                <h1 class="Heading h2 mb-4">Awards and Recognitions</h1>
                <div class="row row-gap-4">
                    @foreach ($awards as $award)
                        <div class="col-xl-3 col-md-4 col-sm-6">
                            <a href="{{ \Image::showFile('awards', 1000, $award->image) }}" data-fancybox="photo"
                                class="card photo border border-dark shadow swiper-slide">
                                <div class="card-body p-0">
                                    <x-image-preview fetchpriority="low" loading="lazy" class="defaultimg" imagepath="awards"
                                        width="300" height="300" :image="$award->image" />
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    </main>
@endsection
@push('css')
    <link rel="stylesheet" href="{{ \App\Enums\Url::CSS }}pages.min.css" fetchpriority="high">
@endpush
@push('js')
    <link rel="preload" as="style" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css"
        fetchpriority="low" onload="this.rel='stylesheet'">
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js" fetchpriority="low"></script>
    <script type="module" async>
        Fancybox.bind('[data-fancybox]', {});
    </script>
@endpush
