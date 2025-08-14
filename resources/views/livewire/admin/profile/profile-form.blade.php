<form id="formAccountSettings" wire:submit.prevent="UpdateProfile">
    <div class="row">
        <div class="mb-3 col-md-4">
            <label for="firstName" class="form-label">Full Name <small class="text-danger">*</small></label>
            <input class="form-control {{ $errors->has('fullname') ? 'is-invalid' : '' }}" type="text" id="firstName"
                wire:model="fullname" name="firstName" placeholder="Full Name" />
            @error('fullname')
                <div class="fv-plugins-message-container invalid-feedback">
                    <div data-field="fullname" data-validator="notEmpty">
                        {{ $message }}
                    </div>
                </div>
            @enderror
        </div>
        <div class="mb-3 col-md-4">
            <label for="organization" class="form-label">Username <small class="text-danger">*</small></label>
            <input type="text" class="form-control {{ $errors->has('username') ? 'is-invalid' : '' }}" id="username"
                wire:model="username" name="username" placeholder="Username" />
            @error('username')
                <div class="fv-plugins-message-container invalid-feedback">
                    <div data-field="username" data-validator="notEmpty">
                        {{ $message }}
                    </div>
                </div>
            @enderror
        </div>
        <div class="mb-3 col-md-4">
            <label for="email" class="form-label">E-mail <small class="text-danger">*</small></label>
            <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" type="text" id="email"
                wire:model="email" name="email" placeholder="E-mail" />
            @error('email')
                <div class="fv-plugins-message-container invalid-feedback">
                    <div data-field="username" data-validator="notEmpty">
                        {{ $message }}
                    </div>
                </div>
            @enderror
        </div>

        <div class="mb-6 col-md-12">
            <label for="mail_received_email" class="form-label">Mail Received E-mail <small class="text-danger">* (use comma [,] for multiple emails)</small></label>
            <input class="form-control {{ $errors->has('mail_received_email') ? 'is-invalid' : '' }}" type="text" id="mail_received_email"
                wire:model="mail_received_email" name="mail_received_email" placeholder="E-mail" />
            @error('mail_received_email')
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
@push('js')
    <script>
        function getSelectValue(){
            @this.set('currency',$('#currency').val());
        }
        function getSelectCountry(countryid){
            @this.set('country',countryid);
            setTimeout(() => {
                $('.select2').select2();
            }, 100);
        }
    </script>
@endpush
