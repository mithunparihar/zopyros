<form class="pt-0 g-2" wire:submit.prevent="SaveForm" enctype="multipart/form-data">
    @csrf
    <div class="card p-3 mt-2">
        <div class="row">
            <div class="mb-2 col-md-12">
                <x-admin.form.label for="title" class="form-label" :asterisk="true">Title</x-admin.form.label>
                <x-admin.form.input wire:model="title" type="text" @class(['otherValidation', 'is-invalid' => $errors->has('title')])
                    placeholder="Enter Title Here..." />
                @error('title')
                    <x-admin.form.invalid-error>{{ $message }}</x-admin.form.invalid-error>
                @enderror
            </div>
            <div class="mb-2 col-md-12">
                <x-admin.form.label for="slug" class="form-label" :asterisk="true">URL Alias / Slug</x-admin.form.label>
                <x-admin.form.input wire:model="slug" type="text" placeholder='URL Alias Here...'
                    @class(['otherValidation', 'is-invalid' => $errors->has('slug')]) />
                @error('slug')
                    <x-admin.form.invalid-error>{{ $message }}</x-admin.form.invalid-error>
                @enderror
            </div>
        </div>
    </div>
    <div class="card p-3 mt-2">
        <div class="row">
            <div class="col-md-12 mt-2">
                <x-admin.form.label for="description" class="form-label"
                    :asterisk="true">Description</x-admin.form.label>
                <x-admin.form.text-editor wire:model="description" id="description" ignore="true"
                    @class([
                        'otherValidation',
                        'is-invalid' => $errors->has('description'),
                    ]) class="summernote">{{ $description }}</x-admin.form.text-editor>
                @error('description')
                    <x-admin.form.invalid-error>{{ $message }}</x-admin.form.invalid-error>
                @enderror
            </div>
            <div class="col-md-12 mt-2">
                <x-admin.form.label for="description" class="form-label"
                    :asterisk="true">Description 2</x-admin.form.label>
                <x-admin.form.text-editor wire:model="description_2" id="description_2" ignore="true"
                    @class([
                        'otherValidation',
                        'is-invalid' => $errors->has('description_2'),
                    ]) class="summernote">{{ $description }}</x-admin.form.text-editor>
                @error('description_2')
                    <x-admin.form.invalid-error>{{ $message }}</x-admin.form.invalid-error>
                @enderror
            </div>
        </div>
    </div>
    <div class="card p-3 mt-2">
        <div class="row">
            <div wire:loading wire:target="images" class="col-12 my-5 text-center">
                <div class="spinner-border" style="width: 20px;height:20px;font-size:10px;" role="status"></div>
                Uploading...
            </div>
            <div wire:loading.remove wire:target="images" class="col-5 my-3">
                <x-admin.form.label for="images" class="formFile form-label" :asterisk="true">Best Image 900px *
                    900px</x-admin.form.label>
                <x-admin.form.input wire:model="images" multiple type="file" accept='image/*'
                    @class(['otherValidation', 'is-invalid' => $errors->has('images')]) />
                @error('images')
                    <x-admin.form.invalid-error>{{ $message }}</x-admin.form.invalid-error>
                @enderror
            </div>

            <div wire:loading.remove wire:target="images" class="row">
                @foreach ($preImages as $img)
                    <div drag-item="{{ $img->id }}" draggable="true" wire:key="img{{ $img->id }}"
                        class="col-2 my-3 {{ $img->is_primary == 1 ? 'setPrimary' : 'notPrimary' }}"
                        style="position: relative">
                        <div wire:click="setPrimaryImage({{ $img->id }})" >
                            <x-image-preview class="defaultimg w-100" width="200"  imagepath="projects" :image="$img->image" />
                        </div>
                        <a role="button" wire:click="removeImage({{ $img->id }})"
                            class="btn rounded-pill btn-icon btn-label-danger"><i class="bx bx-x"></i></a>
                        @if ($img->is_primary == 1)
                            <a role="button" class="btn rounded-pill btn-icon btn-success text-white"><i
                                    class="bx bx-check"></i></a>
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
                                <img src="{{ $image->temporaryUrl() }}"
                                    wire:click="setPreviewImagePrimary({{ $key }})" class="defaultimg w-100">
                            @else
                                <x-image-preview :options="['class' => 'defaultimg w-100', 'id' => 'blah']" imagepath="" image="" />
                            @endif
                            @error("images.$key")
                                <x-admin.form.invalid-error>{{ $message }}</x-admin.form.invalid-error>
                            @enderror
                            <a role="button" wire:click="eliminarImage({{ $key }})"
                                class="btn rounded-pill btn-icon btn-label-danger"><i class="bx bx-x"></i></a>
                            <a role="button" class="btn rounded-pill btn-icon btn-success text-white"><i
                                    class="bx bx-check"></i></a>
                            <div class="badge bg-label-primary w-100 mt-2">
                                Primary
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
    <div class="card p-3 mt-2">
        <div class="row">

            <div class="mb-1 col-md-12">
                <x-admin.form.label for="meta_title" class="form-label" :asterisk="false">Meta
                    Title</x-admin.form.label>
                <x-admin.form.input wire:model="meta_title" type="text" @class([
                    'otherValidation',
                    'is-invalid' => $errors->has('meta_title'),
                ])
                    placeholder='Enter Meta Title Here...' />
                @error('meta_title')
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
                    placeholder='Write something here...' />
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
                    placeholder='Write something here...' />
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
                    {{ \App\Enums\ButtonText::UPDATE }}
                </x-admin.form.save-button>
            </div>
        </div>
    </div>
</form>
@push('js')
    <script>
        document.addEventListener('livewire:init', function() {
            let select = $('#selectMultipleType');
            select.select2();
            select.on('change', function() {
                @this.set('type', $(this).val());
            });
            Livewire.on('dataSaved', (message, component) => {
                select.val(null).trigger('change');;
            });
        });
    </script>
@endpush