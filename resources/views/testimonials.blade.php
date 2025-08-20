@extends('layouts.app')
@section('content')
    <main>
        <section class="pt-4">
            <div class="container">
                <x-breadcrumb :lists="[
                    'Testimonials' => url()->current(),
                ]" />
                <h1 class="Heading h2 mb-4">{{ \Content::cmsData(10)->title }}</h1>
                <p>{!! \Content::cmsData(10)->short_description !!}</p>
                <div class="TestSec pt-4">
                    <div class="row TestiMonial row-gap-4">
                        @foreach ($testimonials as $testimonial)
                            <div class="col-lg-6">
                                <div class="TestiBox border border-dark p-3 h-100">
                                    <div class="imgbx">
                                        <div class="img">
                                            <x-image-preview fetchpriority="low" loading="lazy" class="defaultimg"
                                                imagepath="testimonial" width="300" height="300" :image="$testimonial->image ?? ''" />
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
                            </div>
                        @endforeach
                    </div>
                    {{ $testimonials->links() }}
                </div>
            </div>
        </section>
    </main>
@endsection
@push('css')
    <link rel="stylesheet" href="{{ \App\Enums\Url::CSS }}index.min.css" fetchpriority="high">
@endpush
