<form class="pt-0 row g-2" wire:submit.prevent="SaveForm" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="mb-2 col-md-12">
            <x-admin.form.label for="serviceTitle" class="form-label" :asterisk="true" title="Service" />
            <x-admin.form.input name="serviceTitle" type="text" :options="['placeholder' => 'Enter Service Here...', 'readonly' => true, 'class' => 'otherValidation']" />
            <x-admin.form.invalid-error errorFor="serviceTitle" />
        </div>
        <div class="col-md-4 mt-2 relative">
            <x-admin.form.label for="selectedCompany" class="form-label" :asterisk="true" title="Company" />
            <input type="text" class="form-control" placeholder="Search for a company..." wire:model.live="query" />
            @if (!empty($companies))
                <ul class="list-group position-absolute" style="z-index: 10;">
                    @foreach ($companies as $company)
                        <li class="list-group-item list-group-item-action"
                            wire:click="selectCompany({{ $company->id }})" style="cursor: pointer;">
                            {{ $company->name }} (#{{ $company->userInfo->user_id ?? '' }})
                        </li>
                    @endforeach
                </ul>
            @endif
            <x-admin.form.invalid-error errorFor="selectedCompany" />
        </div>

        <div class="col-md-3 mt-2">
            <div wire:ignore class="col-md d-flex mt-2 flex-column align-items-center justify-content-center">

                <div class=" counter-wrapper">
                    <span class="fw-medium">Rating :</span>
                    <span class="counter">{{ $rating }}</span>
                </div>
                <div class="onChange-event-ratings raty mb-2" data-score="0" data-number="5" data-half="true"></div>
            </div>
            <x-admin.form.invalid-error errorFor="rating" />
        </div>

        <div class="col-md-12 mt-2">
            <x-admin.form.label for="description" class="form-label" :asterisk="true" title="Description / Message" />
            <x-admin.form.text-editor name="description" :editorOptions="['id' => 'description', 'placeholder' => 'Write Something Here...', 'value' => $description]" />
            <x-admin.form.invalid-error errorFor="description" />
        </div>
        <div wire:loading wire:target="images" class="col-12 my-5 text-center">
            <div class="spinner-border" style="width: 20px;height:20px;font-size:10px;" role="status"></div>
            Uploading...
        </div>
        <div wire:loading.remove wire:target="images" class="col-5 my-3">
            <x-admin.form.label for="images" class="formFile form-label" :asterisk="false"
                title="Best Image  900px * 900px <small class='text-secondary'>(You can`t upload more than 6 images)</small>" />
            <x-admin.form.input name="images" type="file" :options="['accept' => 'image/*', 'multiple' => true]" />
            <x-admin.form.invalid-error errorFor="images" />
        </div>

        <div wire:loading.remove wire:target="images" class="row">
            @foreach ($info->images as $img)
                <div drag-item="{{ $img->id }}" draggable="true" wire:key="img{{ $img->id }}"
                    class="col-2 my-3 {{ $img->is_primary == 1 ? 'setPrimary' : 'notPrimary' }}"
                    style="position: relative">
                    <div>
                        <x-image-preview :options="['class' => 'defaultimg w-100', 'id' => 'blah']" imagepath="service/rating" :image="$img->image" />
                    </div>
                    <a role="button" wire:click="removeImage({{ $img->id }})"
                        class="btn rounded-pill btn-icon btn-label-danger"><i class="fa fa-times"></i></a>
                    @if ($img->is_primary == 1)
                        <a role="button" class="btn rounded-pill btn-icon btn-success text-white"><i
                                class="fas fa-check"></i></a>
                        <div class="badge bg-label-primary w-100 mt-2">
                            Primary
                        </div>
                    @endif
                </div>
            @endforeach
            @if ($images)
                @foreach ($images as $key => $image)
                    <div class="col-2 my-3 {{ !empty($image->primary_image) && $image->primary_image ? 'setPrimary' : 'notPrimary' }}"
                        style="position: relative">
                        @if (in_array($image->getMimeType(), \CommanFunction::getSupportedFiles(\App\Enums\ButtonText::SUPPORTEDIMAGE)))
                            <img src="{{ $image->temporaryUrl() }}" class="defaultimg w-100">
                        @else
                            <x-image-preview :options="['class' => 'defaultimg w-100', 'id' => 'blah']" imagepath="" image="" />
                        @endif
                        <x-admin.form.invalid-error errorFor="images.{{ $key }}" />
                        <a role="button" wire:click="eliminarImage({{ $key }})"
                            class="btn rounded-pill btn-icon btn-label-danger"><i class="fa fa-times"></i></a>
                        <a role="button" class="btn rounded-pill btn-icon btn-success text-white"><i
                                class="fas fa-check"></i></a>
                        <div class="badge bg-label-primary w-100 mt-2">
                            Primary
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
        <x-admin.form.save-button buttonName="{{ \App\Enums\ButtonText::UPDATE }}" target="images" />
    </div>

</form>
@push('js')
    <script src="{{ asset('admin/assets/vendor/libs/rateyo/rateyo.js') }}"></script>
    {{-- <script src="{{ asset('admin/assets/js/extended-ui-star-ratings.js') }}"></script> --}}
    <script>
        $(function() {
            let rateYo = $(".onChange-event-ratings");
            rateYo.rateYo({
                rating: @json($rating),
                rtl: isRtl
            });
            rateYo.on("rateyo.set", function(t, r) {
                r = r.rating;
                $(this).parent().find(".counter").text(r);
                Livewire.dispatch('setRating', {
                    rating: r
                });
            });
        });


    </script>
@endpush
