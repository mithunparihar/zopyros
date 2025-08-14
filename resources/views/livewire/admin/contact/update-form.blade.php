<form class="pt-0 g-2" wire:submit.prevent="SaveForm" enctype="multipart/form-data">
    @csrf
    <div class="card p-3 mt-2">
        <div class="row">
            <div class="mb-1 col-md-12">
                <x-admin.form.label for="title" class="form-label" :asterisk="true">Address Title</x-admin.form.label>
                <x-admin.form.input name="title" wire:model="title" type="text" placeholder="Address Title Here..."
                    @class(['otherValidation', 'is-invalid' => $errors->has('title')]) />
                @error('title')
                    <x-admin.form.invalid-error>{{ $message }}</x-admin.form.invalid-error>
                @enderror
            </div>
            <div class="mb-1 col-md-12">
                <x-admin.form.label for="address" class="form-label" :asterisk="true">Address</x-admin.form.label>
                <x-admin.form.input name="address" wire:model="address" type="text" placeholder="Address Here..."
                    @class(['otherValidation', 'is-invalid' => $errors->has('title')]) />
                @error('address')
                    <x-admin.form.invalid-error>{{ $message }}</x-admin.form.invalid-error>
                @enderror
            </div>
            <div class="mb-1 col-md-12">
                <x-admin.form.label for="contact" class="form-label" :asterisk="true">
                    Contact Numbers <small class='text-danger'>(You can add multiple number with comma(,) )</small>
                </x-admin.form.label>
                <x-admin.form.input name="contact" wire:model="contact" type="text"
                    placeholder="Contact Number Here..." @class(['otherValidation', 'is-invalid' => $errors->has('title')]) />
                <small>NOTE: Only numeic value are allowed with comma(,) </small>
                @error('contact')
                    <x-admin.form.invalid-error>{{ $message }}</x-admin.form.invalid-error>
                @enderror
            </div>
            <div class="mb-1 col-md-12">
                <x-admin.form.label for="email" class="form-label" :asterisk="true">
                    Email Address <small class='text-danger'>(You can add multiple email address with comma(,) )</small>
                </x-admin.form.label>
                <x-admin.form.input name="email" wire:model="email" type="text" placeholder="Email Address Here..."
                    @class(['is-invalid' => $errors->has('title')]) />
                @error('email')
                    <x-admin.form.invalid-error>{{ $message }}</x-admin.form.invalid-error>
                @enderror
            </div>
        </div>
    </div>
    <div class="card mt-2 position-sticky  bottom-0" style="box-shadow:0 -4px 6px -6px rgb(0 0 0/.3);">
        <div class="row">
            <div class="col-12">
                <x-admin.form.save-button class="py-3 text-center" target="images,banner,SaveForm">
                    {{ \App\Enums\ButtonText::UPDATE }}
                </x-admin.form.save-button>
            </div>
        </div>
    </div>
</form>
