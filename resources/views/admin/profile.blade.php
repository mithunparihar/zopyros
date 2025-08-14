@extends('admin.layouts.app')
@section('metatitle', 'Profile : ' . \Content::ProjectName())
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">Account Settings /</span> Account
        </h4>
        <div class="row">
            <div class="col-md-12">
                <ul class="nav nav-pills flex-column flex-md-row mb-3">
                    <li class="nav-item"><a class="nav-link active" href="javascript:void(0);"><i class="bx bx-user me-1"></i>
                            Account</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('admin.security') }}"><i
                                class="bx bx-lock-alt me-1"></i> Security</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('admin.socialMedia') }}"><i
                                class="bx bx-link me-1"></i> Social Accounts</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('admin.notifications') }}"><i
                                class="bx bx-bell me-1"></i> Notifications</a></li>
                </ul>
                <div class="card mb-4">
                    <h5 class="card-header">Profile Details</h5>
                    <div class="card-body">
                        @livewire('admin.profile.profile-photo')
                    </div>
                    <hr class="my-0">
                    <div class="card-body">
                        @livewire('admin.profile.profile-form')
                    </div>
                </div>
                {{-- <div class="card mb-4">
                    <h5 class="card-header">Invoice Information</h5>
                    <div class="card-body">
                        @livewire('admin.profile.invoice-form')
                    </div>
                </div> --}}
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
        }, 100);
    </script>
@endpush
