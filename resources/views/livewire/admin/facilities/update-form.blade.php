<form class="pt-0 row g-2" wire:submit.prevent="SaveForm" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="mb-1 col-md-12">
            <x-admin.form.label for="title" class="form-label" :asterisk="true" title="Title" />
            <x-admin.form.input name="title" type="text" :options="['placeholder' => 'Enter Title Here...', 'class' => 'otherValidation']" />
            <x-admin.form.invalid-error errorFor="title" />
        </div>
        <div class="col-md-12 mt-2">
            <x-admin.form.label for="description" class="form-label" :asterisk="true" title="Description" />
            <x-admin.form.text-editor name="description" :editorOptions="['id' => 'description', 'value' => $description]" />
            <x-admin.form.invalid-error errorFor="description" />
        </div>
        <div class="col-4 mt-3">
            <x-admin.form.label for="formFile" class="formFile form-label" :asterisk="true"
                title="Best Image <small>(Size: 90px * 90px)</small>" />
            <x-admin.form.input name="image" type="file" :options="['accept' => 'image/*']" />
            <x-admin.form.invalid-error errorFor="image" />
        </div>
        <div class="col-2 mt-3">
            @if ($image)
                @if (in_array($image->getMimeType(), \CommanFunction::getSupportedFiles(\App\Enums\ButtonText::SUPPORTEDIMAGE)))
                    <img src="{{ $image->temporaryUrl() }}" class="defaultimg">
                @endif
            @else
                <x-image-preview :options="['class' => 'defaultimg', 'id' => 'blah']" imagepath="facilities" :image="$info->image" />
            @endif
        </div>
    </div>
    <x-admin.form.save-button buttonName="{{ \App\Enums\ButtonText::UPDATE }}" target="image"  />
</form>
