@extends('admin.layouts.app')
@section('metatitle', 'Quote Request : ' . \Content::ProjectName())
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="fw-bold py-3 mb-4">Quote Request</h4>
            <div class="d-flex gap-2"> <x-admin.button.back /> </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="bulkForm card-body p-0">
                        <div class="card-datatable text-nowrap">
                            <table class="datatables-basic table my-3 border-top" id="datatable1">
                                <thead>
                                    <tr>
                                        <th>Date & Time</th>
                                        <td>{{ \CommanFunction::datetimeformat($info->created_at) }}</td>
                                    </tr>
                                    <tr>
                                        <th>User Name</th>
                                        <td>{{ $info->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Email ID</th>
                                        <td>{{ $info->email }}</td>
                                    </tr>
                                    <tr>
                                        <th>Contact No</th>
                                        <td>{{ $info->contact }}</td>
                                    </tr>
                                    <tr>
                                        <th>Message</th>
                                        <td>{{ $info->message }}</td>
                                    </tr>

                                    <tr>
                                        <th>Product Info</th>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <x-image-preview fetchpriority="low" loading="lazy" imagepath="product"
                                                    style="width: 50px;height: 50px;" width="200" height="200"
                                                    :image="$info->productInfo->images[0]->image" />
                                                <div class="d-flex flex-column text-break text-wrap">
                                                    <h6 class="mb-0">{{ $info->productInfo->title ?? '' }}</h6>
                                                    @if ($info->productInfo)
                                                        <a
                                                            target="_blank"
                                                            href="{{ route('category', ['category' => $info->productInfo->alias]) }}">Read
                                                            More</a>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Color</th>
                                        <td>{{ $info->color_variant }}</td>
                                    </tr>
                                    <tr>
                                        <th>Size</th>
                                        <td>{{ $info->size_variant }}</td>
                                    </tr>
                                    <tr>
                                        <th>Material</th>
                                        <td>{{ $info->material_variant }}</td>
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
@endpush
