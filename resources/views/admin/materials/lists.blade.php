@extends('admin.layouts.app')
@section('metatitle', 'Roofing Systems Materials : ' . \Content::ProjectName())
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="fw-bold py-3 mb-0">Roofing Systems Materials </h4>
            <div class="d-flex gap-2">
                <x-admin.button.add-more :href="route('admin.cms.edit',['cm'=>22])" icon="fas fa-file">Page Content</x-admin.button.add-more>
                <x-admin.button.add-more :href="route('admin.materials.create')">Add More</x-admin.button.add-more>
            </div>
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
                                        <th>Information</th>
                                        <th>Is Footer</th>
                                        <th>Is Publish</th>
                                        <th width="150">Sequence</th>
                                        <th></th>
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
        const tableListUrl = @json(route('admin.materials.index'));
        const removeRecordUrl = @json(route('admin.materials.remove'));
        const sequenceUrl = @json(route('admin.materials.sequence'));

        let columns = [{
                data: 'DT_RowIndex'
            },
            {
                data: 'info',
                className: 'text-wrap text-break',
            },{
                data:'is_home'
            },
            {
                data:'is_publish'
            },
            {data: 'sequence'},
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
