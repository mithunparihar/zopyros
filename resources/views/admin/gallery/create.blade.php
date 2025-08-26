@extends('admin.layouts.app')
@section('metatitle', 'Gallery Create : ' . \Content::ProjectName())
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-datatable table-responsive">
                <div class="card-header pb-3">
                    <div class="head-label d-flex justify-content-between">
                        <h5 class="card-title mb-0">Gallery Create</h5>
                        <x-admin.button.back />
                    </div>
                </div>
            </div>
        </div>
        <div class="card mt-3">
            <div class="card-body container">
                <small class="text-primary text-center d-block mb-4"><u>Do not submit the form until the preview of the uploaded image is shown.</u></small>
                @livewire('admin.gallery.save-form')
            </div>
        </div>
    </div>
@endsection
@push('js')

@endpush
