<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{ \App\Enums\Url::IMG }}favicon.ico" type="image/x-icon">
    <link rel="apple-touch-icon" href="{{ \App\Enums\Url::IMG }}favicon.ico">
    <link rel="manifest" href="{{ \App\Enums\Url::FRONTEND }}manifest.json">
    <meta name="theme-color" content="{{ \App\Enums\Url::THEMECOLOR }}">
    <meta name="apple-mobile-web-app-status-bar" content="{{ \App\Enums\Url::THEMECOLOR }}">
    <meta name="color-scheme" content="dark light">
    <link rel="canonical" href="{{ route('home') }}">
    <link rel="preload" as="style" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css"
        fetchpriority="low" onload="this.rel='stylesheet'"
        integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ \App\Enums\Url::CSS }}main.min.css" fetchpriority="high">
    <meta property="og:image" content="{{ \App\Enums\Url::IMG }}logo-share.png">
    <meta property="og:image:type" content="image/png">
    <meta property="og:image:width" content="200">
    <meta property="og:image:height" content="200">
    @stack('css')
    @livewireStyles
    <link rel="dns-prefetch" href="{{ route('home') }}">
    <link rel="preconnect" href="//cdnjs.cloudflare.com">
    <link rel="preconnect" href="//cdn.jsdelivr.net">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
</head>

<body>
    @livewire('nav')
    @yield('content')
    @livewire('footer')
    @livewireScripts
    
    <div class="modal CallBack NoImgB fade" id="getInTouch" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="getInTouch" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                @livewire('popup-form')
            </div>
        </div>
    </div>
    <span class="BackTop" role="button" style="display:none"><span></span></span>
    <link rel="preload" as="style" href="{{ \App\Enums\Url::CSS }}style.min.css" fetchpriority="low"
        onload="this.rel='stylesheet'">
    <link rel="preload" as="style"
        href="https://fonts.googleapis.com/css2?family=Italianno&family=Josefin+Sans:ital,wght@0,100..700;1,100..700&display=swap"
        fetchpriority="low" onload="this.rel='stylesheet'">
    <link rel="preload" as="style" href="{{ \App\Enums\Url::CSS }}flag-icons.min.css" fetchpriority="low"
        onload="this.rel='stylesheet'">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/4.0.0-beta.2/jquery.min.js" fetchpriority="low"
        integrity="sha512-JobWAqYk5CSjWuVV3mxgS+MmccJqkrBaDhk8SKS1BW+71dJ9gzascwzW85UwGhxiSyR7Pxhu50k+Nl3+o5I49A=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" fetchpriority="low"
        integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous">
    </script>
    <script defer src="{{ \App\Enums\Url::JS }}custom.js" fetchpriority="low"></script>
    <script type="module" async>
        window.addEventListener('load', () => {
            registerSW();
        });
        async function registerSW() {
            if ('serviceWorker' in navigator) {
                try {
                    await navigator
                        .serviceWorker
                        .register('js/sw.js');
                } catch (e) {
                    console.log('SW registration failed');
                }
            }
        }
    </script>
    @stack('js')

</body>
