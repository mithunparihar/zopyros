@extends('layouts.app')
@section('content')
    <main>
        <section class="pt-4">
            <div class="container">
                <x-breadcrumb :lists="[
                    'Privacy Policy' => url()->current(),
                ]" />
                <h1 class="Heading h2">{{ \Content::cmsData(12)->title }}</h1>
                <div class="CmsPage mt-4">
                    {!! \Content::cmsData(12)->description !!}
                </div>
            </div>
        </section>
    </main>
@endsection
@push('css')
@endpush
