@extends('admin.layouts.app')
@section('metatitle', 'Social Accounts : ' . \Content::ProjectName())
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">Account Settings /</span> Social Accounts
        </h4>
        <div class="row">
            <div class="col-md-12">
                <ul class="nav nav-pills flex-column flex-md-row mb-3">
                    <li class="nav-item"><a class="nav-link" href="{{ route('admin.profile') }}"><i class="bx bx-user me-1"></i>
                            Account</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('admin.security') }}"><i
                                class="bx bx-lock-alt me-1"></i> Security</a></li>
                    <li class="nav-item"><a class="nav-link active" href="{{ route('admin.socialMedia') }}"><i
                                class="bx bx-link me-1"></i> Social Accounts</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('admin.notifications') }}"><i
                                class="bx bx-bell me-1"></i> Notifications</a></li>
                </ul>
                <div class="row">
                    <div class="col-md-12 col-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Social Accounts</h5>
                                <p class="text-danger small"><b>NOTE:</b> The social media where the link is not added will also not be shown in the frontend.</p>
                            </div>
                            <div class="card-body">
                                @livewire('admin.social-media')
                            </div>
                        </div>
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
        }, 100);
    </script>
@endpush
