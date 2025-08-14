<form class="pt-0 g-2" wire:submit.prevent="SaveForm" enctype="multipart/form-data">
    @csrf
    <div class="card p-3 mt-2">
        <div class="row">
            <div class="mb-1 col-md-12">
                <x-admin.form.label for="title" class="form-label" :asterisk="true">Category Name</x-admin.form.label>
                <x-admin.form.input wire:model="title" type="text" placeholder='Category Name Here...'
                    @class(['otherValidation', 'is-invalid' => $errors->has('title')]) />
                @error('title')
                    <x-admin.form.invalid-error>{{ $message }}</x-admin.form.invalid-error>
                @enderror
            </div>
            <div class="mb-1 col-md-12">
                <x-admin.form.label for="heading" class="form-label" :asterisk="true">Page
                    Heading</x-admin.form.label>
                <x-admin.form.input wire:model="heading" type="text" placeholder='Heading Here...'
                    @class(['otherValidation', 'is-invalid' => $errors->has('heading')]) />
                @error('heading')
                    <x-admin.form.invalid-error>{{ $message }}</x-admin.form.invalid-error>
                @enderror
            </div>
            <div class="col-md-12 my-2">
                <x-admin.form.label for="description" class="form-label" :asterisk="true">Page
                    Description</x-admin.form.label>
                <x-admin.form.text-editor wire:model="description" ignore="true" id="description"
                    class="summernote">{{ $description }}</x-admin.form.text-editor>
                @error('description')
                    <x-admin.form.invalid-error>{{ $message }}</x-admin.form.invalid-error>
                @enderror
            </div>
        </div>
    </div>
    <div class="card mt-2 p-3">
        <div class="row">
            <div class="mb-1 col-md-12">
                <x-admin.form.label for="meta_title" class="form-label" :asterisk="false">Meta
                    Title</x-admin.form.label>
                <x-admin.form.input name="meta_title" type="text" @class([
                    'otherValidation',
                    'is-invalid' => $errors->has('meta_title'),
                ])
                    placeholder='Meta Title Here...' />
                @error('meta_title')
                    <x-admin.form.invalid-error>{{ $message }}</x-admin.form.invalid-error>
                @enderror
            </div>
            <div class="col-md-12 mt-2">
                <x-admin.form.label for="meta_keywords" class="form-label" :asterisk="false">Meta
                    Keywords</x-admin.form.label>
                <x-admin.form.text-editor name="meta_keywords" id='meta_keywords' @class([
                    'otherValidation',
                    'is-invalid' => $errors->has('meta_keywords'),
                ])
                    placeholder='Meta Keywords Here...' />
                @error('meta_keywords')
                    <x-admin.form.invalid-error>{{ $message }}</x-admin.form.invalid-error>
                @enderror
            </div>
            <div class="col-md-12 mt-2">
                <x-admin.form.label for="meta_description" class="form-label" :asterisk="false">Meta
                    Description</x-admin.form.label>
                <x-admin.form.text-editor name="meta_description" @class([
                    'otherValidation',
                    'is-invalid' => $errors->has('meta_description'),
                ]) id='meta_description'
                    placeholder='Meta Description Here...' />
                @error('meta_description')
                    <x-admin.form.invalid-error>{{ $message }}</x-admin.form.invalid-error>
                @enderror
            </div>

        </div>
    </div>
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
