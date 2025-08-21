<form class="pt-0 g-2" wire:submit.prevent="SaveForm" enctype="multipart/form-data">
    @csrf
    <div class="row">

        <div wire:loading wire:target="images" class="col-12 my-5 text-center">
            <div class="spinner-border" style="width: 20px;height:20px;font-size:10px;" role="status"></div>
            Uploading...
        </div>
        <div wire:loading.remove wire:target="images" class="col-5 mb-5">
            <x-admin.form.label for="images" class="formFile form-label" :asterisk="true">
                Best Image 1000px * 1000px
            </x-admin.form.label>
            <x-admin.form.input wire:model="images" type="file" multiple accept="image/*" />
            <x-admin.form.invalid-error errorFor="images" />
        </div>

        <div drag-root wire:loading.remove wire:target="images" class="row Allimgs align-items-start">
            @foreach ($preimages as $img)
                <div drag-item="{{ $img->id }}" draggable="true" wire:key="img{{ $img->id }}"
                    class="col-2 {{ $img->is_primary == 1 ? 'setPrimary' : 'notPrimary' }}" style="position: relative">
                    {{-- <label class="switch" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $img->is_publish ? 'Disable' : 'Enable' }}">
                        <input type="checkbox" role="switch" wire:click="togglePublish({{$img->id}})" {{ $img->is_publish ? 'checked' : '' }}>
                        <span class="slider round"></span>
                    </label> --}}

                    <div class="form-check form-switch z-3 d-inline-block sws-bounce sws-top" data-title="{{ $img->is_publish==1?'Activated':'Deactivated' }}">
                        <input class="form-check-input" wire:click="togglePublish({{ $img->id }})"
                            @checked($img->is_publish) type="checkbox" id="browserDefaultSwitch" required="">
                        <label class="form-check-label" for="browserDefaultSwitch"></label>
                    </div>

                    <div>
                        <x-image-preview class="defaultimg w-100" id="blah" width="200" imagepath="clients"
                            :image="$img->image" />
                    </div>
                    <a data-title="Remove" role="button" wire:confirm="Are you sure! You want to remove this image."
                        wire:click="removeImage({{ $img->id }})"
                        class="btn rounded-pill sws-bounce sws-top btn-icon btn-label-danger"><i
                            class="fa fa-times"></i></a>

                    @if ($img->is_primary == 1)
                        <a role="button" class="btn rounded-pill btn-icon btn-success text-white"><i
                                class="fas fa-check"></i></a>
                        <div class="badge bg-label-primary w-100 mt-2">
                            Primary
                        </div>
                    @endif
                    {{-- <div class="sequenceBox">{{ $img->sequence }}</div> --}}
                </div>
            @endforeach

            @if ($images)
                @foreach ($images as $key => $image)
                    <div class="col-2 {{ !empty($image->primary_image) && $image->primary_image ? 'setPrimary' : 'notPrimary' }}"
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

    </div>
    {{-- <x-admin.form.save-button buttonName="{{ \App\Enums\ButtonText::UPDATE }}" target="images" /> --}}
</form>
