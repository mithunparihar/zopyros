<!DOCTYPE html>
<html lang="en" class="light-style customizer-hide" dir="ltr" data-theme="theme-default">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>Forgot Password | {{\Content::ProjectName()}}</title>
    <meta name="description"
        content="Most Powerful &amp; Comprehensive Bootstrap 5 HTML Admin Dashboard Template built for developers!" />
    <meta name="keywords" content="dashboard, bootstrap 5 dashboard, bootstrap 5 design, bootstrap 5">
    <link rel="canonical" href="{{ url()->current() }}">
    <link rel="icon" type="image/x-icon" href="https://www.samwebstudio.co/therasession.com/html/img/favicon.ico" />
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&amp;display=swap"
        rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/fonts/boxicons.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/fonts/fontawesome.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/fonts/flag-icons.css') }}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/css/rtl/core.css') }}"
        class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/css/rtl/theme-default.css') }}"
        class="template-customizer-theme-css" />

    <!-- Vendor -->
    <link rel="stylesheet"
        href="{{ asset('admin/assets/vendor/libs/formvalidation/dist/css/formValidation.min.css') }}" />

    <!-- Page CSS -->
    <!-- Page -->
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/css/pages/page-auth.css') }}">

    <style>
        .app-brand-logo img,
        .app-brand-logo svg {
            height: 60px;
        }
        .authentication-wrapper.authentication-basic .authentication-inner:before,
    .light-style .authentication-wrapper.authentication-basic .authentication-inner:after{
        display:none;
    }
    </style>
</head>

<body>

    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner py-4">

                <!-- Forgot Password -->
                <div class="card">
                    <div class="card-body">
                        <!-- Logo -->
                        <div class="app-brand justify-content-center  mb-3">
                            <a href="javascript:void(0)" class="app-brand-link gap-2">
                                <span class="app-brand-logo demo">
                                    <img src="{{asset('admin/img/logo.jpg')}}" alt="{{\Content::ProjectName()}}">
                                </span>
                            </a>
                        </div>
                        <!-- /Logo -->
                        <div @class(['text-center'])>
                            {{-- <h4 class="mb-2">Forgot Password? 🔒</h4> --}}
                            <p class="mb-3">Enter your email and we'll send you instructions to reset your password</p>
                        </div>
                        <form class="mb-3"
                            action="{{route('admin.sendforgotpasswordlink')}}"
                            method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="text" class="form-control {{$errors->has('email')?'is-invalid':''}} " id="email" name="email"
                                    placeholder="Enter your email" value="{{old('email')}}" autofocus>
                                @error('email')
                                <div class="fv-plugins-message-container invalid-feedback">
                                    <div data-field="email-username" data-validator="notEmpty">
                                        {{$message}}
                                    </div>
                                </div>
                                @enderror
                            </div>
                            <button onclick="$('.ldbtn').show(); $('.lsbtn').hide();" class="btn lsbtn btn-dark w-100">Send Reset Link</button>
                            <button class="btn btn-dark ldbtn w-100" style="display:none;" disabled onclick="$('.ldbtn').show(); $('.lsbtn').hide();" type="button">
                                <div class="spinner-border me-1" role="status"></div>  Loading
                            </button>
                        </form>
                        <div class="text-center">
                            <a href="{{ route('admin.login') }}"
                                class="d-flex align-items-center justify-content-center">
                                <i class="bx bx-chevron-left scaleX-n1-rtl bx-sm"></i>
                                Back to login
                            </a>
                        </div>
                    </div>
                </div>
                <!-- /Forgot Password -->
            </div>
        </div>
    </div>

    <script src="{{ asset('admin/assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/libs/hammer/hammer.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/libs/i18n/i18n.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/libs/typeahead-js/typeahead.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/js/menu.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/libs/formvalidation/dist/js/FormValidation.min.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/libs/formvalidation/dist/js/plugins/Bootstrap5.min.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/libs/formvalidation/dist/js/plugins/AutoFocus.min.js') }}"></script>

    <script src="{{ asset('admin/assets/js/pages-auth.js') }}"></script>

    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/toastr/toastr.css') }}" />
    <script src="{{ asset('admin/assets/vendor/libs/toastr/toastr.js') }}"></script>
    <script src="{{ asset('admin/assets/js/main.js') }}"></script>
    <script>
        @if (session()->has('success_msg'))
            toastr.success("{{ session('success_msg') }}");
        @endif
        @if (session()->has('warning_msg'))
            toastr.warning("{{ session('warning_msg') }}");
        @endif
        @if (session()->has('error_msg'))
            toastr.error("{{ session('error_msg') }}");
        @endif
    </script>
</body>

</html>
