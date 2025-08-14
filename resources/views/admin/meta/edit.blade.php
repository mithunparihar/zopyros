@extends('admin.layouts.app')
@section('metatitle', 'Meta Edit : ' . \Content::ProjectName())
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-datatable table-responsive">
                <div class="card-header">
                    <div class="head-label d-flex justify-content-between">
                        <h5 class="card-title mb-0">Meta Edit</h5>
                        <x-admin.button.back />
                    </div>
                </div>
            </div>
        </div>
        @livewire('admin.meta.update-form',['data'=>$metum->id])
    </div>
@endsection
@push('js')
@endpush
