@extends('admin.layouts.app')
@section('metatitle', 'Variants : ' . \Content::ProjectName())
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex justify-content-between align-items-center">
            <div class="py-3">
                <h4 class="fw-bold mb-0">Variants </h4>
            </div>
            <div class="d-flex gap-2">
                @if (request('parent'))
                    <x-admin.button.back />
                @endif
                <x-admin.button.add-more :href="route('admin.variants.create', ['parent' => request('parent')])" icon="fas fa-plus">Add More</x-admin.button.add-more>
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
                                        <th>Variants</th>
                                        @if (!request('parent'))
                                            <th>Variant Types</th>
                                        @endif
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
    <link rel="preload" as="style" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css"
        onload="this.rel='stylesheet'">
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
    <script>
        Fancybox.bind('[data-fancybox="gallery"]', {});
    </script>
    {{-- <script src="{{ asset('admin/assets/js/tables-datatables-basic.js') }}"></script> --}}
    <script src="{{ asset('admin/js/table.js') }}"></script>
    @php
        $tableList = "[{ data: 'DT_RowIndex'},
                { data: 'lists',className:'text-wrap text-break'},
                { data: 'types'},
                { data: 'is_publish'},
                {
                    data: 'action',
                    orderable: false,
                    searchable: false
                }]";
        if (request('parent')) {
            $tableList = "[{ data: 'DT_RowIndex'},
                { data: 'lists',className:'text-wrap text-break'},
                { data: 'is_publish'},
                {
                    data: 'action',
                    orderable: false,
                    searchable: false
                }]";
        }
    @endphp
    <script>
        searching = false;
        const tableListUrl = @json(route('admin.variants.index', ['parent' => request('parent')]));
        const removeRecordUrl = @json(route('admin.variants.remove'));
        let columns = {!! $tableList !!};
    </script>
    <script type="text/javascript">
        $(function() {
            generateTable();
        });
    </script>
@endpush
