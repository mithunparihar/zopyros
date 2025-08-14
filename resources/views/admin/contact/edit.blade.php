@extends('admin.layouts.app')
@section('metatitle', 'Contact Information : ' . \Content::ProjectName())
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-datatable table-responsive">
                <div class="card-header">
                    <div class="head-label d-flex justify-content-between">
                        <h5 class="card-title mb-0">Contact Information</h5>
                        
                    </div>
                </div>
            </div>
        </div>
        @livewire('admin.contact.update-form', ['data' => $lists->id])
    </div>
@endsection
@push('js')
@endpush
