@extends('admin.layouts.app')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-lg-3 col-sm-6">
                <div class="card card-border-shadow-primary h-100">
                    <a href="{{ route('admin.products.index') }}" class="card-body">
                        <div class="d-flex align-items-center mb-2">
                            <div class="avatar me-4">
                                <span class="avatar-initial rounded bg-label-primary"><i
                                        class="icon-base bx bxs-box icon-lg"></i></span>
                            </div>
                            <h4 class="mb-0">{{ \App\Models\Product::count() }}</h4>
                        </div>
                        <p class="mb-0">Total Products</p>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="card card-border-shadow-info h-100">
                    <a href="{{ route('admin.categories.index') }}" class="card-body">
                        <div class="d-flex align-items-center mb-2">
                            <div class="avatar me-4">
                                <span class="avatar-initial rounded bg-label-primary"><i
                                        class="icon-base bx bxs-category icon-lg"></i></span>
                            </div>
                            <h4 class="mb-0">{{ \App\Models\Category::count() }}</h4>
                        </div>
                        <p class="mb-0">Total Categories</p>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="card card-border-shadow-danger h-100">
                    <a href="{{ route('admin.enquiry.quote') }}" class="card-body">
                        <div class="d-flex align-items-center mb-2">
                            <div class="avatar me-4">
                                <span class="avatar-initial rounded bg-label-primary"><i
                                        class="icon-base bx bxs-detail icon-lg"></i></span>
                            </div>
                            <h4 class="mb-0">
                                {{ \App\Models\QuoteEnquiry::count() }}
                            </h4>
                        </div>
                        <p class="mb-0">Total Quotes</p>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="card card-border-shadow-success h-100">
                    <a href="{{ route('admin.enquiry.quote') }}" class="card-body">
                        <div class="d-flex align-items-center mb-2">
                            <div class="avatar me-4">
                                <span class="avatar-initial rounded bg-label-primary"><i
                                        class="icon-base bx bxs-calendar-event icon-lg"></i></span>
                            </div>
                            <h4 class="mb-0">
                                {{ \App\Models\QuoteEnquiry::whereDate('created_at', \Carbon\Carbon::today())->count() }}
                            </h4>
                        </div>
                        <p class="mb-0">Today Quotes</p>
                    </a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12 my-4 col-xl-7">
                <div class="card">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="card-title m-0 me-2">Quote Request</h5>
                        <a href="{{ route('admin.enquiry.quote') }}"><u>View All</u></a>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <tr>
                                <th>Product Info</th>
                                <th>User Info</th>
                                <th></th>
                            </tr>
                            @foreach ($quotes as $row)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <x-image-preview class="me-2 rounded-2" style="width:60px!important"
                                                width="200" imagepath="product" :image="$row->productInfo->images[0]->image ?? ''" />
                                            <div class="d-flex flex-column">
                                                <h6 class="mb-0">{{ $row->productInfo->title ?? '' }}</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="d-flex flex-column">
                                                <h6 class="mb-0">{{ $row->name }}</h6>
                                                <span class="text-body small">{{ $row->email }}</span>
                                                <span class="text-body small"> <i class="fas fa-phone"></i>
                                                    {{ $row->contact }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                data-bs-toggle="dropdown" aria-expanded="false"><i
                                                    class="bx bx-dots-vertical-rounded"></i></button>
                                            <div class="dropdown-menu" style="">
                                                <a class="dropdown-item"
                                                    href="{{ route('admin.enquiry.quote.info', ['info' => $row->id]) }}">
                                                    <i class="fas fa-info-circle"></i> Information </a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-lg-12 my-4 col-xl-5">
                <div class="card">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="card-title m-0 me-2">Contact Request</h5>
                        <a href="{{ route('admin.enquiry.contact') }}"><u>View All</u></a>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <tr>
                                <th>User Info</th>
                                <th>Subject</th>
                            </tr>
                            @foreach ($lists as $list)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="d-flex flex-column">
                                                <h6 class="mb-0">{{ $list->name }}</h6>
                                                <span class="text-body small">{{ $list->email }}</span>
                                                <span class="text-body small"> <i class="fas fa-phone"></i>
                                                    {{ $list->phone }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>

                                        @if ($row->subject)
                                            <small><b>Subject:</b>{{ $row->subject }} </small><br>
                                        @endif
                                        <a role="button" class="d-inline-flex small align-items-center sws-bounce sws-top"
                                            data-title="Message: {{ $row->message }}">
                                            <u>View Message</u>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-lg-12 col-xl-4">
                <div class="card">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="card-title m-0 me-2">Total Inquiry</h5>
                    </div>
                    <div class="card-body">
                        <ul class="p-0 m-0">
                            <li class="d-flex mb-4 pb-1">
                                <div class="chart-progress me-4" data-color="danger" data-series="15"
                                    data-progress_variant="true"></div>
                                <div class="row w-100 align-items-center">
                                    <div class="col-9">
                                        <div class="me-2">
                                            <h6 class="mb-1">Quote Request</h6>
                                            <p class="mb-0">{{ \App\Models\QuoteEnquiry::count() }}
                                                Request</p>
                                        </div>
                                    </div>
                                    <div class="col-3 text-end">
                                        <a role="button"
                                            onclick="enquiryRedirect('{{ route('admin.enquiry.quote') }}','quote-request')"
                                            class="btn btn-sm btn-icon btn-label-secondary">
                                            <i class="icon-base bx bx-chevron-right icon-20px scaleX-n1-rtl"></i>
                                        </a>
                                    </div>
                                </div>
                            </li>
                            <li class="d-flex mb-4 pb-1">
                                <div class="chart-progress me-4" data-color="danger" data-series="15"
                                    data-progress_variant="true"></div>
                                <div class="row w-100 align-items-center">
                                    <div class="col-9">
                                        <div class="me-2">
                                            <h6 class="mb-1">Contact Request</h6>
                                            <p class="mb-0">{{ \App\Models\ContactEnquiry::count() }}
                                                Request</p>
                                        </div>
                                    </div>
                                    <div class="col-3 text-end">
                                        <a role="button"
                                            onclick="enquiryRedirect('{{ route('admin.enquiry.contact') }}','quote-request')"
                                            class="btn btn-sm btn-icon btn-label-secondary">
                                            <i class="icon-base bx bx-chevron-right icon-20px scaleX-n1-rtl"></i>
                                        </a>
                                    </div>
                                </div>
                            </li>
                            <li class="d-flex mb-4 pb-1">
                                <div class="chart-progress me-4" data-color="danger" data-series="15"
                                    data-progress_variant="true"></div>
                                <div class="row w-100 align-items-center">
                                    <div class="col-9">
                                        <div class="me-2">
                                            <h6 class="mb-1">Career Request</h6>
                                            <p class="mb-0">{{ \App\Models\CareerEnquiry::count() }}
                                                Request</p>
                                        </div>
                                    </div>
                                    <div class="col-3 text-end">
                                        <a role="button"
                                            onclick="enquiryRedirect('{{ route('admin.enquiry.career') }}','quote-request')"
                                            class="btn btn-sm btn-icon btn-label-secondary">
                                            <i class="icon-base bx bx-chevron-right icon-20px scaleX-n1-rtl"></i>
                                        </a>
                                    </div>
                                </div>
                            </li>
                            <li class="d-flex">
                                <div class="chart-progress me-4" data-color="danger" data-series="15"
                                    data-progress_variant="true"></div>
                                <div class="row w-100 align-items-center">
                                    <div class="col-9">
                                        <div class="me-2">
                                            <h6 class="mb-1">Newsletter</h6>
                                            <p class="mb-0">{{ \App\Models\Subscribe::count() }}
                                                Request</p>
                                        </div>
                                    </div>
                                    <div class="col-3 text-end">

                                        <a role="button"
                                            onclick="enquiryRedirect('{{ route('admin.enquiry.subscribe') }}','subscribe')"
                                            class="btn btn-sm btn-icon btn-label-secondary">
                                            <i class="icon-base bx bx-chevron-right icon-20px scaleX-n1-rtl"></i>
                                        </a>

                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
@section('metatitle', 'Dashboard : ' . \Content::ProjectName())
@push('css')
@endpush
@push('js')
    <script src="{{ asset('admin/assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>

    <script>
        function enquiryRedirect(redirection, notificationType) {
            Livewire.dispatch('redirectData', {
                redirection: redirection,
                notificationType: notificationType
            })
        }
    </script>
@endpush
