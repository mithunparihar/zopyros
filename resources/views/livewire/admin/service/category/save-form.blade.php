<form class="pt-0 g-2" wire:submit.prevent="SaveForm" enctype="multipart/form-data">
    @csrf
    <div class="card p-3 mt-2">
        <div class="row">
            <div class="mb-1 col-md-12">
                <x-admin.form.label for="title" class="form-label" :asterisk="true">Category Name</x-admin.form.label>
                <x-admin.form.input wire:model="title" type="text" @class(['otherValidation', 'is-invalid' => $errors->has('title')])
                    placeholder="Enter Category Name Here..." />
                @error('title')
                    <x-admin.form.invalid-error>{{ $message }}</x-admin.form.invalid-error>
                @enderror
            </div>

            <div class="col-md-12 mt-2">
                <x-admin.form.label for="short_description" class="form-label" :asterisk="false">Short
                    Description</x-admin.form.label>
                <x-admin.form.text-editor wire:model="short_description" placeholder="Write something here..." />
                @error('short_description')
                    <x-admin.form.invalid-error>{{ $message }}</x-admin.form.invalid-error>
                @enderror
            </div>

            <div class="col-md-12 mt-2">
                <x-admin.form.label for="description" class="form-label"
                    :asterisk="true">Description</x-admin.form.label>
                <x-admin.form.text-editor ignore="true" name="description" wire:model="description" id="description"
                    class="summernote">{{ $description }}</x-admin.form.text-editor>
                @error('description')
                    <x-admin.form.invalid-error>{{ $message }}</x-admin.form.invalid-error>
                @enderror
            </div>
        </div>
    </div>
    <div class="card p-3 mt-2">
        <div class="row">
            <div wire:loading wire:target="image" class="col-12 text-center my-3">
                <span class="spinner-border" style="width: 17px;height:17px;font-size:8px;"></span> Uploading...
            </div>
            <div wire:loading.remove wire:target="image" class="col-4">
                <x-admin.form.label for="formFile" class="formFile form-label" :asterisk="true">
                    Thumb Image <small>(Size: 250px * 250px)</small>
                </x-admin.form.label>
                <x-admin.form.input wire:model="image" type="file" accept='image/*' />
                @error('image')
                    <x-admin.form.invalid-error>{{ $message }}</x-admin.form.invalid-error>
                @enderror
            </div>
            <div wire:loading.remove wire:target="image" class="col-2">
                @if ($image)
                    @if (in_array($image->getMimeType(), \CommanFunction::getSupportedFiles(\App\Enums\ButtonText::SUPPORTEDIMAGE)))
                        <img src="{{ $image->temporaryUrl() }}" class="defaultimg">
                    @endif
                @endif
            </div>
        </div>
    </div>
    <div class="card p-3 mt-2">
        <div class="row">
            <div class="mb-1 col-md-12">
                <x-admin.form.label for="meta_title" class="form-label" :asterisk="false">Meta
                    Title</x-admin.form.label>
                <x-admin.form.input wire:model="meta_title" type="text" placeholder="Enter Meta Title Here..." @class([
                    'otherValidation',
                    'is-invalid' => $errors->has('meta_title'),
                ]) />
                @error('imameta_titlege')
                    <x-admin.form.invalid-error>{{ $message }}</x-admin.form.invalid-error>
                @enderror
            </div>
            <div class="col-md-12 mt-2">
                <x-admin.form.label for="meta_keywords" class="form-label" :asterisk="false">Meta
                    Keywords</x-admin.form.label>
                <x-admin.form.text-editor wire:model="meta_keywords" @class([
                    'otherValidation',
                    'is-invalid' => $errors->has('meta_keywords'),
                ])
                    placeholder="Write something here..." />
                @error('meta_keywords')
                    <x-admin.form.invalid-error>{{ $message }}</x-admin.form.invalid-error>
                @enderror
            </div>
            <div class="col-md-12 mt-2">
                <x-admin.form.label for="meta_description" class="form-label" :asterisk="false">Meta
                    Description</x-admin.form.label>
                <x-admin.form.text-editor wire:model="meta_description" @class([
                    'otherValidation',
                    'is-invalid' => $errors->has('meta_description'),
                ])
                    placeholder="Write something here..." />
                @error('meta_description')
                    <x-admin.form.invalid-error>{{ $message }}</x-admin.form.invalid-error>
                @enderror
            </div>
        </div>
    </div>
    <div class="card mt-2 position-sticky  bottom-0" style="box-shadow:0 -4px 6px -6px rgb(0 0 0/.3);">
        <div class="row">
            <div class="col-12">
                <x-admin.form.save-button class="py-3 text-center" target="images,SaveForm">
                    {{ \App\Enums\ButtonText::SAVE }}
                </x-admin.form.save-button>
            </div>
        </div>
    </div>
</form>
