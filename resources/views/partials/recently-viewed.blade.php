@if ($recentProducts->isNotEmpty())
    <section>
        <div class="container row row-gap-md-4 row-gap-3 justify-content-between">
            <div class="col-md-auto">
                <h2 class="Heading">Recent View Products</h2>
            </div>
            <div class="col-12 order-md-last">
                <div class="ProDuct swiper">
                    <div class="swiper-wrapper">
                        @foreach ($recentProducts as $recent)
                            @livewire('product-box', ['product' => $recent,'class'=>'swiper-slide'], key('REC-'.$recent->id))
                        @endforeach
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


@endif
