<form class="d-flex align-items-start align-items-sm-center gap-4" wire:submit.prevent="ProfileUpload"
    enctype="application/x-www-form-urlencoded">
    @if ($profile)
        @if (in_array($profile->getMimeType(), \CommanFunction::getSupportedFiles(\App\Enums\ButtonText::SUPPORTEDIMAGE)))
            <img src="{{ $profile->temporaryUrl() }}" alt="user-avatar" class="d-block rounded" height="100" width="100"
                id="uploadedAvatar" />
        @endif
    @else
        <x-image-preview width="100" class="d-block h-auto rounded" alt="user - avatar" imagepath="admin" :image="\Content::adminInfo()->profile" />
    @endif

    <div class="button-wrapper">
        <label wire:loading.remove wire:target="ProfileUpload" for="upload" class="btn btn-primary me-2 mb-2"
            tabindex="0">
            <span class="d-none d-sm-block">Choose New Photo</span>
            <i class="bx bx-upload d-block d-sm-none"></i>
            <input type="file" id="upload" class="account-file-input" wire:model="profile" hidden
                accept="image/*" />
        </label>
        @if ($profile)
            <button wire:loading.remove wire:target="ProfileUpload" wire:click="$dispatch('alert')->to('ProfileUpload')"
                type="submit" class="btn btn-label-primary account-image-reset mb-2">
                <i class="bx bx-reset d-block d-sm-none"></i>
                <span class="d-none d-sm-block">Confirm & Upload Photo</span>
            </button>
            <div class="btn btn-primary me-2 mb-2" wire:loading wire:target="ProfileUpload">
                <span class="spinner-border me-1" role="status" aria-hidden="true"></span>
                Uploading...
            </div>
        @endif
        @error('profile')
            <br> <span class="error">{{ $message }}</span>
        @enderror
        <p class="text-muted mb-0">Allowed JPG, JPEG, WEBP or PNG. Max size of 2MB</p>
        <small class="text-muted mb-0">Best image size 200px * 200px</small>
    </div>
</form>
