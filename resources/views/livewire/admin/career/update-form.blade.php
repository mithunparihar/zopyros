<form class="pt-0 g-2" wire:submit.prevent="SaveForm" enctype="multipart/form-data">
    <div class="card p-3 mt-2">
        <div class="row">
            <div class="mb-2 col-md-6">
                <x-admin.form.label for="title" class="form-label" :asterisk="true">Title</x-admin.form.label>
                <x-admin.form.input wire:model="title" type="text" placeholder='Enter Title Here...'
                    @class(['otherValidation', 'is-invalid' => $errors->has('title')]) />
                @error('title')
                    <x-admin.form.invalid-error>{{ $message }}</x-admin.form.invalid-error>
                @enderror
            </div>
            <div class="mb-2 col-md-6">
                <x-admin.form.label for="designation" class="form-label"
                    :asterisk="true">Designation</x-admin.form.label>
                <x-admin.form.input wire:model="designation" type="text" @class([
                    'otherValidation',
                    'is-invalid' => $errors->has('designation'),
                ])
                    placeholder='Enter Designation Here...' />
                @error('designation')
                    <x-admin.form.invalid-error>{{ $message }}</x-admin.form.invalid-error>
                @enderror
            </div>
            <div class="mb-1 col-md-4">
                <x-admin.form.label for="location" class="form-label" :asterisk="true">Location</x-admin.form.label>
                <x-admin.form.input wire:model="location" type="text" @class(['otherValidation', 'is-invalid' => $errors->has('location')])
                    placeholder='Enter Location Here...' />
                @error('location')
                    <x-admin.form.invalid-error>{{ $message }}</x-admin.form.invalid-error>
                @enderror
            </div>
            <div class="mb-1 col-md-4">
                <x-admin.form.label for="salary" class="form-label" :asterisk="true">Salary</x-admin.form.label>
                <x-admin.form.input wire:model="salary" type="text" @class(['otherValidation', 'is-invalid' => $errors->has('salary')])
                    placeholder='Eg: 1200000 LPA' />
                @error('salary')
                    <x-admin.form.invalid-error>{{ $message }}</x-admin.form.invalid-error>
                @enderror
            </div>
            <div class="mb-1 col-md-4">
                <x-admin.form.label for="job_type" class="form-label" :asterisk="true">
                    Job Type <small>(eg: Full Time, Part Time )</small>
                </x-admin.form.label>
                <x-admin.form.input wire:model="job_type" type="text" @class(['otherValidation', 'is-invalid' => $errors->has('job_type')])
                    placeholder='Enter Job Type Here...' />
                @error('job_type')
                    <x-admin.form.invalid-error>{{ $message }}</x-admin.form.invalid-error>
                @enderror
            </div>
            <div class="col-md-12 mt-2">
                <x-admin.form.label for="short_description" class="form-label" :asterisk="true">Short
                    Description</x-admin.form.label>
                <x-admin.form.text-editor wire:model="short_description" @class([
                    'otherValidation',
                    'is-invalid' => $errors->has('short_description'),
                ])
                    placeholder='Enter Short Description Here...' />
                @error('short_description')
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
                <x-admin.form.text-editor wire:model="description" ignore="true" id="description"
                    class="summernote">{{ $description }}</x-admin.form.text-editor>
                    @error('description')
                    <x-admin.form.invalid-error>{{ $message }}</x-admin.form.invalid-error>
                @enderror
            </div>
        </div>
    </div>
    <div class="card p-3 mt-2">
        <div class="row">
            <div class="mb-1 col-md-12">
                <x-admin.form.label for="meta_title" class="form-label" :asterisk="false">Meta
                    Title</x-admin.form.label>
                <x-admin.form.input wire:model="meta_title" @class(['otherValidation', 'is-invalid' => $errors->has('meta_title')]) type="text" placeholder="Enter Meta Title Here..." />
                @error('meta_title')
                    <x-admin.form.invalid-error>{{ $message }}</x-admin.form.invalid-error>
                @enderror
            </div>
            <div class="col-md-12 mt-2">
                <x-admin.form.label for="meta_keywords" class="form-label" :asterisk="false">Meta
                    Keywords</x-admin.form.label>
                <x-admin.form.text-editor wire:model="meta_keywords" @class(['otherValidation', 'is-invalid' => $errors->has('meta_keywords')]) placeholder='Write something here...' />
                @error('meta_keywords')
                    <x-admin.form.invalid-error>{{ $message }}</x-admin.form.invalid-error>
                @enderror
            </div>
            <div class="col-md-12 mt-2">
                <x-admin.form.label for="meta_description" class="form-label" :asterisk="false">Meta
                    Description</x-admin.form.label>
                <x-admin.form.text-editor wire:model="meta_description" @class(['otherValidation', 'is-invalid' => $errors->has('meta_description')]) placeholder='Write something here...' />
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
