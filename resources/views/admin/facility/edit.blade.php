@extends('admin.layouts.app')
@section('metatitle', 'Facilities Edit : ' . \Content::ProjectName())
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-datatable table-responsive">
                <div class="card-header">
                    <div class="head-label d-flex justify-content-between">
                        <h5 class="card-title mb-0">Facilities Edit</h5>
                        <x-admin.button.back />
                    </div>
                </div>
                <div class="container">
                    @livewire('admin.facilities.update-form',['data'=>$facility->id])
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
@endpush
