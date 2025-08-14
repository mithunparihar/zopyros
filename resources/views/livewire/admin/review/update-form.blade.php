<form class="pt-0 g-2" wire:submit.prevent="SaveForm" enctype="multipart/form-data">
    @csrf
    <div class="card p-3 mt-2">
        <div class="row">
            <div class="mb-2 col-md-2">
                <x-admin.form.label for="rating" class="form-label" :asterisk="true">Rating</x-admin.form.label>
                <x-admin.form.input wire:model="rating" type="text" @class(['otherValidation', 'is-invalid' => $errors->has('rating')])
                    placeholder="Rating Here..." />
                @error('rating')
                    <x-admin.form.invalid-error>{{ $message }}</x-admin.form.invalid-error>
                @enderror
            </div>
            <div class="mb-2 col-md-2">
                <x-admin.form.label for="reviews" class="form-label" :asterisk="true">Reviews (+) </x-admin.form.label>
                <x-admin.form.input wire:model="reviews" type="text" @class(['otherValidation', 'is-invalid' => $errors->has('reviews')])
                    placeholder="eg: 50+ reviews" />
                @error('reviews')
                    <x-admin.form.invalid-error>{{ $message }}</x-admin.form.invalid-error>
                @enderror
            </div>
            <div class="mb-2 col-md-8">
                <x-admin.form.label for="url_link" class="form-label" :asterisk="true">URL Link</x-admin.form.label>
                <x-admin.form.input wire:model="url_link" type="text" @class(['otherValidation', 'is-invalid' => $errors->has('url_link')])
                    placeholder="URL Link Here..." />
                @error('url_link')
                    <x-admin.form.invalid-error>{{ $message }}</x-admin.form.invalid-error>
                @enderror
            </div>
            <div class="col-4 mt-3">
                <x-admin.form.label for="formFile" class="formFile form-label" :asterisk="true">
                    Image <small>(Size: 500px * 500px)</small>
                </x-admin.form.label>
                <x-admin.form.input wire:model="image" type="file" accept="image/*" />
                @error('image')
                    <x-admin.form.invalid-error>{{ $message }}</x-admin.form.invalid-error>
                @enderror
            </div>
            <div class="col-2 mt-3">
                @if ($image)
                    @if (in_array($image->getMimeType(), \CommanFunction::getSupportedFiles(\App\Enums\ButtonText::SUPPORTEDIMAGE)))
                        <img wire:loading.remove src="{{ $image->temporaryUrl() }}" class="defaultimg">
                    @endif
                @else
                    <x-image-preview class="defaultimg" width="150" id="blah" imagepath="review" :image="$info->image" />
                @endif
            </div>
        </div>
    </div>

    <div class="card mt-2 position-sticky  bottom-0" style="box-shadow:0 -4px 6px -6px rgb(0 0 0/.3);">
        <div class="row">
            <div class="col-12">
                <x-admin.form.save-button class="py-3 text-center" target="images,SaveForm">
                    {{ \App\Enums\ButtonText::SAVE }}
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
