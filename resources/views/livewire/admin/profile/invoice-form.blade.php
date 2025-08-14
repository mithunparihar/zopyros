<form id="formAccountSettings" wire:submit.prevent="UpdateProfile">
    <div class="row">
        <div class="mb-3 col-md-6">
            <label for="firstName" class="form-label">Phone Number <small class="text-danger">* (use comma [,] for multiple emails)</small></label>
            <input class="form-control {{ $errors->has('phonenumber') ? 'is-invalid' : '' }}" type="text" id="firstName"
                wire:model="phonenumber" name="firstName" placeholder="Enter Phone Number Here..." />
            @error('phonenumber')
                <div class="fv-plugins-message-container invalid-feedback">
                    <div data-field="fullname" data-validator="notEmpty">
                        {{ $message }}
                    </div>
                </div>
            @enderror
        </div>
        <div class="mb-3 col-md-6">
            <label for="email" class="form-label">Email <small class="text-danger">* (use comma [,] for multiple emails)</small></label>
            <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" type="text" id="email"
                wire:model="email" name="email" placeholder="Enter Email Here..." />
            @error('email')
                <div class="fv-plugins-message-container invalid-feedback">
                    <div data-field="username" data-validator="notEmpty">
                        {{ $message }}
                    </div>
                </div>
            @enderror
        </div>
        <div class="mb-3 col-md-12">
            <label for="address" class="form-label">Address <small class="text-danger">*</small></label>
            <textarea wire:model="address" class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}" id="address" placeholder="Enter Address Here..."></textarea>
            @error('address')
                <div class="fv-plugins-message-container invalid-feedback">
                    <div data-field="username" data-validator="notEmpty">
                        {{ $message }}
                    </div>
                </div>
            @enderror
        </div>
    </div>
    <div class="mt-2 text-end">
        <x-admin.form.save-button class="py-3" target="UpdateProfile">
            {{ \App\Enums\ButtonText::UPDATE }}
        </x-admin.form.save-button>
    </div>
</form>
