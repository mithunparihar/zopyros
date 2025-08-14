<!DOCTYPE html>
<html lang="en" class="light-style customizer-hide" dir="ltr" data-theme="theme-default">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>Reset Password | {{ project() }}</title>
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
            height: 50px;
        }
    </style>
</head>

<body>

    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner py-4">

                <!-- Reset Password -->
                <div class="card">
                    <div class="card-body">
                        <!-- Logo -->
                        <div class="app-brand justify-content-center">
                            <a href="javascript:void(0)" class="app-brand-link gap-2">
                                <span class="app-brand-logo demo">
                                    <img src="{{ asset('admin/img/logo.jpg') }}" alt="{{ project() }}">
                                </span>
                            </a>
                        </div>
                        <!-- /Logo -->
                        <h4 class="mb-2">Reset Password 🔒</h4>
                        <p class="mb-4">
                            <ul class="ps-3 mb-0" style="font-size: 12px;">
                                <li class="mb-1">
                                    Minimum 8 characters long - the more, the better
                                </li>
                                <li class="mb-1">At least one lowercase and one lowercase character</li>
                                <li>At least one number, symbol</li>
                            </ul>
                        </p>
                        <form class="mb-3" action="{{ route('admin.resetpasswordpost') }}" method="POST">
                            @csrf
                            <input type="hidden" name="token" value="{{ $token }}">
                            <div class="mb-3 form-password-toggle">
                                <label class="form-label" for="password">New Password</label>
                                <div class="input-group input-group-merge">
                                    <input type="password" id="password"
                                        class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }} lpass"
                                        name="password"
                                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                        aria-describedby="password" />
                                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"
                                            id="lpass-icon"></i></span>
                                    @error('password')
                                        <div class="fv-plugins-message-container invalid-feedback">
                                            <div data-field="email-username" data-validator="notEmpty">
                                                {{ $message }}
                                            </div>
                                        </div>
                                    @enderror
                                </div>

                            </div>
                            <div class="mb-3 form-password-toggle">
                                <label class="form-label" for="confirm-password">Confirm Password</label>
                                <div class="input-group input-group-merge">
                                    <input type="password" id="confirm-password"
                                        class="form-control {{ $errors->has('password_confirmation') ? 'is-invalid' : '' }} clpass"
                                        name="password_confirmation"
                                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                        aria-describedby="password" />
                                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"
                                            id="clpass-icon"></i></span>
                                    @error('password_confirmation')
                                        <div class="fv-plugins-message-container invalid-feedback">
                                            <div data-field="email-username" data-validator="notEmpty">
                                                {{ $message }}
                                            </div>
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <button onclick="$('.ldbtn').show(); $('.lsbtn').hide();"
                                class="btn btn-primary lsbtn w-100 mb-3">
                                Set new password
                            </button>
                            <x-admin.loader-button>
                                <x-slot:class>ldbtn</x-slot:class>
                            </x-admin.loader-button>
                            <div class="text-center">
                                <a href="{{ route('admin.login') }}">
                                    <i class="bx bx-chevron-left scaleX-n1-rtl bx-sm"></i>
                                    Back to login
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- /Reset Password -->
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



    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/toastr/toastr.css') }}" />
    <script src="{{ asset('admin/assets/vendor/libs/toastr/toastr.js') }}"></script>
    <script src="{{ asset('admin/assets/js/main.js') }}"></script>
    <script src="{{ asset('admin/assets/js/pages-auth.js') }}"></script>
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
        $('#lpass-icon').click(function() {
            if ($(this).hasClass('bx-show')) {
                $(this).removeClass('bx-show');
                $(this).addClass('bx-hide');
                $('.lpass').attr('type', 'password');
            } else {
                $(this).removeClass('bx-hide');
                $(this).addClass('bx-show');
                $('.lpass').attr('type', 'text');
            }
        });

        $('#clpass-icon').click(function() {
            if ($(this).hasClass('bx-show')) {
                $(this).removeClass('bx-show');
                $(this).addClass('bx-hide');
                $('.clpass').attr('type', 'password');
            } else {
                $(this).removeClass('bx-hide');
                $(this).addClass('bx-show');
                $('.clpass').attr('type', 'text');
            }
        });
    </script>
</body>

</html>
