@extends('admin.layouts.app')
@section('metatitle', 'Service Rating : ' . \Content::ProjectName())
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex justify-content-between align-items-center">
            <div class="mb-1">
                <h4 class="mb-0 fw-bold">Service Rating </h4>
                <small>({{ $service->title }})</small>
            </div>
            <div class="d-flex gap-2">
                <x-admin.button.back />
                <x-admin.button.add-more :link="route('admin.services.lists.rating.create', ['service' => $service->id])" :buttonOptions="['icon' => 'fas fa-plus']" />
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <form method="POST" action="{{ route('admin.services.lists.bulkdestroy', ['service' => $service->id]) }}"
                        class="card-body bulkForm p-0">
                        @csrf
                        <div class="card-datatable text-nowrap">
                            <table class="datatables-basic table border-top" id="datatable1">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Service Info</th>
                                        <th>Company Info</th>
                                        <th>Rating</th>
                                        <th>Is Publish <span class="sws-bounce sws-top"
                                                data-title="This section will be shown on the all rating section."><i
                                                    class="fas fa-info-circle"></i></span> </th>
                                        <th>Show <span class="sws-bounce sws-top"
                                                data-title="This section will be shown on the product details page (For Listing)."><i
                                                    class="fas fa-info-circle"></i></span> </th>
                                        <th></th>
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
        const tableListUrl = @json(route('admin.services.lists.rating.index', ['service' => $service->id]));
        const removeRecordUrl = @json(route('admin.services.lists.rating.remove', ['service' => $service->id]));

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
                data: 'company',
            },
            {
                data: 'rating',
            },
            {
                data: 'is_publish'
            },
            {
                data: 'is_show'
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
