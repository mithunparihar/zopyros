<form class="pt-0 g-2" wire:submit.prevent="SaveForm" enctype="multipart/form-data">
    <div class="card p-3 mt-2">
        <div class="row">
            <div class="mb-2 col-md-6">
                <x-admin.form.label for="title" class="form-label" :asterisk="true">Counter Title</x-admin.form.label>
                <x-admin.form.input wire:model="title" type="text" placeholder='Enter Counter Title Here...'
                    @class(['otherValidation', 'is-invalid' => $errors->has('title')]) />
                @error('title')
                    <x-admin.form.invalid-error>{{ $message }}</x-admin.form.invalid-error>
                @enderror
            </div>
            <div class="mb-2 col-md-6">
                <x-admin.form.label for="counter" class="form-label" :asterisk="true">Counter
                    Number</x-admin.form.label>
                <x-admin.form.input wire:model="counter" type="text" @class(['otherValidation', 'is-invalid' => $errors->has('counter')])
                    placeholder='Enter Counter Number Here...' />
                @error('counter')
                    <x-admin.form.invalid-error>{{ $message }}</x-admin.form.invalid-error>
                @enderror
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
