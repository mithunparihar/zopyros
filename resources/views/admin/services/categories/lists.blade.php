@extends('admin.layouts.app')
@section('metatitle', 'Services Categories : ' . \Content::ProjectName())
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex justify-content-between align-items-center">
            <div class=" py-3">
                <h4 class="fw-bold mb-0"><span class="text-secondary">Services / </span> Categories </h4>
                <span>{{ $parentInfo ? '(' . $parentInfo->title . ')' : '' }}</span>
            </div>
            <div class="d-flex gap-2">
                @php
                    $CreateUrl = route('admin.services.categories.create');
                    $tableList = "[{  data: 's_no',className: 'sortCell',},
                                { data: 'title',},
                                { data: 'childs',},
                                { data: 'set_home'},
                                { data: 'is_publish'},
                                 {data: 'sequence'},
                                {
                                    data: 'action',
                                    orderable: false,
                                    searchable: false
                                }]";
                @endphp
                @if (request('parent'))
                    @php
                        $CreateUrl = $CreateUrl . '?parent=' . request('parent');
                        $tableList = "[{  data: 's_no',className: 'sortCell',},
                                { data: 'title'},
                                { data: 'is_publish'},
                                 {data : 'sequence'},
                                {
                                    data: 'action',
                                    orderable: false,
                                    searchable: false
                                }]";
                    @endphp
                    <x-admin.button.back />
                @else
                    {{-- <x-admin.button.add-more :link="route('admin.cms.edit', ['cm' => 13])" :buttonOptions="['icon' => 'fas fa-file', 'class' => 'btn-warning', 'name' => 'Page Content']" /> --}}
                @endif

                <x-admin.button.add-more :href="$CreateUrl">Add More</x-admin.button.add-more>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <form method="POST" action="{{ route('admin.services.categories.bulkdestroy') }}" class="card-body bulkForm p-0">
                        @csrf
                        <div class="card-datatable text-nowrap">
                            <table class="datatables-basic table border-top" id="datatable1">
                                <thead>
                                    <tr>
                                        <th>
                                            <input type="checkbox" class="dt-checkboxes form-check-input" id="checkAll"
                                                name="checkAll">
                                        </th>
                                        <th>{{ $parentInfo ? 'Sub ' : '' }}Categories Info</th>
                                        @if (!$parentInfo)
                                            <th>Child</th>
                                        @endif
                                        @if (!$parentInfo)
                                            <th>Set Home</th>
                                        @endif
                                        <th>Is Publish</th>
                                        <th>Sequence</th>
                                        <th>
                                            <div class="dropdown">
                                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                    data-bs-toggle="dropdown" aria-expanded="false"><i
                                                        class="bx bx-dots-vertical-rounded"></i></button>
                                                <div class="dropdown-menu" style="font-size: 13px;">
                                                    <a class="dropdown-item text-danger"
                                                        onclick="return confirmationDelete()" role="button"><i
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
        const tableListUrl = @json(route('admin.services.categories.index', ['parent' => request('parent')]));
        const removeRecordUrl = @json(route('admin.services.categories.remove'));
        const sequenceUrl = @json(route('admin.services.categories.sequence'));

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
        $('.sequenceForm').on('submit', function(e) {
            const formId = $(this).attr('id');
            e.preventDefault();
            const formData = new FormData(this);
            const Url = sequenceUrl;
            $.ajax({
                url: Url,
                dataType: "Json",
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: (res) => {
                    var event = new CustomEvent("successtoaster", {
                        detail: {
                            0: {
                                title: res?.title,
                                message: res?.message
                            }
                        },
                    });
                    dispatchEvent(event);
                    $('#' + formId + " .Err").html('');
                    generateTable();
                },
                error: (err) => {
                    let Errors = err?.responseJSON?.errors;
                    Object.keys(Errors).forEach((key) => {
                        $('#' + formId + " .Err").html(Errors[key][0]);
                    });
                },
            });
        });

        function confirmationDelete() {
            if (confirm(
                    'The category in which the child category or services does not exist will be deleted and the rest will be skipped.'
                    )) {
                $('.bulkForm').submit();
                return true;
            }
            return false;
        }
    </script>
@endpush
