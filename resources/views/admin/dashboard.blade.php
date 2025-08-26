@extends('admin.layouts.app')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-lg-3 col-sm-6">
                <div class="card card-border-shadow-primary h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2">
                            <div class="avatar me-4">
                                <span class="avatar-initial rounded bg-label-primary"><i
                                        class="icon-base bx bxs-box icon-lg"></i></span>
                            </div>
                            <h4 class="mb-0">{{ \App\Models\Product::count() }}</h4>
                        </div>
                        <p class="mb-0">Total Products</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="card card-border-shadow-info h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2">
                            <div class="avatar me-4">
                                <span class="avatar-initial rounded bg-label-primary"><i
                                        class="icon-base bx bxs-category icon-lg"></i></span>
                            </div>
                            <h4 class="mb-0">{{ \App\Models\Category::count() }}</h4>
                        </div>
                        <p class="mb-0">Total Categories</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="card card-border-shadow-danger h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2">
                            <div class="avatar me-4">
                                <span class="avatar-initial rounded bg-label-primary"><i
                                        class="icon-base bx bxs-cube icon-lg"></i></span>
                            </div>
                            <h4 class="mb-0">{{ \App\Models\Variant::parent(0)->count() }}</h4>
                        </div>
                        <p class="mb-0">Total Variants</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="card card-border-shadow-success h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2">
                            <div class="avatar me-4">
                                <span class="avatar-initial rounded bg-label-primary"><i
                                        class="icon-base bx bxs-award icon-lg"></i></span>
                            </div>
                            <h4 class="mb-0">{{ \App\Models\Award::count() }}</h4>
                        </div>
                        <p class="mb-0">Total Awards</p>
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
