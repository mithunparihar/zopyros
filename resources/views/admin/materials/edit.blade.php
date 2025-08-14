@extends('admin.layouts.app')
@section('metatitle', 'Roofing Systems Materials Edit : ' . \Content::ProjectName())
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-datatable table-responsive">
                <div class="card-header">
                    <div class="head-label d-flex justify-content-between">
                        <h5 class="card-title mb-0">Roofing Systems Materials Edit</h5>
                        <x-admin.button.back />
                    </div>
                </div>
                <div class="container">
                    @livewire('admin.material.update-form',['data'=>$material->id])
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
    <script src="{{ asset('admin/js/editor.js') }}"></script>
@endpush