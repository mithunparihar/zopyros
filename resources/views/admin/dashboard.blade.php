@extends('admin.layouts.app')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
           
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
