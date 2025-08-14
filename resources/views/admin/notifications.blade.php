@extends('admin.layouts.app')
@section('metatitle', 'Profile : ' . \Content::ProjectName())
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">Account Settings /</span> Notifications
        </h4>
        <div class="row">
            <div class="col-md-12">
                <ul class="nav nav-pills flex-column flex-md-row mb-3">
                    <li class="nav-item"><a class="nav-link " href="{{ route('admin.profile') }}"><i
                                class="bx bx-user me-1"></i>
                            Account</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('admin.security') }}"><i
                                class="bx bx-lock-alt me-1"></i> Security</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('admin.socialMedia') }}"><i
                                class="bx bx-link me-1"></i> Social Accounts</a></li>
                    <li class="nav-item"><a class="nav-link active" href="{{ route('admin.notifications') }}"><i
                                class="bx bx-bell me-1"></i> Notifications</a></li>
                </ul>
                <div class="card mb-6">
                    <h5 class="card-header">Notifications</h5>
                    @php $allnotifications= \Content::adminInfo()->notifications()->paginate(10); @endphp
                    @if (count($allnotifications) > 0)
                        <div class="table-responsive" id="items-list">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="text-truncate">Enquiry For</th>
                                        <th class="text-truncate">Recent Activitiy</th>
                                        <th class="text-truncate"> </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($allnotifications as $notifications)
                                        <tr>
                                            <td>
                                                <a
                                                class="text-truncate d-flex gap-2 align-items-center text-heading fw-medium"
                                                    href="{{ \CommanFunction::getNotificationType($notifications)[3] ?? '#' }}">
                                                    <div class="avatar">
                                                        <span
                                                            class="avatar-initial rounded-circle bg-label-{{ \CommanFunction::getNotificationType($notifications)[2] }}">
                                                            {{ \CommanFunction::getNotificationType($notifications)[0] }}
                                                        </span>
                                                    </div>
                                                    {!! \CommanFunction::getNotificationType($notifications)[1] !!}
                                                </a>
                                            </td>
                                            <td class="text-truncate">
                                                {{-- {{ $notifications->created_at->diffForHumans() }} --}}
                                                {{ \CommanFunction::datetimeformat($notifications->created_at) }}
                                            </td>
                                            <td>
                                                {{-- <a href="" class="btn btn-dark btn-sm sws-bounce sws-top" data-title="View"><i class="fas fa-info-circle"></i></a> --}}
                                                <a href="{{ route('admin.notifications.remove', ['id' => $notifications->id]) }}"
                                                    class="btn btn-danger btn-sm sws-bounce sws-top" data-title="Remove"><i
                                                        class="fas fa-trash-alt"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        {{ $allnotifications->withQueryString()->links() }}
                    @else
                        <div class="text-center border-top py-4">
                            <p class="mb-0">No Data Available At This Moment</p>
                        </div>
                    @endif
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
