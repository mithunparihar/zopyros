@extends('admin.layouts.app')
@section('metatitle', 'Services : ' . \Content::ProjectName())
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="fw-bold py-3 mb-4">Services </h4>
            <div class="d-flex gap-2">
                <div class="btn-group">
                    <button type="button" class="btn rounded-pill btn-sm btn-info dropdown-toggle" data-bs-toggle="dropdown"
                        aria-expanded="false">{{ ucwords(str_replace('-', ' ', request('type', 'All Services'))) }}</button>
                    <ul class="dropdown-menu" style="">
                        <li><a class="dropdown-item" href="{{ route('admin.services.lists.index') }}">All Services</a></li>
                        <li><a class="dropdown-item"
                                href="{{ route('admin.services.lists.index', ['type' => 'approval-pending']) }}">Approval
                                Pending</a></li>
                        <li><a class="dropdown-item"
                                href="{{ route('admin.services.lists.index', ['type' => 'approval-approved']) }}">Approved</a>
                        </li>
                        <li><a class="dropdown-item"
                                href="{{ route('admin.services.lists.index', ['type' => 'approval-disapproved']) }}">Disapproved</a>
                        </li>
                    </ul>
                </div>
                <x-admin.button.add-more :link="route('admin.services.lists.create')" :buttonOptions="['icon' => 'fas fa-plus']" />
                <x-admin.button.add-more :link="route('admin.services.lists.index')" :buttonOptions="['icon' => 'fas fa-sync-alt', 'class' => 'btn-primary', 'name' => 'Reload']" />
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <form method="POST" action="{{ route('admin.services.lists.bulkdestroy') }}"
                        class="card-body bulkForm p-0">
                        @csrf
                        <div class="card-datatable text-nowrap">
                            <table class="datatables-basic table border-top" id="datatable1">
                                <thead>
                                    <tr>
                                        <th>
                                            <input type="checkbox" class="dt-checkboxes form-check-input" id="checkAll"
                                                name="checkAll">
                                        </th>
                                        <th>Service Info</th>
                                        <th>Category Info</th>
                                        <th>Set Home</th>
                                        <th>Is Publish</th>
                                        <th>
                                            <div class="dropdown">
                                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                    data-bs-toggle="dropdown" aria-expanded="false"><i
                                                        class="bx bx-dots-vertical-rounded"></i></button>
                                                <div class="dropdown-menu" style="font-size: 13px;">
                                                    <a class="dropdown-item text-danger" onclick="$('.bulkForm').submit()"
                                                        role="button"><i class="bx bx-trash me-1"></i> Delete All</a>
                                                </div>
                                            </div>
                                        </th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="aprovalModel" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md modal-simple">
            <div class="modal-content">
                @livewire('admin.service.approval-modal')
            </div>
        </div>
    </div>
@endsection
@push('css')
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
    <link rel="stylesheet"
        href="{{ asset('admin/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}" />
    <style>
        .PriviewImgBox {
            margin: 0 -30px
        }

        .PriviewImgBox .col-2 {
            padding: 0 4px
        }

        .PriviewImgBox .col-2 .OthErr {
            line-height: 1.3 !important;
            font-size: 85%
        }
    </style>
@endpush
@push('js')
    <script src="{{ asset('admin/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
    {{-- <script src="{{ asset('admin/assets/js/tables-datatables-basic.js') }}"></script> --}}
    <script src="{{ asset('admin/js/table.js') }}"></script>
    <script>
        serverSide = true;
        const tableListUrl = @json(route('admin.services.lists.index', ['type' => request('type')]));
        const removeRecordUrl = @json(route('admin.services.lists.remove'));

        function deleteconformation(deleteId) {
            if (confirm('Are you sure! You want to remove this record?')) {
                const DeleteForm = $('.deleteForm' + deleteId).submit();
                return true;
            } else {
                return false;
            }
        }
        let columns = [{
                // data: 'DT_RowIndex'
                data: 's_no',
                className: 'sortCell',
            },
            {
                data: 'title',
                className: 'text-wrap text-break',
            },
            {
                data: 'category',
            },
            {
                data: 'club',
            },
            {
                data: 'is_publish'
            },
            {
                data: 'action',
                orderable: false,
            },
        ];
    </script>
    <script type="text/javascript">
        $(function() {
            generateTable();
        });

        function getProductStock(productId) {
            Livewire.dispatch('stockList', {
                product: productId
            });
        }

        function getApprovalProduct(productId) {
            Livewire.dispatch('approvalProduct', {
                product: productId
            });
        }

        $("#checkAll").change(function() {
            $(".dt-checkboxes").prop('checked', $(this).prop("checked"));
        });
    </script>
@endpush
