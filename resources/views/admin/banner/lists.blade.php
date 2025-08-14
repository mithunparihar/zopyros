@extends('admin.layouts.app')
@section('metatitle', 'Banners : ' . \Content::ProjectName())
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card p-3">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="fw-bold mb-0">Banner </h4>
                <div class="d-flex gap-2">
                    <x-admin.button.add-more icon="fas fa-plus" href="{{ route('admin.banner.create') }}">Add
                        More</x-admin.button.add-more>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-body p-0">
                        <div class="card-datatable text-nowrap">
                            <table class="datatables-basic table border-top" id="datatable1">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Image</th>
                                        <th>Image Alt</th>
                                        <th>Is Publish</th>
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
    <link rel="preload" as="style" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css"
        onload="this.rel='stylesheet'">
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
    <script>
        Fancybox.bind('[data-fancybox="gallery"]', {});
    </script>
    <script src="{{ asset('admin/js/table.js') }}"></script>
    <script>
        const tableListUrl = @json(route('admin.banner.index'));
        const removeRecordUrl = @json(route('admin.banner.remove'));

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
                data: 'image',
            },
            {
                data: 'image_alt',
                className: 'text-wrap text-break',
            },
            {
                data: 'is_publish'
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
