<div class="offcanvas offcanvas-start" data-bs-scroll="false" id="FilterBar" tabindex="-1">
    <div class="d-flex justify-content-between d-lg-none py-2 mb-2 fw-bold text-u position-sticky top-0 fs-5 z-3"><span
            class="d-flex align-items-center gap-2">Filter <button class="Refresh" title="Refresh"><svg viewBox="0 0 38 29">
                    <polyline points="13 9 5 13 1 5" />
                    <polyline points="25 22 33 18 37 26" />
                    <path d="M5,18a15,19,0,0,0,28,0" />
                    <path d="M33,13A15,19,0,0,0,5,13" />
                </svg></button></span> <button type="button" class="btn-close d-md-none" data-bs-dismiss="offcanvas"
            aria-label="Close"></button></div>
    <div class="offcanvas-body" id="allFilter">
        <div class="FilterOp">
            <a data-bs-toggle="collapse" class="collapsed" id="Locality" href="#Location" aria-expanded="false"
                aria-controls="Location">Price Range</a>
            <div id="Location" class="collapse" aria-labelledby="Locality" data-bs-parent="#allFilter">
                <div class="ullist">
                    <div class="price-filter">
                        <div class="slider-container">
                            <input type="range" id="minRange" min="0" max="10000" step="100"
                                value="0">
                            <input type="range" id="maxRange" min="0" max="10000" step="100"
                                value="10000">
                        </div>
                        <div class="range-values">&#8377; <span id="minVal">0</span> – &#8377; <span
                                id="maxVal">10000</span></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="FilterOp">
            <a data-bs-toggle="collapse" class="collapsed" id="ProSpaces" href="#Spaces" aria-expanded="false"
                aria-controls="Spaces">Spaces</a>
            <div id="Spaces" class="collapse" aria-labelledby="ProSpaces" data-bs-parent="#allFilter">
                <div class="ullist">
                    <?php $Space = [['size'=>'Bedroom','num'=>'23'],
          ['size'=>'Living Room','num'=>'46'],
          ['size'=>'Dining Room','num'=>'21'],
          ['size'=>'Kitchen','num'=>'62'],
          ['size'=>'Entry Foyer','num'=>'12'],
          ['size'=>'Stairways','num'=>'12'],
          ['size'=>'Study Room','num'=>'12']];
            foreach ($Space as $g=>$Spaces) {?>
                    <label class="form-check form-check-label lh-normal">
                        <span>
                            <input class="form-check-input border-black border-opacity-50" type="checkbox"
                                value="" id="Gues<?= $g ?>"> <?= $Spaces['size'] ?>
                        </span>
                        <span><?= $Spaces['num'] ?></span>
                    </label>
                    <?php } ?>
                </div>
            </div>
        </div>
        <div class="FilterOp">
            <a data-bs-toggle="collapse" class="collapsed" id="Prosize" href="#size" aria-expanded="false"
                aria-controls="size">Product Size</a>
            <div id="size" class="collapse" aria-labelledby="Prosize" data-bs-parent="#allFilter">
                <div class="ullist">
                    <?php $size = [['size'=>'Medium','num'=>'23'],
          ['size'=>'Large','num'=>'46'],
          ['size'=>'Double Height','num'=>'12']];
            foreach ($size as $g=>$sizes) {?>
                    <label class="form-check form-check-label lh-normal">
                        <span>
                            <input class="form-check-input border-black border-opacity-50" type="checkbox"
                                value="" id="size<?= $g ?>"> <?= $sizes['size'] ?>
                        </span>
                        <span><?= $sizes['num'] ?></span>
                    </label>
                    <?php } ?>
                </div>
            </div>
        </div>
        <div class="FilterOp">
            <a data-bs-toggle="collapse" class="collapsed" id="Promaterial" href="#material" aria-expanded="false"
                aria-controls="material">Material</a>
            <div id="material" class="collapse" aria-labelledby="Promaterial" data-bs-parent="#allFilter">
                <div class="ullist">
                    <?php $material = [['size'=>'Metal','num'=>'23'],
          ['size'=>'Glass','num'=>'12']];
            foreach ($material as $g=>$materials) {?>
                    <label class="form-check form-check-label lh-normal">
                        <span>
                            <input class="form-check-input border-black border-opacity-50" type="checkbox"
                                value="" id="material<?= $g ?>"> <?= $materials['size'] ?>
                        </span>
                        <span><?= $materials['num'] ?></span>
                    </label>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>

@push('js')
    <script>
        const filterURL = "{{ url()->current() }}";
    </script>
    <script src="{{ asset('frontend/js/filter.js') }}"></script>
@endpush
