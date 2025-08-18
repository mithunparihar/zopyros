@extends('admin.layouts.app')
@section('metatitle', 'Variants Create : ' . \Content::ProjectName())
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-datatable table-responsive">
                <div class="card-header pb-3">
                    <div class="head-label d-flex justify-content-between">
                        <h5 class="card-title mb-0">Variants Create</h5>
                        <x-admin.button.back />
                    </div>
                </div>
            </div>
        </div>
        @livewire('admin.variant.save-form')
    </div>
@endsection
