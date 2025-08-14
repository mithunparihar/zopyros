<form class="pt-0 g-2" wire:submit.prevent="UpdateForm" enctype="multipart/form-data">
    @csrf
    <div class="card p-3 mt-2">
        <div class="row">
            <div class="col-md-12 mb-2">
                <x-admin.form.label for="title" class="form-label" :asterisk="true">Name / Title</x-admin.form.label>
                <x-admin.form.input name="title" wire:model="title" type="text" placeholder="Enter Title Here..."
                    @class(['otherValidation', 'is-invalid' => $errors->has('title')]) />
                @error('title')
                    <x-admin.form.invalid-error>{{ $message }}</x-admin.form.invalid-error>
                @enderror
            </div>
            <div class="col-md-12 mb-2">
                <x-admin.form.label for="alias" class="form-label" :asterisk="true">URL Alias</x-admin.form.label>
                <x-admin.form.input name="alias" wire:model="alias" type="text"
                    placeholder="Enter URL Alias Here..." @class(['otherValidation', 'is-invalid' => $errors->has('alias')]) />
                @error('alias')
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
