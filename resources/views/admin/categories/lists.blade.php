@extends('admin.layouts.app')
@section('metatitle', 'Categories : ' . \Content::ProjectName())
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="fw-bold py-3 mb-4">Categories <small>{{ $parentInfo ? '(' . $parentInfo->title . ')' : '' }}</small>
            </h4>
            <div class="d-flex gap-2">
                @php
                    $CreateUrl = route('admin.categories.create');
                    $tableList = "[
                              { data: 'DT_RowIndex'},
                                { data: 'title',className:'text-wrap text-break'},
                                { data: 'childs'},
                                { data: 'variants'},
                                { data: 'set_home'},
                                { data: 'set_footer'},
                                { data: 'is_publish'},
                                 {data: 'sequence'},
                                {
                                    data: 'action',
                                    orderable: false,
                                    searchable: false
                                }]";
                @endphp
                @if (request('parent'))
                    <x-admin.button.back />
                @endif
                @if ($level == 2)
                    @php

                        $tableList = "[{ data: 'DT_RowIndex'},
                                { data: 'title',className:'text-wrap text-break'},
                                { data: 'variants'},
                                { data: 'set_home'},
                                { data: 'set_footer'},
                                { data: 'is_publish'},
                                 {data : 'sequence'},
                                {
                                    data: 'action',
                                    orderable: false,
                                    searchable: false
                                }]";
                    @endphp
                @endif
                
                @if (!request('parent'))
                    <x-admin.button.add-more :href="route('admin.cms.edit', ['cm' => 16])" icon="fas fa-file">Page Content</x-admin.button.add-more>
                @endif

                @php
                    if (request('parent')) {
                        $CreateUrl = $CreateUrl . '?parent=' . request('parent');
                    }
                @endphp
                <x-admin.button.add-more :href="$CreateUrl">Add More</x-admin.button.add-more>

            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <form method="POST" action="{{ route('admin.categories.bulkdestroy') }}" class="card-body bulkForm p-0">
                        @csrf
                        <div class="card-datatable text-nowrap">
                            <table class="datatables-basic table border-top" id="datatable1">
                                <thead>
                                    <tr>
                                        <th>
                                            S.No
                                        </th>
                                        <th>{{ $parentInfo ? 'Sub ' : '' }}Category Info</th>
                                        @if ($level < 2)
                                            <th>Childs</th>
                                        @endif
                                        <th>Variants</th>
                                        <th>Set Home</th>
                                        <th>Set Footer</th>
                                        <th>Is Publish</th>
                                        <th>Sequence</th>
                                        <th>
                                            {{-- @if (request('parent'))
                                            <div class="dropdown">
                                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                    data-bs-toggle="dropdown" aria-expanded="false"><i
                                                        class="bx bx-dots-vertical-rounded"></i></button>
                                                <div class="dropdown-menu" style="">
                                                    <a class="dropdown-item text-danger" onclick="$('.bulkForm').submit()"
                                                        role="button"><i class="bx bx-trash me-1"></i> Delete All</a>
                                                </div>
                                            </div>
                                            @endif --}}
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
        const tableListUrl = @json(route('admin.categories.index', ['parent' => request('parent')]));
        const removeRecordUrl = @json(route('admin.categories.remove'));
        const sequenceUrl = @json(route('admin.categories.sequence'));

        function deleteconformation(deleteId) {
            if (confirm('Are you sure! You want to remove this record?')) {
                const DeleteForm = $('.deleteForm' + deleteId).submit();
                return true;
            } else {
                return false;
            }
        }
        let columns = {!! $tableList !!};
    </script>
    <script type="text/javascript">
        $(function() {
            generateTable();
        });
    </script>
@endpush
