@extends('layouts.app')
@section('content')
    <main>
        <section class="pt-4">
            <div class="container">
                <x-breadcrumb :lists="$breadcrumb = [
                    'Projects' => route('projects'),
                    $project->title => url()->current(),
                ]" />
                <h1 class="Heading h2 mb-4">{{ $project->title }}</h1>
                <div class="CmsPage">
                    <div class="col-lg-5 float-md-end position-relative ms-xxl-5 ms-xl-4">
                        <x-image-preview fetchpriority="low" loading="lazy" class="w-100 " imagepath="projects" width="690"
                            height="500" :image="$project->images[0]->image ?? ''" />
                    </div>
                    {!! $project->description !!}
                </div>
            </div>
        </section>

        @if (count($project->images) > 1)
            <section class="grey">
                <div class="container">
                    <h2 class="Heading h2 mb-4">Project Gallery</h2>
                    <div class="row row-gap-4">
                        @foreach ($project->images as $images)
                            <div class="col-lg-3 col-sm-4 col-6">
                                <a href="{{ \Image::showFile('projects', 1000, $images->image) }}" data-fancybox="photo"
                                    class="card photo border border-dark shadow">
                                    <div class="card-body p-0">
                                        <x-image-preview fetchpriority="low" loading="lazy" class="w-100 "
                                            imagepath="projects" width="300" height="300" :image="$images->image ?? ''" />
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

        @if (strlen(strip_tags($project->description_2)) > 0)
            <section>
                <div class="container">
                    <h2 class="Heading h2 mb-4">Project Descriptions</h2>
                    <div class="CmsPage">
                        {!! $project->description_2 !!}
                    </div>
                </div>
            </section>
        @endif
    </main>
@endsection
@push('css')
    <link rel="stylesheet" href="{{ \App\Enums\Url::CSS }}pages.min.css" fetchpriority="high">
    <x-meta :options="[
        'imgpath' => 'projects',
        'img' => $project->images[0]->image,
        'title' => !empty($project->meta_title) ? $project->meta_title : $project->title,
        'keywords' => !empty($project->meta_keywords) ? $project->meta_keywords : $project->title,
        'description' => !empty($project->meta_description) ? $project->meta_description : $project->title,
        'breadcrumb' => $breadcrumb ?? '',
    ]" />
@endpush
@push('js')
    <link rel="preload" as="style" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css"
        fetchpriority="low" onload="this.rel='stylesheet'">
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js" fetchpriority="low"></script>
    <script type="module" async>
        Fancybox.bind('[data-fancybox]', {});
    </script>
@endpush
