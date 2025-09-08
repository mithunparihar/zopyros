<footer>
    <div class="container row justify-content-sm-between justify-content-center row-gap-4">
        <div class="col-lg-3 text-center d-flex flex-column align-items-center justify-content-center gap-2 pe-lg-4">
            <a href="" class="d-inline-block mb-2"><img loading="lazy" fetchpriority="low"
                    src="{{ \App\Enums\Url::IMG }}logo.svg" alt="{{ \Content::ProjectName() }}" width="200"
                    height="168" class="flogo"></a>
        </div>
        <div class="col-lg-2">
            <h3 class="mb-md-3 mb-2">Quick Link</h3>
            <div class="links">
                <a href="{{ route('home') }}">Home</a>
                <a href="{{ route('about') }}">About Us</a>
                <a href="{{ route('projects') }}">Projects</a></li>
                <a href="{{ route('awards') }}">Awards & Recognitions</a>
                <a href="{{ route('testimonials') }}">Testimonials</a>
                <a href="{{ route('team') }}">Our Team</a>
            </div>
        </div>
        <div class="col-lg-2">
            <h3 class="mb-md-3 mb-2">Category</h3>
            <div class="links">
                @foreach ($categories as $category)
                    <a href="{{ route('category', ['category' => $category->fullURL()]) }}">{{ $category->title }}</a>
                @endforeach
            </div>
        </div>
        <div class="col-lg-2">
            <h3 class="mb-md-3 mb-2">Information</h3>
            <div class="links">
                <a href="{{ route('contact') }}">Contact Us</a>
                <a href="{{ route('career') }}">Career</a>
                <a href="{{ route('faqs') }}">FAQs</a>
                <a href="{{ route('privacy') }}">Privacy Policy</a>
                <a href="{{ route('terms') }}">Terms & Conditions</a>
                <a href="{{ route('blog') }}">Blog</a>
                {{-- <a href="#">Site Map</a> --}}
            </div>
        </div>
        <div class="col-lg-3">
            <form wire:submit="saveSubscribe" class="ps-lg-4">
                <h3 class="mb-md-3 mb-2">Subscribe</h3>
                <p>Get all the latest offers & info</p>
                <input type="text" class="form-control @error('subscribe_email') is-invalid @enderror "
                    wire:model="subscribe_email" placeholder="Enter Your Email ID">
                @error('subscribe_email')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
                <button wire:loading.remove wire:target="saveSubscribe" class="btn btn-o-thm1">Submit</button>
                <button wire:loading wire:target="saveSubscribe" type="button" disabled class="btn btn-o-thm1 Noar">
                    <span class="spinner-border" style="width: 18px;height:18px;font-size:10px;"></span>
                    Loading...
                </button>
            </form>
        </div>
    </div>
    <div class="fbottom">
        <div class="container row align-items-center small">
            <div class="col-lg-4 text-md-start text-center">&copy; Copyright <?= $year = date('Y') ?> <strong
                    class="text-u fw-semibold">{{ \Content::ProjectName() }}</strong>. All Rights Reserved.</div>
            <div class="col-lg-4 text-center">
                <div class="icons justify-content-center mt-3">
                    @foreach ($icons as $icon)
                        @if ($icon->social_media_icon == 'whatsapp')
                            <a href="https://wa.me/<?= $icon->link ?>?text=Hi,&nbsp;I&nbsp;would&nbsp;like&nbsp;to&nbsp;get&nbsp;more&nbsp;information..!"
                                target="_blank" title="Whatsapp"><img loading="lazy" fetchpriority="low"
                                    src="{{ \App\Enums\Url::IMG }}whatsapp-w.svg" alt="Whatsapp" width="20"
                                    height="20"></a>
                        @else
                            <a href="{{ $icon->link }}" target="_blank" title="{{ $icon->social_media_icon }}"><img
                                    loading="lazy" fetchpriority="low"
                                    src="{{ \App\Enums\Url::IMG }}{{ $icon->social_media_icon }}-i-w.svg"
                                    alt="{{ $icon->social_media_icon }}" width="20" height="20"></a>
                        @endif
                    @endforeach
                </div>
            </div>
            <div class="col-lg-4 text-md-end text-center">Made with <span class="text-danger">&#10084;</span> by <a
                    href="https://www.samwebstudio.com/" class="fw-semibold text-u" target="_blank">SAM Web
                    Studio</a></div>
        </div>
    </div>
</footer>
