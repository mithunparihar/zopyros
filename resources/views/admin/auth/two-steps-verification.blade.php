<!DOCTYPE html>
<html lang="en" class="light-style customizer-hide" dir="ltr" data-theme="theme-default">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>Two Steps Verification | {{ \Content::ProjectName() }}</title>
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
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/css/rtl/main.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/css/rtl/theme-default.css') }}"
        class="template-customizer-theme-css" />

    <!-- Vendor -->
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/@form-validation/form-validation.css') }}" />

    <!-- Page CSS -->
    <!-- Page -->
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/css/pages/page-auth.css') }}">

    <style>
        .app-brand-logo img,
        .app-brand-logo svg {
            height: 50px;
        }

        .authentication-wrapper.authentication-basic .authentication-inner:before,
        .light-style .authentication-wrapper.authentication-basic .authentication-inner:after {
            display: none;
        }
    </style>
</head>

<body>

    <div class="authentication-wrapper authentication-basic px-2">
        <div class="authentication-inner">
            <!--  Two Steps Verification -->
            <div class="card" id="card-block">
                <div class="card-body">
                    <!-- Logo -->
                    <div class="app-brand justify-content-center mb-2">
                        <a href="javascript:void(0)" class="app-brand-link gap-2">
                            <span class="app-brand-logo demo">
                                <img src="{{ asset('admin/img/logo.jpg') }}" alt="{{ \Content::ProjectName() }}">
                            </span>
                        </a>
                    </div>
                    <!-- /Logo -->
                    <h4 class="mb-2 text-center">Two Step Verification 🔒</h4>
                    <p class="text-start mb-4 text-center">
                        We sent a verification code to your email. Enter the code from the email address in the field
                        below.
                        <span
                            class="fw-bold d-block mt-2">{{ \Content::adminInfo()->two_step_verification_email }}</span>
                    </p>
                    <p class="mb-0 fw-semibold">Type your 6 digit security code</p>
                    <form id="twoStepsForm" action="{{ route('admin.checktwostepsverification') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <div
                                class="auth-input-wrapper d-flex align-items-center justify-content-sm-between numeral-mask-wrapper">
                                <input type="text"
                                    class="form-control auth-input h-px-50 text-center numeral-mask text-center h-px-50 mx-1 my-2"
                                    maxlength="1" autofocus>
                                <input type="text"
                                    class="form-control auth-input h-px-50 text-center numeral-mask text-center h-px-50 mx-1 my-2"
                                    maxlength="1">
                                <input type="text"
                                    class="form-control auth-input h-px-50 text-center numeral-mask text-center h-px-50 mx-1 my-2"
                                    maxlength="1">
                                <input type="text"
                                    class="form-control auth-input h-px-50 text-center numeral-mask text-center h-px-50 mx-1 my-2"
                                    maxlength="1">
                                <input type="text"
                                    class="form-control auth-input h-px-50 text-center numeral-mask text-center h-px-50 mx-1 my-2"
                                    maxlength="1">
                                <input type="text"
                                    class="form-control auth-input h-px-50 text-center numeral-mask text-center h-px-50 mx-1 my-2"
                                    maxlength="1">
                            </div>
                            <input type="hidden" name="otp" />
                            @error('otp')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                        <button onclick="checkOtp()" class="btn btn-primary lsbtn w-100 mb-3"> Verify my account
                        </button>
                        <button type="button" style="display: none" class="btn btn-primary ldbtn w-100 mb-3">
                            <div class="spinner-border me-1" role="status"></div> Loading
                        </button>

                        <div class="text-center">Didn't get the code?
                            <a href="{{ route('admin.resendtwostepsverification') }}" class="btn-card-block-overlay">
                                Resend
                            </a>
                        </div>
                    </form>
                </div>
            </div>
            <!-- / Two Steps Verification -->
        </div>
    </div>

    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/toastr/toastr.css') }}" />
    <script src="{{ asset('admin/assets/vendor/libs/toastr/toastr.js') }}"></script>


    <script src="{{ asset('admin/assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/libs/popper/popper.js') }}"></script>

    <script src="{{ asset('admin/assets/vendor/libs/cleavejs/cleave.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/libs/@form-validation/popular.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/libs/@form-validation/bootstrap5.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/libs/@form-validation/auto-focus.js') }}"></script>
    <script src="{{ asset('admin/assets/js/pages-auth.js') }}"></script>
    <script src="{{ asset('admin/assets/js/pages-auth-two-steps.js') }}"></script>


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

        function checkOtp() {
            if ($('input[name=otp]').val() != '') {
                $('.ldbtn').show();
                $('.lsbtn').hide();
            }
        }


        const $inp = $(".auth-input");

        $inp.on({
            paste(ev) { // Handle Pasting

                const clip = ev.originalEvent.clipboardData.getData('text').trim();
                // Allow numbers only
                if (!/\d{6}/.test(clip)) return ev.preventDefault(); // Invalid. Exit here
                // Split string to Array or characters
                const s = [...clip];
                // Populate inputs. Focus last input.
                $inp.val(i => s[i]).eq(5).focus();
            },
            input(ev) { // Handle typing

                const i = $inp.index(this);
                if (this.value) $inp.eq(i + 1).focus();
            },
            keydown(ev) { // Handle Deleting

                const i = $inp.index(this);
                if (!this.value && ev.key === "Backspace" && i) $inp.eq(i - 1).focus();
            }

        });
    </script>
</body>

</html>
