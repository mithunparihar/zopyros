@extends('layouts.app')
@section('content')
    <main>
        <section class="pt-4">
            <div class="container">
                <x-breadcrumb :lists="$breadcrumb = [
                    'Career' => url()->current(),
                ]" />
                <h1 class="Heading h2">{{ \Content::cmsData(14)->title }}</h1>
                <div class="row row-gap-4 mt-4">
                    @if ($lists->isEmpty())
                        <div class="text-center border-top border-bottom py-4 mb-4">
                            <h2 class="h6 mb-1">No Current Openings</h2>
                            <p class="mb-0">We’re not hiring at the moment, but we’re always interested in great talent.
                                <br> Please check back soon!
                            </p>
                        </div>
                    @endif
                    @foreach ($lists as $list)
                        <div class="col-md-6">
                            <a href="{{ route('career', ['alias' => $list->alias]) }}" class="card CareerBox">
                                <div class="card-header">
                                    <div class="JobTitle">
                                        <h3 class="h5 fw-semibold m-0">{{ $list->title }}</h3>
                                        <small><i>{{ $list->designation }}</i></small>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <p class="small">{{ $list->short_description }}</p>
                                    <ul class="Jobpost">
                                        <li><svg viewBox="0 0 20 25">
                                                <path
                                                    d="M19,9c0,8-9,15-9,15S1,17,1,10A9,9,0,0,1,19,9ZM10,5a5,5,0,1,1-5,5A5,5,0,0,1,10,5Z" />
                                            </svg> <span>{{ $list->location }}</span></li>
                                        <li><svg viewBox="0 0 20 28">
                                                <path
                                                    d="M10,9c12-0,12,18,0,18C-2,27-2,9,10,9ZM5,4V7M15,4V7M10,1V7m2,9a2,2,0,1,0-4,0c0,3,4,1,4,4a2,2,0,1,1-4,0m2-8v1m0,10v1" />
                                            </svg> {{ $list->salary }}</li>
                                        <li>{{ $list->job_type }}</li>
                                    </ul>
                                </div>
                            </a>
                        </div>
                    @endforeach
                    {{ $lists->links() }}
                </div>
                <div class="CmsPage">
                    {!! \Content::cmsData(14)->description !!}
                </div>
            </div>
        </section>
    </main>
@endsection
@push('css')
    <x-meta :options="[
        'imgpath' => '',
        'img' => '',
        'title' => \Content::meta(8)->title ?? '',
        'keywords' => \Content::meta(8)->keywords ?? '',
        'description' => \Content::meta(8)->description ?? '',
        'breadcrumb' => $breadcrumb ?? '',
    ]" />
    <link rel="stylesheet" href="{{ \App\Enums\Url::CSS }}pages.min.css" fetchpriority="high">
@endpush
