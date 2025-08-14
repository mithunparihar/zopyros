@extends('admin.layouts.app')
@section('metatitle', 'City Add : ' . \Content::ProjectName())
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-datatable table-responsive">
                <div class="card-header">
                    <div class="head-label d-flex justify-content-between">
                        <div>
                            <h5 class="card-title mb-0">City Add</h5>
                        </div>
                        <div>
                            <x-admin.button.back />
                        </div>
                    </div>
                </div>
                <div class="container">
                    @php
                    $routerLink = ['country'=>$countries->id,'state'=>$states->id];
                    if($district){
                        array_push($routerLink,['district'=>$district->id]);
                    }
                    @endphp
                    @livewire('admin.city.save-form',$routerLink)
                </div>
            </div>
        </div>
    </div>
@endsection
