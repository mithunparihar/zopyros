<form id="enableOTPForm" class="row g-3" wire:submit.prevent="EnableTwoStep">
    
    <div class="col-12">
        <label class="form-label" for="modalEnableOTPPhone">Email Address <small class="text-danger">*</small></label>
        <div>
            <input type="text" 
                id="modalEnableOTPPhone" 
                wire:model="verification_email"
                class="form-control phone-number-otp-mask {{$errors->has('verification_email') ? 'is-invalid' : ''}}" 
                placeholder="example@gmail.com"
             />
             @error('verification_email')
                <div class="fv-plugins-message-container invalid-feedback">
                    <div data-field="username" data-validator="notEmpty">
                        {{ $message }}
                    </div>
                </div>
            @enderror
        </div>
    </div>
    <div class="col-12 text-center">
        <button type="submit" wire:loading.remove wire:target="EnableTwoStep" class="btn btn-primary me-sm-3 me-1">Submit</button>
        <button wire:loading wire:target="EnableTwoStep" class="btn btn-primary me-2" type="button" disabled="">
            <span class="spinner-border me-1" role="status" aria-hidden="true"></span>
            Loading...
        </button>
        <button type="reset" class="btn btn-label-secondary" onclick="window.location.reload()" >Cancel</button>
    </div>
</form>