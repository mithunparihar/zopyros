<form class="pt-0 row g-2" wire:submit.prevent="SaveForm" enctype="multipart/form-data">
    @csrf
    @php $target=''; @endphp
    @foreach ($inputs as $key => $input)
        <div class="row">
            <div class="mb-2 col-md-3">
                <x-admin.form.label for="Type{{ $key }}" class="form-label" :asterisk="true">Gallery
                    Type</x-admin.form.label>
                @php
                    $Array = collect([['id' => 1, 'title' => 'Image'], ['id' => 2, 'title' => 'Youtube Video']]);
                @endphp
                <x-admin.form.select-box wire:model.live="inputs.{{ $key }}.type" :lists="$Array"
                    id="section" />
                @error("inputs.$key.type")
                    <x-admin.form.invalid-error>{{ $message }}</x-admin.form.invalid-error>
                @enderror
            </div>
            <div class="col-5" style="display: {{ $inputs[$key]['type'] == 1 ? 'inline' : 'none' }}">
                <x-admin.form.label for="formFile" class="formFile form-label" :asterisk="true">
                    Best Image 900px * 900px
                </x-admin.form.label>
                <x-admin.form.input wire:model="inputs.{{ $key }}.image" type="file" accept='image/*' />
                @error("inputs.$key.image")
                    <x-admin.form.invalid-error>{{ $message }}</x-admin.form.invalid-error>
                @enderror
            </div>
            <div class="col-2 mb-2" style="display: {{ $inputs[$key]['type'] == 1 ? 'inline' : 'none' }}">
                @if (!empty($inputs[$key]['image']))
                    @if (in_array(
                            $inputs[$key]['image']->getMimeType(),
                            \CommanFunction::getSupportedFiles(\App\Enums\ButtonText::SUPPORTEDIMAGE)))
                        <img src="{{ $inputs[$key]['image']->temporaryUrl() }}" class="defaultimg">
                    @endif
                @else
                    <x-image-preview class="defaultimg" width="200" imagepath="gallery" :image="$inputs[$key]['preImage']" />
                @endif
            </div>
            <div class="mb-2 col-md-7" style="display: {{ $inputs[$key]['type'] == 2 ? 'inline' : 'none' }}">
                <x-admin.form.label for="url{{ $key }}" class="form-label" :asterisk="false">
                    Youtube URL
                </x-admin.form.label>
                <x-admin.form.input wire:model="inputs.{{ $key }}.url" type="text"
                    placeholder='Youtube URL Here...' class="otherValidation" />
                @error("inputs.$key.url")
                    <x-admin.form.invalid-error>{{ $message }}</x-admin.form.invalid-error>
                @enderror
            </div>
        </div>
        @php
            if (empty($target)) {
                $target .= 'inputs.' . $key . '.image';
            } else {
                $target .= ',inputs.' . $key . '.image';
            }

        @endphp
    @endforeach
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
