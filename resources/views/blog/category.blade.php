@extends('layouts.app')
@section('content')
    <main>
        <section class="pt-4">
            <div class="container">
                <x-breadcrumb :lists="$breadcrumb = [
                    'Blog' => route('blog'),
                    $lists->title => url()->current()
                ]" />
                <h1 class="Heading h2">{{ \Content::cmsData(13)->title }}</h1>
                <div class="row mt-4 row-gap-4">
                    @foreach ($blogs as $blog)
                        <div class="col-xl-3 col-md-4 col-sm-6">
                            @livewire('blog-box', ['blog' => $blog], key('BLG-' . $blog->id))
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
        'title' => $lists->meta_title ?? $lists->title,
        'keywords' => '',
        'description' => '',
        'breadcrumb' => $breadcrumb ?? '',
    ]" />
@endpush
