@extends('admin.layouts.app')
@section('metatitle', 'FAQs Category : ' . \Content::ProjectName())
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex justify-content-between align-items-center">
            <div class=" py-3">
                <h4 class="fw-bold mb-0">FAQs Category </h4>
            </div>
            <div class="d-flex gap-2">
                <x-admin.button.back />
                @php
                    $tableColums = "[{ data: 'DT_RowIndex'},
                        {
                            data: 'category',
                            className: 'text-wrap text-break',
                        },
                        { data: 'is_publish' },
                        {
                            data: 'action',
                            orderable: false,
                            searchable: false
                        },
                    ]";
                @endphp

                    <x-admin.button.add-more :href="route('admin.faq-category.create', ['parent' => request('parent')])" icon='fas fa-plus'>Add More</x-admin.button.add-more>

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
                                        <th>Category</th>
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
    <script src="{{ asset('admin/js/table.js') }}"></script>
    <script>
        const tableListUrl = @json(route('admin.faq-category.index', ['parent' => request('parent')]));
        const removeRecordUrl = @json(route('admin.faq-category.remove'));

        function deleteconformation(deleteId) {
            if (confirm('If you remove this category, all the data associated with it will also be deleted.')) {
                const DeleteForm = $('.deleteForm' + deleteId).submit();
                return true;
            } else {
                return false;
            }
        }
        let columns = {!! $tableColums !!};
    </script>
    <script type="text/javascript">
        $(function() {
            generateTable();
        });
    </script>
@endpush
