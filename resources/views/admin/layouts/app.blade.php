@php
    use Illuminate\Support\Facades\Vite;
@endphp
<!DOCTYPE html>
<html lang="en" class="light-style layout-navbar-fixed layout-menu-fixed layout-compact " dir="ltr"
    data-theme="theme-default" data-assets-path="{{ asset('admin/assets/') }}/" data-template="vertical-menu-template">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>@yield('metatitle')</title>
    <meta name="description" content="@yield('metatitle')" />
    <meta name="keywords" content="@yield('metatitle')">
    <link rel="canonical" href="{{ url()->current() }}">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="icon" type="image/x-icon" href="{{ asset('frontend/img/favicon.ico') }}" />

    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&amp;display=swap"
        rel="stylesheet">



    <!-- Icons -->
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/fonts/boxicons.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/css/rtl/main.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/css/tooltip.css') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/fonts/flag-icons.css') }}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/css/rtl/core.css') }}"
        class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/css/rtl/theme-default.css') }}"
        class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('admin/assets/css/demo.css') }}" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/typeahead-js/typeahead.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/apex-charts/apex-charts.css') }}" />
    <!-- Page CSS -->
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/css/pages/card-analytics.css') }}" />

    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/sweetalert2/sweetalert2.css') }}" />

    @stack('css')
    <script src="{{ asset('admin/assets/vendor/js/helpers.js') }}"></script>
    {{-- <script src="{{ asset('admin/assets/vendor/js/template-customizer.js') }}"></script> --}}
    <script src="{{ asset('admin/assets/js/config.js') }}"></script>
    @livewireStyles
    <script>
        let searching = true;
        let serverSide = false;
        const XCSRF_Token = "{{ csrf_token() }}";
        const CkeditorImageUpload = @json(route('admin.ckeditor.upload'));
    </script>
    <style>
    .fancybox__container{z-index:9999!important}
    .turbolinks-progress-bar{background:#7a45a3}
    .invalid-feedback{display:inline}
    .CollapseCat .bxs-right-arrow{transition:all .5s}
    .CollapseCat:not(.collapsed) .bxs-right-arrow{transform:rotate(90deg) translateX(-2px)}
    </style>
</head>

<body>
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            @livewire('admin.leftbar')
            <div class="layout-page">
                @livewire('admin.nav')
                <div class="content-wrapper">
                    @yield('content')
                    @livewire('admin.footer')
                    <div class="content-backdrop fade"></div>
                </div>
            </div>
        </div>
    </div>



    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>

    <script src="{{ asset('admin/assets/vendor/libs/pickr/pickr.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/libs/hammer/hammer.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/libs/i18n/i18n.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/js/menu.js') }}"></script>

    <script src="{{ asset('admin/assets/js/main.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
    <script src="{{ asset('admin/js/events.js') }}"></script>
    <script src="{{ asset('frontend/js/validation.js') }}"></script>


    <!-- Page JS -->
    @livewireScripts 
    @stack('js')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (window.Echo) {
                window.adminId = @json(\Content::adminInfo()->id);
                window.Echo.private(`admin-channel.${window.adminId}`)
                    .listen('Subscribe', (e) => {
                        SubscribeNotification();
                        AllNotification();
                    }).listen('ContactEnquiry', (e) => {
                        ContactNotification();
                        AllNotification();
                    }).listen('CareerEnquiry', (e) => {
                        CareerNotification();
                        AllNotification();
                    }).listen('FreeEstimation', (e) => {
                        EstimationNotification();
                        AllNotification();
                    });

            } else {
                console.error('Echo is not defined yet');
            }
        });

        function AllNotification() {
            let notifications = document.getElementById('badge-notifications');
            let bell = document.getElementById('badge-notifications-bell');
            let count = parseInt(notifications.textContent, 10);
            count = count + 1;
            notifications.innerText = count;
            if (count == 1) {
                bell.classList.add("bell", "text-dark");
            }
            const audio = document.getElementById("bellSound");
            audio.play().catch(error => {
                console.error("Playback failed:", error);
            });
        }

        function SubscribeNotification() {
            let subscribeNotification = document.getElementById('subscribeNotification');
            let count = parseInt(subscribeNotification.textContent, 10);
            count = count + 1;
            subscribeNotification.innerText = count;
            if (count == 1) {
                subscribeNotification.style.display = "block";
            }
        }

        function ContactNotification() {
            let contactNotification = document.getElementById('contactNotification');
            let count = parseInt(contactNotification.textContent, 10);
            count = count + 1;
            contactNotification.innerText = count;
            if (count == 1) {
                contactNotification.style.display = "block";
            }
        }

        function EstimationNotification() {
            let notification = document.getElementById('estimationNotification');
            let count = parseInt(notification.textContent, 10);
            count = count + 1;
            notification.innerText = count;
            if (count == 1) {
                notification.style.display = "block";
            }
        }

        function CareerNotification() {
            let careerNotification = document.getElementById('careerNotification');
            let count = parseInt(careerNotification.textContent, 10);
            count = count + 1;
            careerNotification.innerText = count;
            if (count == 1) {
                careerNotification.style.display = "block";
            }
        }
    </script>

</body>

</html>
