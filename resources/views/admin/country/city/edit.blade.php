@extends('admin.layouts.app')
@section('metatitle', 'City Edit : ' . \Content::ProjectName())
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-datatable table-responsive">
                <div class="card-header">
                    <div class="head-label d-flex justify-content-between">
                        <div>
                            <h5 class="card-title mb-0">City Edit</h5>
                        </div>
                        <div>
                            <x-admin.button.back />
                        </div>
                    </div>
                </div>
                <div class="container">
                    @livewire('admin.city.update-form',['city'=>$city->id])
                </div>
            </div>
        </div>
    </div>
@endsection
