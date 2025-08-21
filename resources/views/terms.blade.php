@extends('layouts.app')
@section('content')
    <main>
        <section class="pt-4">
            <div class="container">
                <x-breadcrumb :lists="[
                    'Terms & Conditions' => url()->current(),
                ]" />
                <h1 class="Heading h2">{{ \Content::cmsData(11)->title }}</h1>
                <div class="CmsPage mt-4">
                    {!! \Content::cmsData(11)->description !!}
                </div>
            </div>
        </section>
    </main>
@endsection
@push('css')
@endpush
