<form class="pt-0 g-2" wire:submit.prevent="SaveForm" enctype="multipart/form-data">
    @csrf
    <div class="card p-3 mt-2">
        <div class="row">
            <div class="col-12 mb-2">
                <div class=" bg-secondary bg-opacity-25 rounded-1">
                    <h5 class="h6 mb-0 p-2">Basic Information </h5>
                </div>
            </div>
            <div class="mb-1 col-md-12">
                <x-admin.form.label for="title" class="form-label" :asterisk="true">Title</x-admin.form.label>
                <x-admin.form.input wire:model="title" type="text" @class(['otherValidation', 'is-invalid' => $errors->has('title')])
                    placeholder="Enter Title Here..." />
                @error('title')
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

            <div class="col-md-12 mt-2">
                <x-admin.form.label for="specifications" class="form-label"
                    :asterisk="false">Specifications</x-admin.form.label>
                <x-admin.form.text-editor wire:model="specifications" ignore="true" class="summernote"
                    id="specifications">{{ $specifications }}</x-admin.form.text-editor>
                @error('specifications')
                    <x-admin.form.invalid-error>{{ $message }}</x-admin.form.invalid-error>
                @enderror
            </div>

        </div>
    </div>

    <div class="card p-3 mt-2">
        <div class="row">
            <div class="col-12 mb-2">
                <div class=" bg-secondary bg-opacity-25 rounded-1">
                    <h5 class="h6 mb-0 p-2">Mapped With Categories</h5>
                </div>
            </div>
            @foreach ($categoriesArr as $category)
                <div class="col-md-12">
                    <x-admin.category-tree :category="$category" />
                </div>
            @endforeach
        </div>
    </div>

    <div class="card p-3 mt-2">
        <div class="row">
            <div class="col-12 mb-2">
                <div class=" bg-secondary bg-opacity-25 rounded-1">
                    <h5 class="h6 mb-0 p-2">Mapped With Colors, Sizes & Images</h5>
                </div>
            </div>
            <div class="col-12 mb-2">
                <x-admin.form.label for="size_category" class="form-label" :asterisk="false">Size
                    Categories</x-admin.form.label>
                <x-admin.form.select-box wire:model="size_category" wire:change="catgeorySize($event.target.value)"
                    :lists="$sizeCategoryArr" @class([
                        'otherValidation',
                        'is-invalid' => $errors->has('size_category'),
                    ]) />
                @error('size_category')
                    <x-admin.form.invalid-error>{{ $message }}</x-admin.form.invalid-error>
                @enderror
            </div>
        </div>
        @foreach ($inputs as $key => $input)
            <div class="bg-secondary mb-2 rounded-2 position-relative p-2 bg-opacity-10">
                <div class="row">
                    <div class="col-3 mb-2">
                        <x-admin.form.label for="inputs.{{ $key }}.colors.code" class="form-label"
                            :asterisk="true">Color
                            Code (HEX) </x-admin.form.label>
                        <x-admin.form.input wire:model="inputs.{{ $key }}.colors.code" type="text"
                            placeholder='Meta Color Code Here...' @class([
                                'otherValidation',
                                'is-invalid' => $errors->has('inputs.' . $key . '.colors.code'),
                            ]) />
                        <a href="https://htmlcolorcodes.com/" target="_blank" class="small">Click Here For HEX Code</a>
                        @error("inputs.$key.colors.code")
                            <x-admin.form.invalid-error>{{ $message }}</x-admin.form.invalid-error>
                        @enderror
                    </div>
                    <div class="col-3 mb-2">
                        <x-admin.form.label for="inputs.{{ $key }}.colors.name" class="form-label"
                            :asterisk="true">Color
                            Name</x-admin.form.label>
                        <x-admin.form.input wire:model="inputs.{{ $key }}.colors.name" type="text"
                            placeholder='Meta Color Name Here...' @class([
                                'otherValidation',
                                'is-invalid' => $errors->has('inputs.' . $key . '.colors.name'),
                            ]) />
                        @error("inputs.$key.colors.name")
                            <x-admin.form.invalid-error>{{ $message }}</x-admin.form.invalid-error>
                        @enderror
                    </div>
                    <div class="col-4">
                        <x-admin.form.label for="images.$key.images" class="formFile form-label" :asterisk="true">
                            Images <small>(Size: 1000px * 1000px)</small>
                        </x-admin.form.label>
                        <x-admin.form.input wire:model.live="inputs.{{ $key }}.images" multiple
                            @class(['is-invalid' => $errors->has('inputs.' . $key . '.images')]) type="file" accept="image/*" />
                        @error("inputs.$key.images")
                            <x-admin.form.invalid-error>{{ $message }}</x-admin.form.invalid-error>
                        @enderror
                    </div>
                </div>
                <div class="row text-center" wire:loading wire:target="inputs.{{ $key }}.images">
                    <div class="col-12 text-dark">
                        <span class="spinner-border" style=" width: 15px;height: 15px;font-size: 7px;"></span>
                        <span>Uploading...</span>
                    </div>
                </div>
                @if (count($inputs[$key]['images'] ?? []) > 0)
                    <hr>
                    <div class="row" wire:loading.remove wire:target="inputs.{{ $key }}.images">
                        @foreach ($inputs[$key]['images'] ?? [] as $imk => $image)
                            <div class="col-2 mb-3 border-danger position-relative">
                                @if ($image)
                                    @if (in_array($image->getMimeType(), \CommanFunction::getSupportedFiles(\App\Enums\ButtonText::SUPPORTEDIMAGE)))
                                        <img src="{{ $image->temporaryUrl() }}" class=" w-100 defaultimg">
                                    @else
                                        <x-image-preview class="defaultimg w-100" id="blah" width="200"
                                            imagepath="" image="" />
                                    @endif
                                @endif

                                <a role="button" wire:click="eliminarImage({{$key}},{{$imk}})"
                                    wire:confirm="Are you sure you want to delete this image? This action cannot be undone."
                                    style="width:20px;height:20px;top:-7px;right:5px" data-title="Remove"
                                    class="bg-danger sws-bounce sws-top text-white text-center rounded-circle position-absolute ">
                                    <i class="fas fa-times"></i>
                                </a>

                                @if ($inputs[$key]['primary_image'] == $imk)
                                    <button type="button" class="btn btn-sm btn-success w-100">
                                        Is Primary
                                    </button>
                                @else
                                    <button type="button" class="btn btn-sm btn-primary w-100"
                                        wire:click="setPrimaryImage({{ $key }}, {{ $imk }})">
                                        Set as Primary
                                    </button>
                                @endif

                                @error("inputs.$key.images.$imk")
                                    <x-admin.form.invalid-error>{{ $message }}</x-admin.form.invalid-error>
                                @enderror
                            </div>
                        @endforeach
                    </div>
                    <hr>
                @endif

                @foreach ($inputs[$key]['sizes'] ?? [] as $szk => $sizes)
                    <div class="row p-2">
                        <div class="col-2">
                            <x-admin.form.label for="size" class="form-label"
                                :asterisk="false">Size</x-admin.form.label>
                            <span class="d-flex h-50 align-items-center">
                                {{ $sizes['title'] }} :
                            </span>
                        </div>
                        <div class="col-2">
                            <x-admin.form.label for="inputs.{{ $key }}.sizes.{{ $szk }}.sku"
                                class="form-label" :asterisk="false">SKU</x-admin.form.label>
                            <x-admin.form.input wire:model="inputs.{{ $key }}.sizes.{{ $szk }}.sku"
                                type="text" placeholder='Sku Here...' @class([
                                    'otherValidation',
                                    'is-invalid' => $errors->has('inputs.' . $key . '.sizes.' . $szk . '.sku'),
                                ]) />
                            @error("inputs.$key.sizes.$szk.sku")
                                <x-admin.form.invalid-error>{{ $message }}</x-admin.form.invalid-error>
                            @enderror
                        </div>
                        <div class="col-2">
                            <x-admin.form.label for="inputs.{{ $key }}.sizes.{{ $szk }}.mrp"
                                class="form-label" :asterisk="false">MRP</x-admin.form.label>
                            <x-admin.form.input wire:model="inputs.{{ $key }}.sizes.{{ $szk }}.mrp"
                                type="text" placeholder='MRP Here...' @class([
                                    'otherValidation',
                                    'is-invalid' => $errors->has('inputs.' . $key . '.sizes.' . $szk . '.mrp'),
                                ]) />
                            @error("inputs.$key.sizes.$szk.mrp")
                                <x-admin.form.invalid-error>{{ $message }}</x-admin.form.invalid-error>
                            @enderror
                        </div>
                        <div class="col-2">
                            <x-admin.form.label for="inputs.{{ $key }}.sizes.{{ $szk }}.price"
                                class="form-label" :asterisk="false">Price</x-admin.form.label>
                            <x-admin.form.input
                                wire:model="inputs.{{ $key }}.sizes.{{ $szk }}.price"
                                type="text" placeholder='Price Here...' @class([
                                    'otherValidation',
                                    'is-invalid' => $errors->has(
                                        'inputs.' . $key . '.sizes.' . $szk . '.price'),
                                ]) />
                            @error("inputs.$key.sizes.$szk.price")
                                <x-admin.form.invalid-error>{{ $message }}</x-admin.form.invalid-error>
                            @enderror
                        </div>
                        <div class="col-2">
                            <x-admin.form.label for="inputs.{{ $key }}.sizes.{{ $szk }}.stock"
                                class="form-label" :asterisk="false">Stock</x-admin.form.label>
                            <x-admin.form.input
                                wire:model="inputs.{{ $key }}.sizes.{{ $szk }}.stock"
                                type="text" placeholder='Stock Here...' @class([
                                    'otherValidation',
                                    'is-invalid' => $errors->has(
                                        'inputs.' . $key . '.sizes.' . $szk . '.stock'),
                                ]) />
                            @error("inputs.$key.sizes.$szk.stock")
                                <x-admin.form.invalid-error>{{ $message }}</x-admin.form.invalid-error>
                            @enderror
                        </div>
                        <div class="col-2">
                            <x-admin.form.label for="inputs.{{ $key }}.sizes.{{ $szk }}.publish"
                                class="form-label" :asterisk="false">Is
                                Publish</x-admin.form.label>
                            <select wire:model="inputs.{{ $key }}.sizes.{{ $szk }}.publish"
                                @class([
                                    'form-select',
                                    'is-invalid' => $errors->has(
                                        'inputs.' . $key . '.sizes.' . $szk . '.publish'),
                                ])>
                                <option value="1">Publish</option>
                                <option value="0">Unpublish</option>
                            </select>
                            @error("inputs.$key.sizes.$szk.publish")
                                <x-admin.form.invalid-error>{{ $message }}</x-admin.form.invalid-error>
                            @enderror
                        </div>
                    </div>
                @endforeach

                @if ($key > 0)
                    <a role="button" data-title="Remove" wire:click="removeColor({{ $key }})"
                        class="position-absolute bg-danger sws-bounce sws-top text-center text-white rounded-circle"
                        style="width: 20px; height:20px;top:-5px;right:-5px">
                        <i class="fas fa-times"></i>
                    </a>
                @endif
            </div>
        @endforeach

        <div class="row border-top">
            <div class="col-12 mt-2 text-center">
                <button type="button" wire:loading.remove wire:target="AddMoreColor" wire:click="AddMoreColor"
                    class="btn btn-dark btn-sm">Add More</button>
                <button type="button" wire:loading wire:target="AddMoreColor" disabled class="btn btn-dark btn-sm">
                    <span class="spinner-border"></span> Adding...
                </button>
            </div>
        </div>
    </div>

    <div class="card p-3 mt-2">
        <div class="row">
            <div class="col-12 mb-2">
                <div class=" bg-secondary bg-opacity-25 rounded-1">
                    <h5 class="h6 mb-0 p-2">Seo Or Meta Tag </h5>
                </div>
            </div>
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
                <x-admin.form.save-button class="py-3 text-center" target="image,SaveForm">
                    {{ \App\Enums\ButtonText::SAVE }}
                </x-admin.form.save-button>
            </div>
        </div>
    </div>
</form>


@push('js')
    <script>
        document.addEventListener('livewire:init', function() {
            let categorySelect = $('#categories');

            function initSelect2() {
                categorySelect.select2();

                categorySelect.on('change', function(e) {
                    const selected = $(this).val();
                    @this.set('categories', selected);
                });
            }

            initSelect2();

            Livewire.hook('message.processed', (message, component) => {
                initSelect2();
            });
        });
    </script>
@endpush
