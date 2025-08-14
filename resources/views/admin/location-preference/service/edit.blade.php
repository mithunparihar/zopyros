@extends('admin.layouts.app')
@section('metatitle', 'Location Services Edit : ' . \Content::ProjectName())
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-datatable table-responsive">
                <div class="card-header">
                    <div class="head-label d-flex justify-content-between">
                        <h5 class="card-title mb-0">Location Services Edit</h5>
                        <x-admin.button.back />
                    </div>
                </div>
            </div>
        </div>
        @livewire('admin.location-preference.service.update-form', ['data' => $service->id])
    </div>
@endsection
@push('js')
@endpush
