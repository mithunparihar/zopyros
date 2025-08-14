<div class="position-fixed bottom-0 start-0 p-3" style="z-index:9999">
    <div id="liveToast" class="toast hide" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-body d-flex  text-white justify-content-between">
            <span class="liveToastText"></span>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>

    @push('js')
        <script>
            let wifi =
                '<svg viewBox="0 0 12 9"><path d="M1,3a8,10,0,0,1,10,0h0"/><path d="M3,5a4,4,0,0,1,6,0h0"/><circle cx="6" cy="7" r=".5"/></svg>';
            let wifiDisconnect =
                '<svg viewBox="0 0 12 9"><path d="M1,3a8,10,0,0,1,10,0h0"/><path d="M3,5a4,4,0,0,1,6,0h0"/><circle cx="6" cy="7" r=".5"/><line x1="1.5" y1="1" x2="9.5" y2="8"/></svg>';
            window.addEventListener('online', () => {
                $('#liveToast').removeClass('show bg-danger');
                $('#liveToast').addClass('show bg-success');
                $('.liveToastText').html(wifi + ' Your internet connection is back. You`re good to go!');
                setTimeout(() => {
                    $('#liveToast').toast("hide");
                }, 10 * 60 * 1000);
            });
            window.addEventListener('offline', () => {
                $('#liveToast').removeClass('show bg-success');
                $('#liveToast').addClass('show bg-danger');
                $('.liveToastText').html(wifiDisconnect + ' Uh-oh! It looks like you’re offline. Mind checking your connection?');
                setTimeout(() => {
                    $('#liveToast').toast("hide");
                }, 10 * 60 * 1000);
            });
        </script>
    @endpush

    @push('css')
        <style>
            .liveToastText svg{height:24px;width:24px;fill:none;stroke:var(--white);stroke-linecap:round}
        </style>
    @endpush
</div>
