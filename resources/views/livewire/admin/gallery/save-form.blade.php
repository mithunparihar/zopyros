<form class="pt-0 row g-2" wire:submit.prevent="SaveForm" enctype="multipart/form-data">
    @csrf
    @php $target=''; @endphp
    @foreach ($inputs as $key => $input)
        <div class="row">
            <div class="mb-2 col-md-1">{{ $loop->iteration }}.</div>
            <div class="mb-2 col-md-3">
                <x-admin.form.label for="Type{{ $key }}" class="form-label" :asterisk="true">Gallery
                    Type</x-admin.form.label>
                @php
                    $Array = collect([
                        ['id' => 1, 'title' => 'Image'], 
                        ['id' => 2, 'title' => 'Youtube Video']
                    ]);
                @endphp
                <x-admin.form.select-box wire:model.live="inputs.{{ $key }}.type" :lists="$Array" id="section" />
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
                    <img src="{{ asset('admin/img/no-img.jpg') }}" class="defaultimg" id="blah">
                @endif
            </div>
            <div class="mb-2 col-md-7" style="display: {{ $inputs[$key]['type'] == 2 ? 'inline' : 'none' }}">
                <x-admin.form.label for="url{{ $key }}" class="form-label" :asterisk="true">
                    Youtube URL
                </x-admin.form.label>
                <x-admin.form.input wire:model="inputs.{{ $key }}.url" type="text"
                    placeholder='Youtube URL Here...' class="otherValidation" />
                @error("inputs.$key.url")
                    <x-admin.form.invalid-error>{{ $message }}</x-admin.form.invalid-error>
                @enderror
            </div>
            <div class="mt-1 col-md-1">
                @if ($loop->iteration > 1)
                    <x-admin.form.label for="title" class="form-label" :asterisk="false" title=" " />
                    <button class="btn btn-danger sws-bounce sws-top" data-title="Remove" type="button"
                        wire:confirm="Are you sure! You want to remove this field?"
                        wire:click="removeGallery('{{ $key }}')"><i class="fa fa-trash"></i></button>
                @endif
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
    <div class="row align-items-center">
        <div class="col-6">
            <button class="btn btn-primary btn-sm" type="button" wire:click="AddMoreGallery"><i
                    class="fa fa-plus me-1"></i> Add More</button>
        </div>
        <div class="col-6 row">
            <x-admin.form.save-button class="py-3 text-center" target="images,SaveForm">
                {{ \App\Enums\ButtonText::SAVE }}
            </x-admin.form.save-button>
        </div>
    </div>
</form>
