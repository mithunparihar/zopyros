@extends('layouts.app')
@section('content')
    <main>
        <section class="PageProD pt-4">
            <div class="container">
                <x-breadcrumb :lists="$breadcrumb = [$product->title => url()->current()]" />
                <div class="row row-gap-4">
                    <div class="col-xl-6 col-lg-5">
                        <div class="me-xl-4 me-xxl-5 SlideBox">
                            <div class="swiper Slide">
                                <div class="swiper-wrapper">
                                    @foreach ($images as $image)
                                        <a href="{{ \Image::showFile('product', 1000, $image->image) }}"
                                            data-fancybox="gallery" class="swiper-slide">
                                            <x-image-preview fetchpriority="low" loading="lazy" class="w-100 MainSlide"
                                                imagepath="product" width="800" height="800" :image="$image->image ?? ''" />
                                        </a>
                                    @endforeach
                                </div>
                                <div class="swiper-button">
                                    <span class="swiper-button-prev"></span>
                                    <span class="swiper-button-next"></span>
                                </div>
                                <a role="button" data-bs-toggle="dropdown" aria-expanded="true"
                                    class="SharePostI BtnOth m-0"><svg viewBox="0 0 21 16">
                                        <path d="M13,10C1,10,1,15,1,15S0,5,13,5V1l7,7-7,7Z" />
                                    </svg></a>
                                <div class="SharePost dropdown-menu notbg py-0">
                                    <div id="social-links">
                                        <ul>
                                            <li><a href="https://www.instagram.com/" target="_blank"
                                                    class="social-button"><span class="fab fa-instagram"></span></a></li>
                                            <li><a href="https://www.facebook.com/" target="_blank"
                                                    class="social-button"><span class="fab fa-facebook-f"></span></a></li>
                                            <!-- <li><a href="https://www.tiktok.com/" target="_blank" class="social-button"><span class="fab fa-tiktok"></span></a></li> -->
                                            <li><a href="https://twitter.com/" target="_blank" class="social-button"><span
                                                        class="fab fa-twitter"></span></a></li>
                                            <li><a href="https://www.linkedin.com/" target="_blank"
                                                    class="social-button"><span class="fab fa-linkedin-in"></span></a></li>
                                            <li><a href="https://wa.me/" target="_blank" class="social-button"><span
                                                        class="fab fa-whatsapp"></span></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper SlideThum ms-lg-0">
                                <div class="swiper-wrapper">
                                    @foreach ($images as $image)
                                        <div class="swiper-slide">
                                            <x-image-preview fetchpriority="low" loading="lazy" class="w-100 MainSlide"
                                                imagepath="product" width="800" height="800" :image="$image->image ?? ''" />
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-7">
                        <h1 class="h3">{{ $product->title }}</h1>
                        <div class="small text-secondary">SKU : <span class="white">{{ $selectedvariant->sku }}</span>
                        </div>
                        <div class="d-flex flex-column gap-4 mt-3 border-top pt-3 border-secondary border-opacity-10">
                            <div class="d-flex flex-wrap gap-4 gap-xl-5">
                                <div
                                    class="flex-row gap-3 d-flex flex-wrap flex-lg-nowrap justify-content-between align-items-end">
                                    <div class="PriceBox d-flex flex-column gap-2">
                                        @if ($selectedvariant->stock < 1)
                                            <small class="text-danger fw-semibold text-u">Out of stock</small>
                                        @else
                                            <small class="text-success fw-semibold text-u">In stock</small>
                                        @endif
                                        <div class="Price fs-3 lh-1 font fw-semibold text-secondary">
                                            {{ \Content::Currency() }}{{ $selectedvariant->price }}
                                            <del class="fs-5 font text-secondary text-opacity-50 fw-medium">
                                                {{ \Content::Currency() }}{{ $selectedvariant->mrp }}
                                            </del>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex gap-5 flex-wrap">
                                    <div class="qut flex-row gap-3">
                                        <div class="d-flex flex-column gap-1">
                                            <span class="fw-semibold text-secondary small">Quantity</span>
                                            <div class="qut-box">
                                                <button class="fw-semibold" type="button"
                                                    onclick="decrement_quantity()">−</button>
                                                <input type="number" aria-label="Search" name="qty" id="qty"
                                                    value="1" oninput="maxLengthCheck(this)" maxlength="3">
                                                <button class="" type="button" onclick="increment_val()">✛</button>
                                            </div>
                                        </div>
                                        @if ($selectedvariant->stock > 0)
                                            <span class="small">Available quantity {{ $selectedvariant->stock }} pcs</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="flex-row gap-3">
                                <span class="fw-semibold text-secondary small">Select Colors</span>
                                <div class="Colors ms-1 mt-2">
                                    @foreach ($colors as $color)
                                        @php $checkColorExists = \App\Models\ProductVariant::whereProductId($product->id)->whereColorId($color->id)->whereVariantId($selectedvariant->variant_id)->exists(); @endphp

                                        <div class="cbtn sws-bounce sws-top {{ !$checkColorExists ? 'opacity-50' : '' }} "
                                            @if (!$checkColorExists) style="cursor:no-drop" @endif
                                            data-title="{{ $color->name }}">
                                            <input class="cbtn-check btn-check" type="radio" name="colors"
                                                id="colors{{ $color->id }}" @checked($selectedcolor->id == $color->id)>
                                            <label class="cbtn-label"
                                                @if (!$checkColorExists) style="background:{{ $color->hex }};border: solid 1px white; pointer-events: none"
                                                @else style="background:{{ $color->hex }}" @endif
                                                onclick="redirectUrl('{{ route('category', ['category' => $product->alias . '/p/' . $color->alias, 'pid' => $selectedvariant->variant_id]) }}')"
                                                for="colors{{ $color->id }}" role="button"></label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="flex-row gap-3">
                                <span class="fw-semibold text-secondary small">Select Dimensions</span>
                                <div class="Sizes ms-1 mt-2">
                                    @foreach ($sizes as $size)
                                        @php $checkSizeExists = \App\Models\ProductVariant::whereProductId($product->id)->whereColorId($selectedcolor->id)->whereVariantId($size->variant_id)->exists(); @endphp
                                        <div class="sizebtn {{ !$checkSizeExists ? 'opacity-50' : '' }} "
                                            @if (!$checkSizeExists) style="cursor:no-drop" @endif>
                                            <input class="sizebtn-check btn-check" type="radio" name="sizes"
                                                id="sizes{{ $size->id }}" @checked($selectedvariant->variant_id == $size->variant_id)>
                                            <label class="sizebtn-label" for="sizes{{ $size->id }}"
                                                @if (!$checkSizeExists) style="border: dashed 1px red; pointer-events: none" @endif
                                                onclick="redirectUrl('{{ route('category', ['category' => $product->alias . '/p/' . $selectedcolor->alias, 'pid' => $size->variant_id]) }}')"
                                                role="button">{{ $size->variantInfo->title ?? '' }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="flex-row gap-3">
                                <lable for="finish" class="fw-semibold text-secondary small m-0">Select Finishing
                                </lable>
                                <select name="finish" id="finish" class="form-select">
                                    <?php $finish = ['Matte Black','Glossy Black','Matte White','Glossy White','Satin Nickel','Brushed Nickel','Chrome / Polished Chrome','Antique Brass','Brushed Brass / Satin Brass','Gold / Champagne Gold','Copper / Rose Gold','Oil-Rubbed Bronze','Pewter','Gunmetal Grey','Wood Finish / Teak / Walnut','Crystal / Glass Clear','Frosted Glass','Smoked Glass / Grey Glass','Textured / Hammered Finish','Custom RAL Color (Powder Coated)'];
                  foreach($finish as $k=>$finishs) { ?>
                                    <option value="<?= $finishs ?>"><?= $finishs ?></option>
                                    <?php }?>
                                </select>
                            </div>
                            <div
                                class="btnn border-top border-bottom border-secondary border-opacity-10 Usp d-flex gap-4 py-3 justify-content-between align-items-center">
                                <div><img src="img/sild.svg" height="32" width="32" alt="warranty"><span>warranty
                                        <strong>2 Years</strong></span></div> |
                                <div><img src="img/repost.svg" height="32" width="32"
                                        alt="Replacements"><span>Hassle-Free <strong>Replacements</strong></span></div> |
                                <div><img src="img/support.svg" height="32" width="32"
                                        alt="Support"><span>Dedicated <strong>Support</strong></span></div>
                            </div>
                            <div class="btnn position-sticky py-2">
                                <span class="lh-sm">
                                    <small class="d-block">Connect Now for This Product!</small>
                                    <a href="tel:+919898989898" class="fw-medium fs-4">(+91)-989 898 9898</a>
                                </span>
                                <span class="d-flex gap-3">
                                    <a href="#RequestAQuote" data-bs-toggle="modal" aria-expanded="false"
                                        aria-controls="SendM" class="btn btn-thm m-0 Buy fw-medium gap-1 px-3"><svg
                                            viewBox="0 0 26 18">
                                            <path d="M1,1H25V17H1ZM22,4l-9,7L4,4" />
                                        </svg> Send Enquiry</a>
                                    @if(!empty($product->brochure_doc))
                                    <span class="sws-top sws-bounce" data-title="Download Brochure"><a href="{{ \Image::showFile('product/brochure', 0, $product->brochure_doc) }}" download
                                            class="btn btn-o-thm1 m-0 AddCart OnlyIcon h-100"><svg viewBox="0 0 19 20">
                                                <path d="M10,1V18m7-7-7,7L2,11M1,19H18" />
                                            </svg></a></span>
                                    @endif
                                    @if(!empty($product->technical_doc))
                                    @php $bExplode = explode('.',$product->technical_doc); @endphp
                                    <span class="sws-top sws-bounce" data-title="Technical Data">
                                        <a href="{{ \Image::showFile('product/technical', 0, $product->technical_doc) }}" target="_blank"
                                            class="btn btn-thm1 m-0 Noar OnlyIcon {{end($bExplode)}} h-100">
                                        </a>
                                    </span>
                                    @endif
                                </span>
                            </div>

                            @if(strlen(strip_tags($product->specification)) > 0 )
                            <div class="Des d-flex flex-column gap-2">
                                <span class="fw-semibold text-secondary">Specifications</span>
                                <div class="CmsPage text">
                                    {!! $product->specification !!}
                                </div>
                            </div>
                            @endif
                            
                            <div class="Des d-flex flex-column gap-2">
                                <span class="fw-semibold text-secondary">Description</span>
                                <div class="text">{!! $product->description !!}</div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="PageProD pt-0">
            <div class="container">
                <h2 class="h3">Gallery / Applications</h2>
                <div id="galleryPnV" class="galleryPnV">
                    <ul class="nav nav-pills Rlink">
                        <li class="nav-item">
                            <a class="nav-link active" href="#gallery">Photos <small>(15)</small></a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" href="#video">Video Book</a>
                        </li>
                    </ul>
                    <div id="gallery">
                        <div class="row ListPhoto row-gap-3">
                            <?php for($j=1; $j<=12;$j++) { ?>
                            <div class="col-lg-3 col-sm-4 col-6">
                                <a href="img/proimg/<?= $j ?>.jpg" data-fancybox="photo"
                                    class="card photo border border-dark shadow">
                                    <div class="card-body p-0">
                                        <picture>
                                            <source srcset="img/proimg/<?= $j ?>.webp" type="image/webp">
                                            <img fetchpriority="low" loading="lazy" src="img/proimg/<?= $j ?>.jpg"
                                                alt="img<?= $j ?>" width="200" height="200">
                                        </picture>
                                    </div>
                                </a>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div id="video" class="mt-4">
                        <h3 class="h4">Videos</h3>
                        <div class="row ListVideo row-gap-3">
                            <?php $Video = [['title'=>'Video Name','url'=>'V2zpLzoJBuQ',],
            ['title'=>'Video Name','url'=>'eEY50BOF0wM',],
            ['title'=>'Video Name','url'=>'hNN9Q3GuWEM',],];
            foreach ($Video as $k=>$Videos) { ?>
                            <div class="col-lg-3 col-md-4 col-6">
                                <a href="https://www.youtube.com/watch?v=<?= $Videos['url'] ?>" data-fancybox="video"
                                    class="card photo border border-dark shadow" data-caption="<?= $Videos['title'] ?>">
                                    <div class="card-body p-0">
                                        <picture>
                                            <source
                                                srcset="https://img.youtube.com/vi_webp/<?= $Videos['url'] ?>/sddefault.webp"
                                                type="image/webp">
                                            <img fetchpriority="low" loading="lazy"
                                                src="https://img.youtube.com/vi/<?= $Videos['url'] ?>/sddefault.jpg"
                                                alt="<?= $Videos['url'] ?>" height="200" width="200">
                                        </picture>
                                    </div>
                                </a>
                                <div class="title mt-2 fw-medium text-center"><?= $Videos['title'] ?></div>
                            </div>
                            <?php } ?>
                        </div>

                    </div>
                </div>
            </div>
        </section>
        <section class="grey">
            <div class="container row row-gap-md-4 row-gap-3 justify-content-between">
                <div class="col-md-auto">
                    <h2 class="Heading">Related Designs Products</h2>
                </div>
                <div class="col-12 order-md-last">
                    <div class="ProDuct swiper">
                        <div class="swiper-wrapper">
                            <?php for($pro=1; $pro<=6; $pro++) { ?>
                            <a href="product-detail.php" class="shadow-none card ProBlock swiper-slide">
                                <div class="card-header">
                                    <div class="proimg">
                                        <picture>
                                            <source srcset="img/proimg/<?= $pro ?>.webp" type="image/webp">
                                            <img loading="lazy" fetchpriority="low" src="img/proimg/<?= $pro ?>.jpg"
                                                alt="pro-proimg/<?= $pro ?>" width="300" height="300">
                                        </picture>
                                    </div>
                                </div>
                                <div class="card-body text-center">
                                    <h3 class="h4 m-0 text-u" title="Product Name">Product Name</h3>
                                    <span class="small">Z1100-310-4</span>
                                </div>
                            </a>
                            <?php }?>
                        </div>
                    </div>
                </div>
                <div class="col-auto d-flex gap-2 align-items-end">
                    <div class="swiper-button d-md-flex d-none h-auto">
                        <div class="swiper-button-prev pro-prev"></div>
                        <div class="swiper-button-next pro-next"></div>
                    </div>
                </div>
            </div>
        </section>
        <section>
            <div class="container row row-gap-md-4 row-gap-3 justify-content-between">
                <div class="col-md-auto">
                    <h2 class="Heading">Recent View Products</h2>
                </div>
                <div class="col-12 order-md-last">
                    <div class="ProDuct swiper">
                        <div class="swiper-wrapper">
                            <?php for($pro=1; $pro<=6; $pro++) { ?>
                            <a href="product-detail.php" class="shadow-none card ProBlock swiper-slide">
                                <div class="card-header">
                                    <div class="proimg">
                                        <picture>
                                            <source srcset="img/proimg/<?= $pro ?>.webp" type="image/webp">
                                            <img loading="lazy" fetchpriority="low" src="img/proimg/<?= $pro ?>.jpg"
                                                alt="pro-proimg/<?= $pro ?>" width="300" height="300">
                                        </picture>
                                    </div>
                                </div>
                                <div class="card-body text-center">
                                    <h3 class="h4 m-0 text-u" title="Product Name">Product Name</h3>
                                    <span class="small">Z1100-310-4</span>
                                </div>
                            </a>
                            <?php }?>
                        </div>
                    </div>
                </div>
                <div class="col-auto d-flex gap-2 align-items-end">
                    <div class="swiper-button d-md-flex d-none h-auto">
                        <div class="swiper-button-prev pro-prev"></div>
                        <div class="swiper-button-next pro-next"></div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
@push('css')
    <x-meta :options="[
        'imgpath' => 'products',
        'img' => '',
        'title' => $product->meta_title ?? $product->title,
        'keywords' => $product->meta_keywords ?? $product->title,
        'description' => $product->meta_description ?? $product->title,
        'breadcrumb' => $breadcrumb ?? '',
    ]" />
    <link rel="stylesheet" href="{{ \App\Enums\Url::CSS }}shop.min.css" fetchpriority="high">
    <link rel="preload" as="style" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/11.0.5/swiper-bundle.min.css"
        onload="this.rel='stylesheet'" fetchpriority="high"
        integrity="sha512-rd0qOHVMOcez6pLWPVFIv7EfSdGKLt+eafXh4RO/12Fgr41hDQxfGvoi1Vy55QIVcQEujUE1LQrATCLl2Fs+ag=="
        crossorigin="anonymous" referrerpolicy="no-referrer">
@endpush
@push('js')
    <div class="modal CallBack fade" id="RequestAQuote" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="RequestAQuote" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body justify-content-center p-0">
                    <div
                        class="bg-dark text-center m-4 mx-0 d-none d-md-flex align-items-center flex-column gap-2 justify-content-center">

                        <x-image-preview fetchpriority="low" loading="lazy" class="w-100" imagepath="product"
                            width="800" height="800" :image="$images[0]->image ?? ''" />
                        <div class="mb-3">
                            <h3 class="h5 m-0 fw-bold">{{ $product->title }}</h3>
                        </div>
                    </div>
                    <form class="bgthm rounded-3 shadow-lg p-4 d-flex flex-column gap-3" method="POST" action="mail.php"
                        enctype="multipart/form-data">
                        <input type="hidden" name="contact" value="yes">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        <h2 class="h5 text-center fw-bold text-u m-0 lh-1">Get a Quote</h2>
                        <div>
                            <label for="OName" class="form-label small lh-1 m-0 small">Your Name<span
                                    class="text-danger">*</span></label>
                            <input class="form-control border-dark-subtle" id="OName" name="Name" type="text"
                                placeholder="Anil Kumar" onkeypress="return /[a-z ]/i.test(event.key)" maxlength="30">
                        </div>
                        <div>
                            <label for="Ocontact" class="form-label small lh-1 m-0 small">Your Contact No.<span
                                    class="text-danger">*</span></label>
                            <input class="form-control border-dark-subtle" id="Ocontact" name="Name" type="tel"
                                placeholder="9898989898" onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                                maxlength="10">
                        </div>

                        <div>
                            <label for="OEmail" class="form-label small lh-1 m-0 small">Your Email ID<span
                                    class="text-danger">*</span></label>
                            <input class="form-control border-dark-subtle" id="OEmail" name="Email" type="email"
                                placeholder="info@yourdomain.com" onkeypress="return /[a-zA-z0-9@_.-]/i.test(event.key)"
                                maxlength="30">
                        </div>
                        <div>
                            <label for="OMessage" class="form-label m-0 small">Message</label>
                            <textarea class="form-control border-dark-subtle" id="OMessage" name="Message"></textarea>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-black mt-0 gap-2">Submit</button>
                            <div class="mt-2 small text-white"><small>By clicking Submit, I accept the <a href="#"
                                        class="text-black">T&C</a> and <a href="#" class="text-black">Privacy
                                        Policy</a>.</small></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <link rel="preload" as="style" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css"
        fetchpriority="low" onload="this.rel='stylesheet'">
    <link rel="preload" as="style" href="https://pro.fontawesome.com/releases/v5.15.4/css/all.css"
        onload="this.rel='stylesheet'" fetchpriority="low" crossorigin="anonymous">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/11.0.5/swiper-bundle.min.js"
        integrity="sha512-Ysw1DcK1P+uYLqprEAzNQJP+J4hTx4t/3X2nbVwszao8wD+9afLjBQYjz7Uk4ADP+Er++mJoScI42ueGtQOzEA=="
        fetchpriority="low" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js" fetchpriority="low"></script>
    <script>
        Fancybox.bind('[data-fancybox]', {});
        var SlideThum = new Swiper(".SlideThum", {
            spaceBetween: 5,
            slidesPerView: 'auto',
            breakpoints: {
                '992': {
                    spaceBetween: 2,
                    slidesPerView: 6,
                }
            }
        });
        var Slide = new Swiper(".Slide", {
            spaceBetween: 20,
            centeredSlides: true,
            loop: true,
            thumbs: {
                swiper: SlideThum,
            },
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev"
            },
        });

        function redirectUrl(reUrl) {
            window.location.href = reUrl;
        }

        const ProCatSlider = () => {
            let ProDuct = document.querySelectorAll('.ProDuct')
            let prevPro = document.querySelectorAll('.pro-prev')
            let nextPro = document.querySelectorAll('.pro-next')
            ProDuct.forEach((slider, index) => {
                let result = (slider.children[0].children.length > 1) ? true : false
                const swiper = new Swiper(slider, {
                    spaceBetween: 20,
                    slidesPerView: 1,
                    navigation: {
                        nextEl: nextPro[index],
                        prevEl: prevPro[index]
                    },
                    breakpoints: {
                        '280': {
                            slidesPerView: 1,
                            spaceBetween: 8
                        },
                        '450': {
                            slidesPerView: 1.5,
                            spaceBetween: 12
                        },
                        '575': {
                            slidesPerView: 2,
                            spaceBetween: 15
                        },
                        '768': {
                            slidesPerView: 2.5
                        },
                        '992': {
                            slidesPerView: 3
                        }
                    }
                });
            })
        }
        window.addEventListener('load', ProCatSlider);
    </script>
@endpush
