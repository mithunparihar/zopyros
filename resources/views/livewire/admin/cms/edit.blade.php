<form class="pt-0 g-2" wire:submit.prevent="UpdateForm" enctype="multipart/form-data">
    @csrf
    <div class="card p-3 mt-2">
        <div class="row">
            @if (in_array($info->id, [1, 2, 3, 4, 5, 6]))
                <div class="col-md-12 mb-2">
                    <x-admin.form.label for="heading" class="form-label" :asterisk="false">Heading</x-admin.form.label>
                    <x-admin.form.input name="heading" wire:model="heading" class="otherValidation" type="text"
                        placeholder="Heading Here..." />
                    @error('heading')
                        <x-admin.form.invalid-error>{{ $message }}</x-admin.form.invalid-error>
                    @enderror
                </div>
            @endif


            <div class="col-md-12">
                <x-admin.form.label for="title" class="form-label" asterisk="true">Title</x-admin.form.label>
                <x-admin.form.input name="title" wire:model="title" class="otherValidation" type="text"
                    placeholder="Title Here..." />
                @error('title')
                    <x-admin.form.invalid-error>{{ $message }}</x-admin.form.invalid-error>
                @enderror
            </div>

            @if (in_array($info->id, [10]))
                <div class="col-md-12 mt-2">
                    <x-admin.form.label for="short_description" class="form-label" :asterisk="false">Short
                        Description</x-admin.form.label>
                    <x-admin.form.text-editor wire:model="short_description" id="short_description"
                        placeholder='Write something here...' />
                    @error('short_description')
                        <x-admin.form.invalid-error>{{ $message }}</x-admin.form.invalid-error>
                    @enderror
                </div>
            @endif

            @if (in_array($info->id, [7,8,9]))
                <div class="col-4 mt-2">
                    <x-admin.form.label for="formFile" class="formFile form-label" asterisk="false">
                        Image <small>(Size: 900px * 900px)</small>
                    </x-admin.form.label>
                    <x-admin.form.input name="image" wire:model="image" type="file" accept="image/*" />
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
                        <x-image-preview id="blah" class="defaultimg" imagepath="cms" width="300" height="400"
                            :image="$info->image" />
                    @endif
                </div>
            @endif
        </div>
    </div>

    @if (!in_array($info->id, [2,3,4,5,6,10]))
        <div class="card p-3 mt-2">
            <div class="row">
                <div class="col-md-12 mt-2">
                    <x-admin.form.label for="description" class="form-label"
                        asterisk="{{ in_array($info->id, [0, 2, 3, 7, 8, 13,14,15]) ? false : true }}">Description</x-admin.form.label>
                    <x-admin.form.text-editor wire:model="description" ignore="true" name="description"
                        class="summernote" placeholder="Write somthing here..."
                        id="description">{{ $description }}</x-admin.form.text-editor>
                    @error('description')
                        <x-admin.form.invalid-error>{{ $message }}</x-admin.form.invalid-error>
                    @enderror
                </div>
            </div>
        </div>
    @endif

    <div class="card mt-2 position-sticky  bottom-0" style="box-shadow:0 -4px 6px -6px rgb(0 0 0/.3);">
        <div class="row">
            <div class="col-12">
                <x-admin.form.save-button class="py-3 text-center" target="images,UpdateForm">
                    {{ \App\Enums\ButtonText::SAVE }}
                </x-admin.form.save-button>
            </div>
        </div>
    </div>
</form>
