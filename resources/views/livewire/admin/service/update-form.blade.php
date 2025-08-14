<form class="pt-0 {{ $disabled ? 'disabledForm' : '' }} g-2" wire:submit.prevent="SaveForm" enctype="multipart/form-data">
    @csrf
    <div class="card p-3 mt-2">
        <div class="row">
            <div class="col-md-12">
                <x-admin.form.label for="title" class="form-label" :asterisk="true" title="Product Name" />
                <x-admin.form.input name="title" type="text" :options="['placeholder' => 'Enter Product Name Here...', 'class' => 'otherValidation']" />
                <x-admin.form.invalid-error errorFor="title" />
            </div>
            <div class="my-2 col-md-12">
                <x-admin.form.label for="alias" class="form-label" :asterisk="true" title="URL Alias" />
                <x-admin.form.input name="alias" type="text" :options="['placeholder' => 'Enter URL Alias Here...', 'class' => 'otherValidation']" />
                <x-admin.form.invalid-error errorFor="alias" />
            </div>
            <div class="mb-2 col-md-3">
                <x-admin.form.label for="company" class="form-label" :asterisk="true" title="Company" />
                <div class="position-relative">
                    <input type="text" wire:model="searchcompany" wire:input="searchCompany($event.target.value)"
                        class="form-control otherValidation SearchCat" placeholder="Search Company Here...">
                    <div id="searchcategoryBox">
                        @if (count($companies) == 0)
                            <p class="mb-0 mt-2 text-center">Sorry! No Data Found...</p>
                        @endif
                        @foreach ($companies as $comp)
                            <div class='catfilter' wire:click="selectCompany({{ $comp->id }})">{{ $comp->name }}
                                (#{{ $comp->userInfo->user_id }})
                            </div>
                        @endforeach
                    </div>
                </div>
                <x-admin.form.invalid-error errorFor="company" />
            </div>
            <div class="mb-2 col-md-3">
                <x-admin.form.label for="category" class="form-label" :asterisk="true" title="Category" />
                <select wire:model="category" id="category" wire:change="updateCategory($event.target.value)"
                    class="form-control form-select border-opacity-25 border-black">
                    <option value="" selected>-- Select Category --</option>
                    {!! \CommanFunction::getCategoryOptionDropDown($categories) !!}
                </select>
                <x-admin.form.invalid-error errorFor="category" />
            </div>
            <div class="col-md-12 mt-2">
                <x-admin.form.label for="description" class="form-label" :asterisk="true" title="Description" />
                <x-admin.form.text-editor name="description" :editorOptions="['id' => 'summernote', 'value' => $description, 'disabled' => $disabled]" />
                <x-admin.form.invalid-error errorFor="description" />
            </div>
            <div class="col-md-12 mb-3 mt-2">
                <x-admin.form.label for="description2" class="form-label" :asterisk="false" title="Specifications" />
                <x-admin.form.text-editor name="description2" :editorOptions="['id' => 'summernote2', 'value' => $description2, 'disabled' => $disabled]" />
                <x-admin.form.invalid-error errorFor="description2" />
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
                <x-admin.form.label for="images" class="formFile form-label" :asterisk="true"
                    title="Best Image  900px * 900px <small class='text-secondary'>(You can`t upload more than 6 images)</small>" />
                <x-admin.form.input name="images" type="file" :options="['accept' => 'image/*', 'multiple' => true]" />
                <x-admin.form.invalid-error errorFor="images" />
            </div>

            <div wire:loading.remove wire:target="images" class="row align-items-start">
                @foreach ($productimages as $img)
                    <div drag-item="{{ $img->id }}" wire:key="img{{ $img->id }}"
                        class="col-2 my-3 {{ $img->is_primary == 1 ? 'setPrimary' : 'notPrimary' }}"
                        style="position: relative">
                        <div @if (!$disabled) wire:click="setPrimaryImage({{ $img->id }})" @endif>
                            <x-image-preview :options="['class' => 'defaultimg w-100', 'id' => 'blah']" imagepath="service" :image="$img->image" />
                        </div>
                        <a role="button" wire:click="removeImage({{ $img->id }})"
                            class="btn rounded-pill btn-icon btn-label-danger"><i class="fa fa-times"></i></a>
                        @if ($img->is_primary == 1)
                            <a role="button" class="btn rounded-pill btn-icon btn-success text-white"><i
                                    class="fas fa-check"></i></a>
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
                            <x-admin.form.invalid-error errorFor="images.{{ $key }}" />
                            <a role="button" wire:click="eliminarImage({{ $key }})"
                                class="btn rounded-pill btn-icon btn-label-danger"><i class="fa fa-times"></i></a>
                            <a role="button" class="btn rounded-pill btn-icon btn-success text-white"><i
                                    class="fas fa-check"></i></a>
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
            <div class="col-12">
                <h6 class="text-center"><u>Service Types & Price</u></h6>
                @foreach ($typeprices as $kp => $typeprice)
                    <div class="bg-secondary bg-opacity-10 p-3 rounded @if ($kp > 0) mt-3 @endif">
                        <div class="row">
                            <div class="col-md-3">
                                <x-admin.form.label for="typeprices.{{ $kp }}.title" class="form-label"
                                    :asterisk="false" title="Title <small class='text-danger'>*</small>" />
                                <x-admin.form.input name="typeprices.{{ $kp }}.title" type="text"
                                    :options="['placeholder' => 'Title Here']" />
                                <x-admin.form.invalid-error errorFor="typeprices.{{ $kp }}.title" />
                            </div>
                            <div class="col-md-3">
                                <x-admin.form.label for="typeprices.{{ $kp }}.mrp" class="form-label"
                                    :asterisk="false" title="MRP ($) <small class='text-danger'>*</small>" />
                                <x-admin.form.input name="typeprices.{{ $kp }}.mrp" type="number"
                                    :options="['placeholder' => 'MRP Here','class'=>'onlyNumber', 'min' => '0']" />
                                <x-admin.form.invalid-error errorFor="typeprices.{{ $kp }}.mrp" />
                            </div>
                            <div class="col-md-3">
                                <x-admin.form.label for="typeprices.{{ $kp }}.price" class="form-label"
                                    :asterisk="false" title="Price ($) <small class='text-danger'>*</small>" />
                                <x-admin.form.input name="typeprices.{{ $kp }}.price" type="number"
                                    :options="['placeholder' => 'Price Here','class'=>'onlyNumber', 'min' => '0']" />
                                <x-admin.form.invalid-error errorFor="typeprices.{{ $kp }}.price" />
                            </div>

                            <div class="col-md-2">
                                <x-admin.form.label for="typeprices.{{ $kp }}.status" class="form-label"
                                    :asterisk="false" title="Status" />
                                <select wire:model="typeprices.{{ $kp }}.status" id="typeprices.{{ $kp }}.status"
                                    class="form-control form-select border-opacity-25 border-black">
                                    <option value="1">Publish</option>
                                    <option value="0">Unpublish</option>
                                </select>
                                <x-admin.form.invalid-error errorFor="typeprices.{{ $kp }}.status" />
                            </div>
                            @if (!$disabled)
                                <div class="col-md-1 mt-3 d-flex align-items-center">
                                    @if ($loop->index == 0)
                                        <button class="btn rounded-pill btn-icon btn-dark sws-bounce sws-top"
                                            data-title="Add More" type="button"
                                            wire:click="addPrice('{{ $kp }}')"><i
                                                class="fa fa-plus"></i></button>
                                    @else
                                        <button class="btn rounded-pill btn-icon btn-danger sws-bounce sws-top"
                                            data-title="Remove" type="button"
                                            wire:click="removePrice('{{ $kp }}')"><i
                                                class="fa fa-trash"></i></button>
                                    @endif
                                </div>
                            @endif

                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="card p-3 mt-2">
        <div class="row">
            <div class="col-12">
                <h6 class="text-center"><u>Key Features</u></h6>
                @foreach ($features as $key => $feature)
                    <div class="bg-secondary bg-opacity-10 p-3 rounded @if ($key > 0) mt-3 @endif">
                        <div class="row">
                            <div class="col-md-9">
                                <x-admin.form.label for="features.{{ $key }}.title" class="form-label"
                                    :asterisk="false" title="Title" />
                                <x-admin.form.input name="features.{{ $key }}.title" type="text"
                                    :options="['placeholder' => 'Key Features Title Here']" />
                                <x-admin.form.invalid-error errorFor="features.{{ $key }}.title" />
                            </div>
                            <div class="col-md-2">
                                <x-admin.form.label for="features.{{ $key }}.status" class="form-label"
                                    :asterisk="false" title="Status" />
                                <select wire:model="features.{{ $key }}.status" id="features.{{ $key }}.status"
                                    class="form-control form-select border-opacity-25 border-black">
                                    <option value="1">Publish</option>
                                    <option value="0">Unpublish</option>
                                </select>
                                <x-admin.form.invalid-error errorFor="features.{{ $key }}.status" />
                            </div>
                            @if (!$disabled)
                                <div class="col-md-1 mt-3 d-flex align-items-center">
                                    @if ($loop->index == 0)
                                        <button class="btn rounded-pill btn-icon btn-dark sws-bounce sws-top"
                                            data-title="Add More" type="button"
                                            wire:click="addFeatures('{{ $key }}')"><i
                                                class="fa fa-plus"></i></button>
                                    @else
                                        <button class="btn rounded-pill btn-icon btn-danger sws-bounce sws-top"
                                            data-title="Remove" type="button"
                                            wire:click="removeFeatures('{{ $key }}')"><i
                                                class="fa fa-trash"></i></button>
                                    @endif
                                </div>
                            @endif
                            <div class="col-md-12 mt-2">
                                <x-admin.form.label for="features.{{ $key }}.description" class="form-label"
                                    :asterisk="false" title="Description" />
                                <x-admin.form.text-editor name="features.{{ $key }}.description"
                                    :editorOptions="[
                                        'id' => 'short_description',
                                        'placeholder' => 'Write something here...',
                                        'value' => $features[$key]['description'],
                                    ]" />
                                <x-admin.form.invalid-error errorFor="features.{{ $key }}.description" />
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="card p-3 mt-2">
        <div class="row">
            <div class="mb-1 col-md-12">
                <x-admin.form.label for="meta_title" class="form-label" :asterisk="false" title="Meta Title" />
                <x-admin.form.input name="meta_title" type="text" :options="['placeholder' => 'Enter Meta Title Here...', 'class' => 'otherValidation']" />
                <x-admin.form.invalid-error errorFor="meta_title" />
            </div>
            <div class="col-md-12 mt-2">
                <x-admin.form.label for="meta_keywords" class="form-label" :asterisk="false"
                    title="Meta Keywords" />
                <x-admin.form.text-editor name="meta_keywords" :editorOptions="[
                    'id' => 'meta_keywords',
                    'placeholder' => 'Write something here...',
                    'value' => $meta_keywords,
                ]" />
                <x-admin.form.invalid-error errorFor="meta_keywords" />
            </div>
            <div class="col-md-12 mt-2">
                <x-admin.form.label for="meta_description" class="form-label" :asterisk="false"
                    title="Meta Description" />
                <x-admin.form.text-editor name="meta_description" :editorOptions="[
                    'id' => 'meta_description',
                    'placeholder' => 'Write something here...',
                    'value' => $meta_description,
                ]" />
                <x-admin.form.invalid-error errorFor="meta_description" />
            </div>
        </div>
    </div>

    @if (!$disabled)
        {{-- <div class="card mt-3 position-sticky  bottom-0" style="box-shadow:0 -4px 6px -6px rgb(0 0 0/.3);">
        <div class="row">
            <div class="col-12">
                <x-admin.form.save-button className="py-3 text-center" buttonName="{{ \App\Enums\ButtonText::UPDATE }}" target="images" />
            </div>
        </div>
    </div> --}}
        <x-admin.form.save-button className="py-3 text-end" buttonName="{{ \App\Enums\ButtonText::UPDATE }}"
            target="images" />
    @else
        <div class="mt-5"></div>
    @endif
    </div>
</form>
