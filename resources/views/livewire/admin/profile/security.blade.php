<form id="formAccountSettings" wire:submit.prevent="Submit">
    <div class="row">
        <div class="mb-3 col-md-6 form-password-toggle">
            <x-admin.form.label :asterisk="true" for="currentPassword">Current Password</x-admin.form.label>
            <div class="input-group input-group-merge">
                <input
                    class="form-control {{$errors->has('currentPassword') ? 'is-invalid' : ''}}"
                    type="password"
                    wire:model="currentPassword"
                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" />
                <span class="input-group-text cursor-pointer {{ $errors->has('currentPassword') ? 'is-invalid' : '' }}"><i class="bx bx-hide"></i></span>
                @error('currentPassword')
                    <div class="fv-plugins-message-container invalid-feedback">
                        <div data-field="username" data-validator="notEmpty">
                            {{ $message }}
                        </div>
                    </div>
                @enderror
            </div>
        </div>
    </div>
    <div class="row">
        <div class="mb-3 col-md-6 form-password-toggle">
            <x-admin.form.label :asterisk="true" for="newPassword">New Password</x-admin.form.label>
            <div class="input-group input-group-merge">
                <input
                    class="form-control {{$errors->has('newPassword') ? 'is-invalid' : ''}}"
                    type="password"
                    wire:model="newPassword"
                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" />
                <span class="input-group-text cursor-pointer {{ $errors->has('newPassword') ? 'is-invalid' : '' }}"><i class="bx bx-hide"></i></span>
                @error('newPassword')
                    <div class="fv-plugins-message-container invalid-feedback">
                        <div data-field="username" data-validator="notEmpty">
                            {{ $message }}
                        </div>
                    </div>
                @enderror
            </div>
        </div>

        <div class="mb-3 col-md-6 form-password-toggle">
            <x-admin.form.label :asterisk="true" for="cnewPassword">Confirm New Password</x-admin.form.label>
            <div class="input-group input-group-merge">
                <input
                    class="form-control {{$errors->has('confirmPassword') ? 'is-invalid' : ''}}"
                    type="password"
                    wire:model="confirmPassword"
                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" />
                <span class="input-group-text cursor-pointer {{ $errors->has('confirmPassword') ? 'is-invalid' : '' }}"><i class="bx bx-hide"></i></span>
                @error('confirmPassword')
                    <div class="fv-plugins-message-container invalid-feedback">
                        <div data-field="username" data-validator="notEmpty">
                            {{ $message }}
                        </div>
                    </div>
                @enderror
            </div>
        </div>
        <div class="col-12 mb-4">
            <p class="fw-semibold mt-2">Password Requirements:</p>
            <ul class="ps-3 mb-0">
                <li class="mb-1">
                    Minimum 8 characters long - the more, the better
                </li>
                <li class="mb-1">At least one upper and one lowercase character</li>
                <li>At least one number & symbol</li>
            </ul>
        </div>
        <div class="col-12 mt-1">
            <button type="submit" wire:loading.remove wire:target="Submit" class="btn btn-primary me-2">Save changes</button>
            <button wire:loading wire:target="Submit" class="btn btn-primary me-2" type="button" disabled="">
                <span class="spinner-border me-1" role="status" aria-hidden="true"></span>
                Loading...
            </button>

            <button type="reset" class="btn btn-label-secondary">Cancel & Reset</button>
        </div>
    </div>
</form>