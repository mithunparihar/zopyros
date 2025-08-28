@extends('admin.layouts.app')
@section('metatitle', \Content::cmsHeading($cm->id) . ' : ' . \Content::ProjectName())
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-datatable table-responsive">
                <div class="card-header">
                    <div class="head-label d-flex justify-content-between">
                        <h5 class="card-title mb-0">{{ \Content::cmsHeading($cm->id) }}</h5>
                        @if(in_array($cm->id,[10,13,14,15,16,17,18]))
                        <x-admin.button.back />
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @livewire('admin.cms.edit', ['data' => $cm->id])
    </div>
@endsection

@push('js')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
    <script src="{{ asset('admin/js/editor.js') }}"></script>
@endpush
