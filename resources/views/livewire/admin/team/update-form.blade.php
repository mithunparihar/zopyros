<form class="pt-0 g-2" wire:submit.prevent="SaveForm" enctype="multipart/form-data">
    @csrf
    <div class="card p-3 mt-2">
        <div class="row">
            <div class="mb-1 col-md-6">
                <x-admin.form.label for="title" class="form-label" :asterisk="true">Title</x-admin.form.label>
                <x-admin.form.input name="title" wire:model="title" type="text" placeholder='Enter Title Here...'
                    @class(['otherValidation', 'is-invalid' => $errors->has('title')]) />
                @error('title')
                    <x-admin.form.invalid-error>{{ $message }}</x-admin.form.invalid-error>
                @enderror
            </div>
            <div class="col-md-6">
                <x-admin.form.label for="designation" class="form-label"
                    :asterisk="true">Designation</x-admin.form.label>
                <x-admin.form.input name="designation" wire:model="designation" type="text"
                    placeholder='Enter Designation Here...' @class([
                        'otherValidation',
                        'is-invalid' => $errors->has('designation'),
                    ]) />
                @error('designation')
                    <x-admin.form.invalid-error>{{ $message }}</x-admin.form.invalid-error>
                @enderror
            </div>
            <div class="col-4 mt-4">
                <x-admin.form.label for="formFile" class="formFile form-label" :asterisk="true">
                    Image 250px * 250px
                </x-admin.form.label>
                <x-admin.form.input name="image" wire:model="image" @class([
                    'is-invalid' => $errors->has('image'),
                ]) type="file" accept='image/*' />
                @error('image')
                    <x-admin.form.invalid-error>{{ $message }}</x-admin.form.invalid-error>
                @enderror
            </div>
            <div class="col-2 mt-4">
                @if ($image)
                    @if (in_array($image->getMimeType(), \CommanFunction::getSupportedFiles(\App\Enums\ButtonText::SUPPORTEDIMAGE)))
                        <img src="{{ $image->temporaryUrl() }}" class="defaultimg">
                    @endif
                @else
                <x-image-preview class="defaultimg" id="blah" imagepath="team" width="200" :image="$info->image" />
                @endif
            </div>
        </div>
    </div>
    <div class="card mt-2 position-sticky  bottom-0" style="box-shadow:0 -4px 6px -6px rgb(0 0 0/.3);">
        <div class="row">
            <div class="col-12">
                <x-admin.form.save-button class="py-3 text-center" target="images,banner,SaveForm">
                    {{ \App\Enums\ButtonText::SAVE }}
                </x-admin.form.save-button>
            </div>
        </div>
    </div>
</form>
