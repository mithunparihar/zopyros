<!DOCTYPE html>
<html lang="en" class="light-style customizer-hide" dir="ltr" data-theme="theme-default">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>Access Administrators Panel | {{ \Content::ProjectName() }}</title>
    <meta name="description"
        content="Most Powerful &amp; {{ \Content::ProjectName() }} Admin Dashboard built for {{ \Content::ProjectName() }}!" />
    <meta name="keywords" content="">
    <link rel="canonical" href="{{ url()->current() }}">
    <link rel="icon" href="{{ asset('frontend/img/favicon.ico') }}" type="image/x-icon">
    <link rel="apple-touch-icon" href="{{ asset('frontend/img/favicon.ico') }}">
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&amp;display=swap"
        rel="stylesheet">

    <script src="{{ asset('admin/assets/vendor/libs/jquery/jquery.js') }}"></script>
    <!-- Icons -->
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/fonts/boxicons.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/fonts/fontawesome.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/fonts/flag-icons.css') }}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/css/rtl/core.css') }}"
        class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/css/rtl/main.min.css') }}" />
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
            height: 130px;
        }

        .authentication-wrapper.authentication-basic .authentication-inner:before,
        .light-style .authentication-wrapper.authentication-basic .authentication-inner:after {
            display: none;
        }
    </style>
</head>

<body>
    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner">
                <!-- Register -->
                <div class="card">
                    <div class="card-body">
                        <!-- Logo -->
                        <div class="app-brand justify-content-center mb-2">
                            <a href="javascript:void(0)" class="app-brand-link gap-2">
                                <span class="app-brand-logo demo">
                                    <img src="{{ asset('admin/img/logo.svg') }}" alt="{{ \Content::ProjectName() }}">
                                </span>
                            </a>
                        </div>
                        <!-- /Logo -->
                        {{-- <h5 class="mb-2 text-center">Welcome to {{env('APP_NAME')}}! 👋</h5> --}}
                        <p class="my-3 text-center">Secure Login for {{ \Content::ProjectName() }} Administrators – Manage Services, Users,
                            and Settings All in One Place.</p>

                        <form id="formAuthentication" class="mb-3" action="{{ route('admin.adminlogin') }}"
                            method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="text"
                                    class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" id="email"
                                    name="email" placeholder="Enter your email or username" autofocus>
                                @error('email')
                                    <div class="fv-plugins-message-container invalid-feedback">
                                        <div data-field="email-username" data-validator="notEmpty">
                                            {{ $message }}
                                        </div>
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3 form-password-toggle">
                                <div class="d-flex justify-content-between">
                                    <label class="form-label" for="password">Password</label>
                                    {{-- <a href="{{route('admin.forgotpassword')}}">
                                        <small>Forgot Password?</small>
                                    </a> --}}
                                </div>
                                <div class="input-group input-group-merge">
                                    <input type="password" id="password"
                                        class="form-control lpass {{ $errors->has('password') ? 'is-invalid' : '' }}"
                                        name="password" placeholder="*********" aria-describedby="password" />
                                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"
                                            id="lpass-icon"></i></span>
                                </div>
                            </div>
                            <div class="mb-3">
                                <button class="btn btn-primary lsbtn w-100"
                                    onclick="$('.ldbtn').show(); $('.lsbtn').hide();" type="submit">Sign in</button>
                                <span class="ldbtn span-disabled">
                                    <button class="btn btn-primary w-100"
                                        onclick="$('.ldbtn').show(); $('.lsbtn').hide();" disabled type="button">
                                        <div class="spinner-border me-1" role="status"></div> Please wait...
                                    </button>
                                </span>

                            </div>
                        </form>


                    </div>
                </div>

            </div>
        </div>
    </div>
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
    <script src="{{ asset('admin/assets/js/main.js') }}"></script>
    <script>
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
    </script>
</body>

</html>
