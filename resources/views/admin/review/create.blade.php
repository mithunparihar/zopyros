@extends('admin.layouts.app')
@section('metatitle', 'Social Media Review Create : ' . \Content::ProjectName())
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-datatable table-responsive">
                <div class="card-header pb-3">
                    <div class="head-label d-flex justify-content-between">
                        <h5 class="card-title mb-0">Social Media Review Create</h5>
                        <x-admin.button.back />
                    </div>
                </div>
            </div>
        </div>
        @livewire('admin.review.save-form')
    </div>
@endsection
