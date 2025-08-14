@extends('admin.layouts.app')
@section('metatitle', 'Career : ' . \Content::ProjectName())
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="fw-bold py-3 mb-4">Career </h4>
            <div class="d-flex gap-2"> </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <form method="POST" action="{{ route('admin.enquiry.career.bulkdestroy') }}"  class="bulkForm card-body p-0">
                        @csrf
                        <div class="card-datatable text-nowrap">
                            <table class="datatables-basic table border-top" id="datatable1">
                                <thead>
                                    <tr>
                                        <th>
                                            <input type="checkbox" class="dt-checkboxes form-check-input" id="checkAll"
                                                name="checkAll">
                                        </th>
                                        <th width="20%">Date &  Time</th>
                                        <th width="20%">User Info</th>
                                        <th width="50%">Message</th>
                                        <th>
                                            <div class="dropdown">
                                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                    data-bs-toggle="dropdown" aria-expanded="false"><i
                                                        class="bx bx-dots-vertical-rounded"></i></button>
                                                <div class="dropdown-menu" style="font-size: 13px;">
                                                    <a class="dropdown-item text-danger"
                                                        onclick="$('.bulkForm').submit()" role="button"><i
                                                            class="bx bx-trash me-1"></i> Delete All</a>
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
@endsection
@push('css')
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
    <link rel="stylesheet"
        href="{{ asset('admin/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}" />
@endpush
@push('js')
    <script src="{{ asset('admin/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
    {{-- <script src="{{ asset('admin/assets/js/tables-datatables-basic.js') }}"></script> --}}
    <script src="{{ asset('admin/js/table.js') }}"></script>
    <script>
        const tableListUrl = @json(route('admin.enquiry.career'));
        const removeRecordUrl = @json(route('admin.enquiry.career.remove'));
        function deleteconformation(deleteId) {
            if (confirm('Are you sure! You want to remove this record?')) {
                const DeleteForm = $('.deleteForm' + deleteId).submit();
                return true;
            } else {
                return false;
            }
        }
        let columns = [{
                // data: 'DT_RowIndex',
                data: 's_no',
                className: 'sortCell',
            },{
                data: 'updated_at',
                className: 'text-wrap text-break',
            },
            {
                data: 'title',
                className: 'text-wrap text-break',
            },
            {
                data: 'message',
                className: 'text-wrap text-break',
            },
            {
                data: 'action',
                orderable: false,
                searchable: false
            },
        ];
    </script>
    <script type="text/javascript">
        $(function() {
            generateTable();
        });
    </script>
@endpush
