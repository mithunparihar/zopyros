<form class="pt-0 g-2" wire:submit.prevent="SaveForm" enctype="multipart/form-data">
    @csrf
    <div class="card p-3 mt-2">
        <div class="row">
            <div class="mb-1 col-md-12">
                <x-admin.form.label for="title" class="form-label" :asterisk="true">Title</x-admin.form.label>
                <x-admin.form.input wire:model="title" type="text" @class(['otherValidation', 'is-invalid' => $errors->has('title')])
                    placeholder="Enter Title Here..." />
                @error('title')
                    <x-admin.form.invalid-error>{{ $message }}</x-admin.form.invalid-error>
                @enderror
            </div>
            <div class="mb-1 col-md-3">
                <x-admin.form.label for="post_date" class="form-label" :asterisk="true">Post Date</x-admin.form.label>
                <x-admin.form.input wire:model="post_date" onClick="showPicker()" id="post_date" type="date"
                    @class(['is-invalid' => $errors->has('title')]) />
                @error('post_date')
                    <x-admin.form.invalid-error>{{ $message }}</x-admin.form.invalid-error>
                @enderror
            </div>
            <div class="mb-2 col-md-3">
                <x-admin.form.label for="category" class="form-label" :asterisk="true">Category</x-admin.form.label>
                <x-admin.form.select-box wire:model="category" @class(['is-invalid' => $errors->has('category')]) :lists="$categories"
                    id="category" />
                @error('category')
                    <x-admin.form.invalid-error>{{ $message }}</x-admin.form.invalid-error>
                @enderror
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
        <div class="row">
            <div class="col-4 mt-3">
                <x-admin.form.label for="formFile" class="formFile form-label" :asterisk="true">
                    Thumb Image <small>(Size: 550px * 550px)</small>
                </x-admin.form.label>
                <x-admin.form.input wire:model="image" type="file" accept="image/*" />
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
            <div class="col-4 mt-3">
                <x-admin.form.label for="formFile" class="formFile form-label" :asterisk="true">
                    Banner Image <small>(Size: 900px * 500px)</small>
                </x-admin.form.label>
                <x-admin.form.input wire:model="banner" type="file" accept="image/*" />
                @error('banner')
                    <x-admin.form.invalid-error>{{ $message }}</x-admin.form.invalid-error>
                @enderror
            </div>
            <div class="col-2 mt-3">
                @if ($banner)
                    @if (in_array($banner->getMimeType(), \CommanFunction::getSupportedFiles(\App\Enums\ButtonText::SUPPORTEDIMAGE)))
                        <img src="{{ $banner->temporaryUrl() }}" class="defaultimg">
                    @endif
                @endif
            </div>
        </div>
    </div>

    <div class="card p-3 mt-2">
        <div class="row">
            <div class="col-md-12">
                <h6 class="mb-0 py-2 text-center"><u>TABLE OF CONTENT</u></h6>
            </div>
        </div>
        @foreach ($tablecontents as $key => $input)
            <div class="row bg-secondary rounded-2 mb-3 py-2 bg-opacity-10">
                <div class="mb-1 col-md-10">
                    <x-admin.form.label for="tablecontents.{{ $key }}.title" class="form-label"
                        :asterisk="false">Title</x-admin.form.label>
                    <x-admin.form.input wire:model="tablecontents.{{ $key }}.title" type="text"
                        @class([
                            'otherValidation',
                            'is-invalid' => $errors->has('tablecontents.' . $key . '.title'),
                        ]) placeholder="Enter Title Here..." />
                    @error("tablecontents.$key.title")
                        <x-admin.form.invalid-error>{{ $message }}</x-admin.form.invalid-error>
                    @enderror
                </div>
                <div class="mb-1 col-md-2">
                    <x-admin.form.label for="tablecontents.{{ $key }}.tag" class="form-label"
                        :asterisk="false">Heading
                        Tag</x-admin.form.label>
                    <select wire:model="tablecontents.{{ $key }}.tag" @class([
                        'form-select',
                        'is-invalid' => $errors->has('tablecontents.' . $key . '.tag'),
                    ])>
                        <option value="">Choose One</option>
                        <option value="1">H1 Tag</option>
                        <option value="2">H2 Tag</option>
                        <option value="3">H3 Tag</option>
                        <option value="4">H4 Tag</option>
                        <option value="5">H5 Tag</option>
                        <option value="6">H6 Tag</option>
                    </select>
                    @error("tablecontents.$key.tag")
                        <x-admin.form.invalid-error>{{ $message }}</x-admin.form.invalid-error>
                    @enderror
                </div>
                <div class="col-md-12 mt-2">
                    <x-admin.form.label for="tablecontents.{{ $key }}.description" class="form-label"
                        :asterisk="false">Description</x-admin.form.label>
                    <x-admin.form.text-editor wire:model="tablecontents.{{ $key }}.description" ignore="true"
                        class="summernote"
                        id="description{{ $key }}">{{ $tablecontents[$key]['description'] }}</x-admin.form.text-editor>
                    @error("tablecontents.$key.description")
                        <x-admin.form.invalid-error>{{ $message }}</x-admin.form.invalid-error>
                    @enderror
                </div>
                <div class="my-2 col-md-2">
                    <x-admin.form.label for="tablecontents.{{ $key }}.sequence" class="form-label"
                        :asterisk="false">Sequence</x-admin.form.label>
                    <x-admin.form.input wire:model="tablecontents.{{ $key }}.sequence" type="text"
                        @class([
                            'otherValidation',
                            'is-invalid' => $errors->has('tablecontents.' . $key . '.sequence'),
                        ]) placeholder="Enter Sequence Here..." />
                    @error("tablecontents.$key.sequence")
                        <x-admin.form.invalid-error>{{ $message }}</x-admin.form.invalid-error>
                    @enderror
                </div>
                <div class="my-2 col-md-3">
                    <x-admin.form.label for="tablecontents.{{ $key }}.publish" class="form-label"
                        :asterisk="false">Is
                        Publish</x-admin.form.label>
                    <select wire:model="tablecontents.{{ $key }}.publish" @class([
                        'form-select',
                        'is-invalid' => $errors->has('tablecontents.' . $key . '.publish'),
                    ])>
                        <option value="">Choose One</option>
                        <option value="1">Publish</option>
                        <option value="0">Unpublish</option>
                    </select>
                    @error("tablecontents.$key.publish")
                        <x-admin.form.invalid-error>{{ $message }}</x-admin.form.invalid-error>
                    @enderror
                </div>
                <div class="my-2 col-md-7 d-flex justify-content-end align-items-center">
                    @if ($key > 0)
                        <button wire:loading.remove wire:target="removeTableRow({{ $key }})" type="button"
                            wire:click="removeTableRow({{ $key }})" class="btn btn-danger ms-1 btn-sm"><i
                                class="fas fa-trash me-1"></i>
                            Remove</button>
                        <span style="cursor: no-drop" wire:loading wire:target="removeTableRow({{ $key }})">
                            <button type="button" disabled class="btn btn-danger btn-sm">
                                <span class="spinner-border me-1"></span> Please wait..
                            </button>
                        </span>
                    @endif
                </div>
            </div>
        @endforeach

        <div class="text-center">
            <button wire:loading.remove wire:target="addMoreTable" type="button" wire:click="addMoreTable"
                class="btn btn-dark btn-sm"><i class="fas fa-plus me-1"></i>
                Add
                More</button>
            <span style="cursor: no-drop" wire:loading wire:target="addMoreTable">
                <button type="button" disabled class="btn btn-dark btn-sm">
                    <span class="spinner-border me-1"></span> Please wait..
                </button>
            </span>
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

@push('js')
    <script>
        document.addEventListener('addMoreTableScrpt', event => {
            const script = document.createElement('script');
            script.src = "{{ asset('admin/js/editor.js') }}";
            script.async = true;
            document.body.appendChild(script);
        });

        document.addEventListener('relaodPage', event => {
            setTimeout(() => {
                const swal2Confirm = document.querySelector('.swal2-confirm');
                swal2Confirm.onclick = () => {
                    window.location.reload();
                }
            }, 100);
        });
        
    </script>
@endpush
