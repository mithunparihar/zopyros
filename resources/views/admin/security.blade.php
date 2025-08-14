@extends('admin.layouts.app')
@section('metatitle', 'Security : ' . \Content::ProjectName())
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">Account Settings /</span> Security
        </h4>
        <div class="row">
            <div class="col-md-12">
                <ul class="nav nav-pills flex-column flex-md-row mb-3">
                    <li class="nav-item"><a class="nav-link" href="{{ route('admin.profile') }}"><i class="bx bx-user me-1"></i>
                            Account</a></li>
                    <li class="nav-item"><a class="nav-link active" role="button"><i class="bx bx-lock-alt me-1"></i>
                            Security</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('admin.socialMedia') }}"><i
                                class="bx bx-link me-1"></i> Social Accounts</a></li>
                    <li class="nav-item"><a class="nav-link " href="{{ route('admin.notifications') }}"><i
                                class="bx bx-bell me-1"></i> Notifications</a></li>
                </ul>
                <div class="card mb-4">
                    <h5 class="card-header">Change Password</h5>
                    <div class="card-body">
                        @livewire('admin.profile.security')
                    </div>
                </div>

                <div class="card mb-4">
                    <h5 class="card-header">Two-steps verification</h5>
                    <div class="card-body">
                        @if (\Content::adminInfo()->two_step_verification == 0)
                            <p class="fw-semibold mb-3">Two factor authentication is not enabled yet.</p>
                        @endif
                        <p class="w-75">Two-factor authentication adds an additional layer of security to your account by
                            requiring more than just a password to log in.

                        </p>
                        @if (\Content::adminInfo()->two_step_verification == 0)
                            <button class="btn btn-primary mt-2" data-bs-toggle="modal" data-bs-target="#enableOTP">Enable
                                two-factor authentication</button>
                        @else
                            <a href="javascript:void(0)" onclick="checkConfirmation()" class="btn btn-danger mt-2">Disabled
                                two-factor authentication</a>
                        @endif
                    </div>
                </div>

                @if (\Content::adminInfo()->role == 0)
                    <!-- Recent Devices -->
                    <div class="card mb-4">
                        <h5 class="card-header">Recent Devices <br> <small style="font-size: 12px;"
                                class="text-secondary">Latest 10 Records</small> </h5>

                        <div class="table-responsive">
                            <table class="table border-top">
                                <thead>
                                    <tr>
                                        <th class="text-truncate">By</th>
                                        <th class="text-truncate">Browser</th>
                                        <th class="text-truncate">Device</th>
                                        <th class="text-truncate">IP Address</th>
                                        <th class="text-truncate">Recent Activities</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($lists as $devices)
                                        @php
                                            $device = '';
                                            if (!empty(explode('/', $devices->method)[1])) {
                                                $device = explode('(', explode('/', $devices->method)[1])[0];
                                            }
                                        @endphp
                                        <tr>
                                            <td>
                                                <div class="d-flex">
                                                    <div class="flex-shrink-0 me-3">
                                                        <div class="avatar">
                                                            <x-image-preview class='w-px-40 h-auto rounded-circle' width="100"
                                                                alt="user - avatar" imagepath="admin" :image="$devices->admin->profile ?? ''" />
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1" style="line-height: normal">
                                                        <span
                                                            class="fw-semibold d-block">{{ $devices->admin->name ?? '' }}</span>
                                                        <small class="text-muted">
                                                            @if (($devices->admin->role ?? 0) == 0)
                                                                Administrator
                                                            @endif
                                                            @if (($devices->admin->role ?? 0) == 1)
                                                                Sub Admin
                                                            @endif
                                                        </small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-truncate">
                                                @if ($device == 'Windows')
                                                    <i class='bx bxl-windows text-info me-3'></i>
                                                @endif
                                                <span
                                                    class="fw-semibold">{{ explode('/', $devices->method)[1] ?? '' }}</span>
                                            </td>
                                            <td class="text-truncate">{{ explode('/', $devices->method)[0] ?? '' }}</td>
                                            <td class="text-truncate">{{ $devices->ip }}</td>
                                            <td class="text-truncate">
                                                {{ \CommanFunction::datetimeformat($devices->created_at) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!--/ Recent Devices -->
                @endif

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

    <div class="modal fade" id="enableOTP" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-simple modal-enable-otp modal-dialog-centered">
            <div class="modal-content p-3 p-md-5">
                <div class="modal-body">
                    <button type="button" class="btn-close" onclick="window.location.reload()"></button>
                    <div class="text-center mb-4">
                        <h3 class="mb-5">Enable Two-steps verification</h3>
                    </div>
                    <p>Enter your email address and we will send you a verification code.</p>
                    @livewire('admin.profile.two-steps-verification')
                </div>
            </div>
        </div>
    </div>
    @push('js')
        <script>
            function checkConfirmation() {
                if (confirmation('Are you sure! you want to disabled two-steps verification.')) {
                    Livewire.dispatch('updateTwoFactorAuthentication');
                    return true;
                }
                return false;
            }
        </script>
    @endpush
@endpush
