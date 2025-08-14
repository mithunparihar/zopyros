@extends('admin.layouts.app')
@section('metatitle', 'Province : ' . \Content::ProjectName())
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="fw-bold py-3 mb-4">{{ $countries->name }} Province </h4>
            <div class="d-flex gap-2"> <x-admin.button.back /> </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-body p-0">
                        <div class="card-datatable text-nowrap">
                            <table class="datatables-basic table border-top" id="datatable1">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Province</th>
                                        <th>{{ $countries->id==153?'District':'Cities' }}</th>
                                        <th>Is Publish</th>
                                        {{-- <th></th> --}}
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
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
        const tableListUrl = @json(route('admin.states.index',['countries'=>$countries->id]));
        const removeRecordUrl = '';

        function deleteconformation(deleteId) {
            if (confirm('Are you sure! You want to remove this record?')) {
                const DeleteForm = $('.deleteForm' + deleteId).submit();
                return true;
            } else {
                return false;
            }
        }
        let columns = [{
                data: 'DT_RowIndex'
            },
            {
                data: 'title',
                className: 'text-wrap text-break',
            },
            {
                data: 'cities',
            },
            {
                data: 'is_publish'
            },
            // {
            //     data: 'action'
            // }
        ];
    </script>
    <script type="text/javascript">
        $(function() {
            generateTable();
        });
    </script>
@endpush
