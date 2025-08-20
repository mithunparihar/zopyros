@extends('layouts.app')
@section('content')
    <main>
        <section class="pt-4">
            <div class="container">
                <x-breadcrumb :lists="$breadcrumb = [
                    'Projects' => url()->current(),
                ]" />
                <h1 class="Heading h2">{{ \Content::cmsData(13)->title }}</h1>
                <div class="row mt-4 row-gap-4">
                    @foreach ($projects as $project)
                        <div class="col-xxl-3 col-md-4 col-sm-6">
                            <a href="{{ route('projects', ['alias' => $project->slug]) }}"
                                class="shadow-none card ProBlock ProCatS">
                                <div class="card-header">
                                    <div class="proimg">
                                        <x-image-preview fetchpriority="low" loading="lazy" class="defaultimg"
                                            imagepath="projects" width="500" height="300" :image="$project->images[0]->image ?? ''" />
                                    </div>
                                </div>
                                <div class="card-body">
                                    <h3 class="h5 m-0" title="Project Name">{{ $project->title }}</h3>
                                    <div class="text">{{ $project->short_description }}</div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
                <div class="CmsPage">
                    {!! \Content::cmsData(13)->description !!}
                </div>
            </div>
        </section>
    </main>
@endsection
@push('css')
    <x-meta :options="[
        'imgpath' => '',
        'img' => '',
        'title' => '',
        'keywords' => '',
        'description' => '',
        'breadcrumb' => $breadcrumb ?? '',
    ]" />
@endpush
