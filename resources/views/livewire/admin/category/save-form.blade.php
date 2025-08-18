<form class="pt-0 g-2" wire:submit.prevent="SaveForm" enctype="multipart/form-data">
    @csrf

    <div class="card position-relative p-3 mt-2">
        <div class="row">
            <div class="mb-1 col-md-12">
                <x-admin.form.label for="title" class="form-label" :asterisk="true">Title</x-admin.form.label>
                <x-admin.form.input name="title" wire:model="title" type="text" placeholder='Enter Title Here...'
                    @class(['otherValidation', 'is-invalid' => $errors->has('title')]) />
                @error('title')
                    <x-admin.form.invalid-error>{{ $message }}</x-admin.form.invalid-error>
                @enderror
            </div>
            {{-- <div class="mb-1 col-md-12">
                <x-admin.form.label for="heading" class="form-label" :asterisk="false">Heading</x-admin.form.label>
                <x-admin.form.input name="heading" wire:model="heading" type="text"
                    placeholder='Enter Heading Here...' @class(['otherValidation', 'is-invalid' => $errors->has('heading')]) />
                @error('heading')
                    <x-admin.form.invalid-error>{{ $message }}</x-admin.form.invalid-error>
                @enderror
            </div> --}}
            <div class="col-md-12 mt-2">
                <x-admin.form.label for="short_description" class="form-label" :asterisk="false">
                    Short Description
                </x-admin.form.label>
                <x-admin.form.text-editor name="short_description" wire:model="short_description"
                    @class([
                        'otherValidation',
                        'is-invalid' => $errors->has('short_description'),
                    ]) placeholder="Write something here..." id="short_description" />
                <x-admin.form.invalid-error errorFor="short_description" />
            </div>
            <div class="col-md-12 mt-2">
                <x-admin.form.label for="description" class="form-label"
                    :asterisk="true">Description</x-admin.form.label>
                <x-admin.form.text-editor wire:model="description" ignore="true" class="summernote"
                    id="description">{{ $description }}</x-admin.form.text-editor>
                @error('description')
                    <x-admin.form.invalid-error>{{ $message }}</x-admin.form.invalid-error>
                @enderror
            </div>
        </div>
    </div>

    <div class="card p-3 mt-2">
        <div class="row align-items-center justify-content-center" wire:loading wire:target="image">
            <div class="col-12 text-center">
                <span class="spinner-border" style="width: 17px;height:17px;font-size:10px;"></span> Uploading...
            </div>
        </div>
        <div class="row" wire:loading.remove wire:target="image">
            <div class="col-4 mt-3">
                <x-admin.form.label for="formFile" class="formFile form-label" :asterisk="true">Best Image 600px *
                    600px</x-admin.form.label>
                <x-admin.form.input name="image" wire:model="image" @class(['is-invalid' => $errors->has('image')]) type="file"
                    accept='image/*' />
                @error('image')
                    <x-admin.form.invalid-error>{{ $message }}</x-admin.form.invalid-error>
                @enderror
            </div>
            <div class="col-2 mt-3">
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
                <x-admin.form.input wire:model="meta_title" type="text" placeholder='Meta Title Here...'
                    @class([
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
                <x-admin.form.text-editor wire:model="meta_keywords" id='meta_keywords' @class(['is-invalid' => $errors->has('meta_keywords')])
                    placeholder='Meta Keywords Here...' />
                @error('meta_keywords')
                    <x-admin.form.invalid-error>{{ $message }}</x-admin.form.invalid-error>
                @enderror
            </div>
            <div class="col-md-12 mt-2">
                <x-admin.form.label for="meta_description" class="form-label" :asterisk="false">Meta
                    Description</x-admin.form.label>
                <x-admin.form.text-editor wire:model="meta_description" id='meta_description'
                    @class(['is-invalid' => $errors->has('meta_description')]) placeholder='Meta Description Here...' />
                @error('meta_description')
                    <x-admin.form.invalid-error>{{ $message }}</x-admin.form.invalid-error>
                @enderror
            </div>
        </div>
    </div>

    {{-- <div class="col-md-12 mt-2">
            <div class="form-check">
                <input class="form-check-input" @checked($hide_information_page) wire:model="hide_information_page"
                    type="checkbox" value="1" id="defaultCheck3">
                <label class="form-check-label" for="defaultCheck3">
                    If you want to hide this category information page than checked this checkbox.
                </label>
            </div>
        </div> --}}

    <div class="card mt-2 position-sticky  bottom-0" style="box-shadow:0 -4px 6px -6px rgb(0 0 0/.3);">
        <div class="row">
            <div class="col-12">
                <x-admin.form.save-button class="py-3 text-center" target="image,icon,SaveForm">
                    {{ \App\Enums\ButtonText::SAVE }}
                </x-admin.form.save-button>
            </div>
        </div>
    </div>


</form>
@push('js')
    <script>
        document.addEventListener('livewire:init', function() {
            let select = $('#selectMultipleMaterial');
            select.select2();
            select.on('change', function() {
                @this.set('material', $(this).val());
            });
            Livewire.on('dataSaved', (message, component) => {
                select.val(null).trigger('change');;
            });
        });
    </script>
@endpush
