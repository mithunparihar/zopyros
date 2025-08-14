<form class="pt-0 g-2" wire:submit.prevent="UpdateForm" enctype="multipart/form-data">
    @csrf

    <div class="card p-3 mt-2">
        <div class="row">

            <div class="col-md-12 mt-2">
                <x-admin.form.label for="description" class="form-label" :asterisk="true">Description For Child
                    Pages</x-admin.form.label>
                <x-admin.form.text-editor name="description" id="description" ignore="true" class="summernote"
                    wire:model="description" />
                @error('description')
                    <x-admin.form.invalid-error>{{ $message }}</x-admin.form.invalid-error>
                @enderror
            </div>

            <div class="mt-3 col-md-3">
                <x-admin.form.label for="cityId" class="form-label" :asterisk="true">Location
                    Mapping</x-admin.form.label>
                <select name="cityId" wire:change="getlocationData($event.target.value)" wire:model.live="cityId"
                    class="form-select" id="cityId">
                    <option value="">Choose Location</option>
                    @foreach ($locations as $location)
                        <option value="{{ $location->id }}">{{ $location->title }}</option>
                        @if (count($location->childs) > 0)
                            <optgroup label="{{ $location->title }} Locations">
                                @foreach ($location->childs as $childs)
                                    <option value="{{ $childs->id }}">{{ ucwords($childs->title) }}</option>
                                @endforeach
                            </optgroup>
                        @endif
                    @endforeach

                </select>
                @error('cityId')
                    <x-admin.form.invalid-error>{{ $message }}</x-admin.form.invalid-error>
                @enderror
            </div>
            <div class="mt-3 col-md-4">
                <x-admin.form.label for="serviceId" class="form-label" :asterisk="true">
                    Service Mapping
                </x-admin.form.label>
                <x-admin.form.select-box name="serviceId" wire:model="serviceId" :lists="$services" id="serviceId" />
                @error('serviceId')
                    <x-admin.form.invalid-error>{{ $message }}</x-admin.form.invalid-error>
                @enderror
            </div>

            <div class="col-3 mt-3">
                <x-admin.form.label for="formFile" class="formFile form-label" :asterisk="false">
                    Best Image 600px * 600px
                </x-admin.form.label>
                <x-admin.form.input name="image" wire:model="image" type="file" accept="accept" />
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
                    <x-image-preview class="defaultimg" width="300" imagepath="location-preference" :image="$info->image" />
                @endif
            </div>
        </div>
    </div>


    @if (($cityinfo->city_id ?? 0) == 0)
        <div class="card p-3 mt-2">
            <h6 class="text-danger text-center">This <b>"[Location]"</b> Tag are Used for Dynamic Values. </h6>

            <div class="bg-secondary  rounded-2 p-3 bg-opacity-25">
                <div class="row">
                    <div class="col-md-12 mt-2">
                        <x-admin.form.label for="description2" class="form-label"
                            :asterisk="true">Description</x-admin.form.label>
                        <x-admin.form.text-editor name="description2" id="description2" ignore="true"
                            class="summernote" wire:model="description2" />
                        @error('description2')
                            <x-admin.form.invalid-error>{{ $message }}</x-admin.form.invalid-error>
                        @enderror
                    </div>

                    <div class="mb-1 col-md-12">
                        <x-admin.form.label for="page_meta_title" class="form-label" :asterisk="true">Meta
                            Title</x-admin.form.label>
                        <x-admin.form.input name="page_meta_title" type="text" wire:model="page_meta_title"
                            placeholder='Write something here...' @class([
                                'otherValidation',
                                'is-invalid' => $errors->has('page_meta_title'),
                            ]) />
                        @error('page_meta_title')
                            <x-admin.form.invalid-error>{{ $message }}</x-admin.form.invalid-error>
                        @enderror
                    </div>
                    <div class="col-md-12 mt-2">
                        <x-admin.form.label for="page_meta_keywords" class="form-label" :asterisk="true">Meta
                            Keywords</x-admin.form.label>
                        <x-admin.form.text-editor name="page_meta_keywords" wire:model="page_meta_keywords"
                            placeholder='Write something here...' @class([
                                'otherValidation',
                                'is-invalid' => $errors->has('page_meta_keywords'),
                            ]) />
                        @error('page_meta_keywords')
                            <x-admin.form.invalid-error>{{ $message }}</x-admin.form.invalid-error>
                        @enderror
                    </div>
                    <div class="col-md-12 mt-2">
                        <x-admin.form.label for="page_meta_description" class="form-label" :asterisk="true">Meta
                            Description</x-admin.form.label>
                        <x-admin.form.text-editor name="page_meta_description" wire:model="page_meta_description"
                            placeholder='Write something here...' @class([
                                'otherValidation',
                                'is-invalid' => $errors->has('page_meta_description'),
                            ]) />
                        @error('page_meta_description')
                            <x-admin.form.invalid-error>{{ $message }}</x-admin.form.invalid-error>
                        @enderror
                    </div>
                </div>
            </div>

        </div>
    @endif

    <div class="card p-3 mt-2">
        <div class="row">
            <div class="mb-1 col-md-12">
                <x-admin.form.label for="meta_title" class="form-label" :asterisk="true">Meta
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
                <x-admin.form.label for="meta_keywords" class="form-label" :asterisk="true">Meta
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
                <x-admin.form.label for="meta_description" class="form-label" :asterisk="true">Meta
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
    <div class="card mt-2 position-sticky  bottom-0" style="box-shadow:0 -4px 6px -6px rgb(0 0 0/.3);">
        <div class="row">
            <div class="col-12">
                <x-admin.form.save-button class="py-3 text-center" target="SaveForm">
                    {{ \App\Enums\ButtonText::UPDATE }}
                </x-admin.form.save-button>
            </div>
        </div>
    </div>
</form>

@push('js')
    <script>
        function generateEditor() {
            $('#description2').each(function() {
                $(this).summernote({
                    placeholder: 'Write something here...',
                    cleanPaste: true,
                    callbacks: {
                        onImageUpload: function(files, editor, welEditable) {
                            let editorBox = $(this).attr('id');
                            sendFile2(files[0], editor, welEditable, editorBox);
                        },
                        onChange: function(contents, $editable2) {
                            let editorBox = $(this).attr('data-key-id');
                            @this.set('description2', contents, $editable2);
                        },
                    },
                });
            });
        }

        window.addEventListener('generateEditorAgain', event => {
            setTimeout(() => {
                generateEditor();
            }, 500);
        });


        function sendFile2(file, editor, welEditable, editorBox) {
            let XCSRF_Token = "{{ csrf_token() }}";
            data = new FormData();
            data.append("file", file);
            data.append("_token", XCSRF_Token);
            $.ajax({
                data: data,
                type: "POST",
                url: CkeditorImageUpload,
                cache: false,
                contentType: false,
                processData: false,
                success: function(url) {
                    var image = $('<img>').attr('src', url?.url);
                    $('#' + editorBox).summernote("insertNode", image[0]);
                }
            });
        }
    </script>
@endpush