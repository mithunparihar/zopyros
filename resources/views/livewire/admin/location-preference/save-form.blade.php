<form class="pt-0 g-2" wire:submit.prevent="SaveForm" enctype="multipart/form-data">
    @csrf
    <div class="card p-3 mt-2">
        <div class="row">
            <div class="col-md-12 mb-2">
                <x-admin.form.label for="title" class="form-label" :asterisk="true">Name / Title</x-admin.form.label>
                <x-admin.form.input name="title" wire:model="title" type="text" placeholder="Enter Title Here..."
                    @class(['otherValidation', 'is-invalid' => $errors->has('title')]) />
                @error('title')
                    <x-admin.form.invalid-error>{{ $message }}</x-admin.form.invalid-error>
                @enderror
            </div>
        </div>
    </div>
    @if ($parent == 0)
        <div class="card p-3 mt-2">
            <div class="row">
                <div class="col-md-12 mt-2">
                    <x-admin.form.label for="description" class="form-label"
                        :asterisk="false">Description</x-admin.form.label>
                    <x-admin.form.text-editor name="description" ignore="true" class="summernote" wire:model="description" />
                    @error('description')
                        <x-admin.form.invalid-error>{{ $message }}</x-admin.form.invalid-error>
                    @enderror
                </div>

                <div class="col-4 mt-3">
                    <x-admin.form.label for="formFile" class="formFile form-label" :asterisk="false">
                        Best Image  600px * 600px
                    </x-admin.form.label>
                    <x-admin.form.input name="image" wire:model="image" type="file" accept='image/*' />
                    @error('image')
                        <x-admin.form.invalid-error>{{ $message }}</x-admin.form.invalid-error>
                    @enderror
                </div>
                <div class="col-2 mt-3">
                    @if ($image)
                        @if (in_array($image->getMimeType(), \CommanFunction::getSupportedFiles(\App\Enums\ButtonText::SUPPORTEDIMAGE)))
                            <img src="{{ $image->temporaryUrl() }}" class="defaultimg">
                        @endif
                    @else
                        <x-image-preview class="defaultimg" imagepath="location-preference" image="" />
                    @endif
                </div>

                <div class="mb-1 col-md-12">
                    <x-admin.form.label for="meta_title" class="form-label" :asterisk="false">Meta
                        Title</x-admin.form.label>
                    <x-admin.form.input name="meta_title" type="text" wire:model="meta_title"
                        placeholder='Write something here...' @class([
                            'otherValidation',
                            'is-invalid' => $errors->has('meta_title'),
                        ]) />
                    @error('meta_title')
                        <x-admin.form.invalid-error>{{ $message }}</x-admin.form.invalid-error>
                    @enderror
                </div>
                <div class="col-md-12 mt-2">
                    <x-admin.form.label for="meta_keywords" class="form-label" :asterisk="false">Meta
                        Keywords</x-admin.form.label>
                    <x-admin.form.text-editor name="meta_keywords" wire:model="meta_keywords"
                        placeholder='Write something here...' @class([
                            'otherValidation',
                            'is-invalid' => $errors->has('meta_keywords'),
                        ]) />
                    @error('meta_keywords')
                        <x-admin.form.invalid-error>{{ $message }}</x-admin.form.invalid-error>
                    @enderror
                </div>
                <div class="col-md-12 mt-2">
                    <x-admin.form.label for="meta_description" class="form-label" :asterisk="false">Meta
                        Description</x-admin.form.label>
                    <x-admin.form.text-editor name="meta_description" wire:model="meta_description"
                        placeholder='Write something here...' @class([
                            'otherValidation',
                            'is-invalid' => $errors->has('meta_description'),
                        ]) />
                    @error('meta_description')
                        <x-admin.form.invalid-error>{{ $message }}</x-admin.form.invalid-error>
                    @enderror
                </div>
            </div>
        </div>
    @endif
    <div class="card mt-2 position-sticky  bottom-0" style="box-shadow:0 -4px 6px -6px rgb(0 0 0/.3);">
        <div class="row">
            <div class="col-12">
                <x-admin.form.save-button class="py-3 text-center" target="SaveForm">
                    {{ \App\Enums\ButtonText::SAVE }}
                </x-admin.form.save-button>
            </div>
        </div>
    </div>
</form>
