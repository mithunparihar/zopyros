@extends('admin.layouts.app')
@section('metatitle', 'Project Edit : ' . \Content::ProjectName())
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-datatable table-responsive">
                <div class="card-header">
                    <div class="head-label d-flex justify-content-between">
                        <h5 class="card-title mb-0">Project Edit</h5>
                        <x-admin.button.back />
                    </div>
                </div>
            </div>
        </div>
        @livewire('admin.project.update-form',['data'=>$project->id])
    </div>
@endsection
@push('css')
<link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/select2/select2.css') }}" />
@endpush
@push('js')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
    <script src="{{ asset('admin/assets/vendor/libs/select2/select2.js') }}"></script>
    <script src="{{ asset('admin/assets/js/forms-selects.js') }}"></script>
    <script src="{{ asset('admin/js/editor.js') }}"></script>
@endpush

