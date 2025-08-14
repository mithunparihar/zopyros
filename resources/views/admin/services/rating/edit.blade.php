@extends('admin.layouts.app')
@section('metatitle', 'Edit Service Rating : ' . \Content::ProjectName())
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-datatable table-responsive">
                <div class="card-header">
                    <div class="head-label d-flex justify-content-between">
                        <h5 class="card-title mb-0">Edit Service Rating</h5>
                        <x-admin.button.back />
                    </div>
                </div>
                <div class="container">
                    @livewire('admin.service.rating.update-form', ['data' => $rating->id])
                </div>
            </div>
        </div>
    </div>
@endsection
@push('css')
    <style>
        .setPrimary {
            position: relative;
        }

        .notPrimary .btn-success,
        .notPrimary .badge {
            display: none;
        }

        .setPrimary .btn-success,
        .setPrimary .badge {
            display: block;
        }

        .setPrimary .btn-label-danger,
        .notPrimary .btn-label-danger {
            width: 26px;
            height: 26px;
            position: absolute;
            top: -11px;
            right: 0;
        }

        .setPrimary .btn-success {
            width: 25px;
            height: 25px;
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            top: 0;
            margin: auto;
        }

        .disabledForm input,
        .disabledForm select,
        .disabledForm textarea {
            pointer-events: none;
            cursor: not-allowed;
            background: #f1f1f1
        }

        .disabledForm .setPrimary .btn-success,
        .disabledForm .btn-label-danger {
            display: none;
        }

        img.defaultimg {
            background: #fff !important
        }
    </style>
     <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/rateyo/rateyo.css') }}" />
@endpush
@push('js')
@endpush
