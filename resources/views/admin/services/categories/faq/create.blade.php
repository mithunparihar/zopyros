@extends('admin.layouts.app')
@section('metatitle', 'FAQs Create : ' . \Content::ProjectName())
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-datatable table-responsive">
                <div class="card-header">
                    <div class="head-label d-flex justify-content-between">
                        <h5 class="card-title mb-0">FAQs Create</h5>
                        <x-admin.button.back />
                    </div>
                </div>
            </div>
        </div>
        @livewire('admin.service.category.faq.save-form',['data'=>$categories->id])
    </div>
@endsection
@push('js')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
    <script src="{{ asset('admin/js/editor.js') }}"></script>
@endpush
