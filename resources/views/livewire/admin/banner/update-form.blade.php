<form class="pt-0 g-2" wire:submit.prevent="UpdateForm" enctype="multipart/form-data">
    @csrf
    <div class="card p-3 mt-2">
        <div class="row">
            <div class="mb-2 col-md-12">
                <x-admin.form.label class="form-label" for="image_alt" :asterisk="true">Image Alt</x-admin.form.label>
                <x-admin.form.input @class(['otherValidation', 'is-invalid' => $errors->has('image_alt')]) wire:model="image_alt" placeholder="Image Alt Here..."
                    type="text" />
                @error('image_alt')
                    <x-admin.form.invalid-error>{{ $message }}</x-admin.form.invalid-error>
                @enderror
            </div>
            <div class="mb-2 col-md-12">
                <x-admin.form.label class="form-label" for="link" :asterisk="false">Banner Link</x-admin.form.label>
                <x-admin.form.input @class(['otherValidation', 'is-invalid' => $errors->has('link')]) wire:model="link" placeholder="Banner Link Here..."
                    type="text" />
                @error('link')
                    <x-admin.form.invalid-error>{{ $message }}</x-admin.form.invalid-error>
                @enderror
            </div>
        </div>
    </div>

    <div class="card p-3 mt-2">
        <div class="row">
            <div class="col-4 mt-2">
                <x-admin.form.label for="formFile" class="formFile form-label" asterisk="false">
                    Best Image <small>(1000px * 800px)</small>
                </x-admin.form.label>
                <x-admin.form.input name="image" @class(['is-invalid' => $errors->has('image')]) wire:model="image" type="file"
                    accept="video/mp4" />
                @error('image')
                    <x-admin.form.invalid-error>{{ $message }}</x-admin.form.invalid-error>
                @enderror
            </div>
            <div wire:loading.flex wire:target="image"
                class="col-2 mt-3 border defaultimg justify-content-center align-items-center">
                <span class="spinner-border"></span>
            </div>
            <div wire:loading.remove wire:target="image" class="col-2 mt-3">
                @if ($image)
                    @if (in_array($image->getMimeType(), \CommanFunction::getSupportedFiles(\App\Enums\ButtonText::SUPPORTEDIMAGE)))
                        <img src="{{ $image->temporaryUrl() }}" class="defaultimg">
                    @endif
                @else
                    <x-image-preview id="blah2" class="defaultimg" imagepath="banner" width="150"
                        :image="$info->image" />
                @endif
            </div>
        </div>
    </div>


    <div class="card mt-2 position-sticky  bottom-0" style="box-shadow:0 -4px 6px -6px rgb(0 0 0/.3);">
        <div class="row">
            <div class="col-12">
                <x-admin.form.save-button class="py-3 text-center" target="images,UpdateForm">
                    {{ \App\Enums\ButtonText::UPDATE }}
                </x-admin.form.save-button>
            </div>
        </div>
    </div>
</form>
