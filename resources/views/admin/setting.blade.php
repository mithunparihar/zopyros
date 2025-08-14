@extends('admin.layouts.app')
@section('metatitle', 'Footer Section : ' . \Content::ProjectName())
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
       @if($id==1) 
       Contact Us
       @else
       Footer Section
       @endif
    </h4>
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-body">
                    @livewire('admin.setting.footer-form')
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@push('css')
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/select2/select2.css') }}" />
    
@endpush
@push('js')
<script src="{{ asset('admin/assets/vendor/libs/select2/select2.js') }}"></script>
    <script>
        setTimeout(() => {
            $('.select2').select2();
        }, 500);
    </script>
@endpush