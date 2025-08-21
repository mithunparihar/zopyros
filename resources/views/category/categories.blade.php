@extends('layouts.app')
@section('content')
    <main>
        <section class="pt-4">
            <div class="container">
                <x-breadcrumb :lists="$breadcrumb = [
                    'Categories' => url()->current(),
                ]" />
                <h1 class="Heading h2">{{ \Content::cmsData(16)->title }}</h1>
                <div class="row mt-4 row-gap-4">
                    @foreach ($categories as $categor)
                        <div class="col-lg-4 col-md-6">
                            @livewire('category-box', ['category' => $categor], key('CAT-' . $categor->id))
                        </div>
                    @endforeach
                </div>
                <div class="CmsPage">{!! \Content::cmsData(16)->description !!}</div>
            </div>
        </section>
    </main>
@endsection
@push('css')
    <x-meta :options="[
        'imgpath' => '',
        'img' => '',
        'title' => \Content::meta(6)->title ?? '',
        'keywords' => \Content::meta(6)->title ?? '',
        'description' => \Content::meta(6)->title ?? '',
        'breadcrumb' => $breadcrumb ?? '',
    ]" />
@endpush
