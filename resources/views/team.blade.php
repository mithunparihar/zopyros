@extends('layouts.app')
@section('content')
    <main>
        <section class="pt-4">
            <div class="container">
                <x-breadcrumb :lists="$breadcrumb = [
                    'Our Team' => url()->current(),
                ]" />
                <h1 class="Heading h2 mb-4">{{ \Content::cmsData(15)->title }}</h1>
                <div class="row row-gap-4">
                    @if ($teams->isEmpty())
                        <div class="text-center border-top border-bottom py-4 mb-4">
                            <h2 class="h6 mb-1">Oops! Team Data Not Found</h2>
                            <p class="mb-0">Looks like we’re having trouble loading the team info right now.</p>
                        </div>
                    @endif
                    @foreach ($teams as $team)
                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <div class="card teamBox">
                                <div class="card-header">
                                    <x-image-preview fetchpriority="low" loading="lazy" class="defaultimg" imagepath="team"
                                        width="300" height="300" :image="$team->image ?? ''" />
                                </div>
                                <div class="card-body text-center">
                                    <h3 class="h5 text-u thm1 fw-bold m-0">{{ $team->title }}</h3>
                                    <small class="text-u d-block mt-1">{{ $team->designation }}</small>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    {{ $teams->links() }}
                </div>
                <div class="CmsPage">
                    {!! \Content::cmsData(15)->description !!}
                </div>
        </section>
    </main>
@endsection
@push('css')
    <x-meta :options="[
        'imgpath' => '',
        'img' => '',
        'title' => \Content::meta(9)->title ?? '',
        'keywords' => \Content::meta(9)->keywords ?? '',
        'description' => \Content::meta(9)->description ?? '',
        'breadcrumb' => $breadcrumb ?? '',
    ]" />
    <link rel="stylesheet" href="{{ \App\Enums\Url::CSS }}pages.min.css" fetchpriority="high">
@endpush
