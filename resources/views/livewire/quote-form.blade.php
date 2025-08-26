<form wire:submit="saveData" class="bgthm rounded-3 shadow-lg p-4 d-flex flex-column gap-3" enctype="multipart/form-data">
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    <h2 class="h5 text-center fw-bold text-u m-0 lh-1">Get a Quote</h2>
    <div>
        <label for="OName" class="form-label small lh-1 m-0 small">Your Name<span class="text-danger">*</span></label>
        <input class="form-control border-dark-subtle  @error('name') is-invalid @enderror" id="OName"
            wire:model="name" type="text" placeholder="Your Name" onkeypress="return /[a-z ]/i.test(event.key)"
            maxlength="30">
        @error('name')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
    <div>
        <label for="Ocontact" class="form-label small lh-1 m-0 small">Your Contact No.<span
                class="text-danger">*</span></label>
        <input class="form-control border-dark-subtle  @error('contact') is-invalid @enderror" id="Ocontact"
            wire:model="contact" type="tel" placeholder="Your Contact No"
            onkeypress="return event.charCode >= 48 && event.charCode <= 57" maxlength="10">
        @error('contact')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
    <div>
        <label for="OEmail" class="form-label small lh-1 m-0 small">Your Email ID<span
                class="text-danger">*</span></label>
        <input class="form-control border-dark-subtle @error('email') is-invalid @enderror" id="OEmail"
            wire:model="email" type="email" placeholder="Your Email ID"
            onkeypress="return /[a-zA-z0-9@_.-]/i.test(event.key)" maxlength="30">
        @error('email')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
    <div>
        <label for="OMessage" class="form-label m-0 small">Message</label>
        <textarea class="form-control border-dark-subtle @error('message') is-invalid @enderror " id="OMessage"
            wire:model="message" placeholder="Write something here..."></textarea>
        @error('message')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
    <div class="text-center">
        @error('other')
            <span class="text-danger">{{ $message }}</span>
        @enderror
        <button wire:target="saveData" wire:loading.remove type="submit"
            class="btn btn-black mt-0 gap-2">Submit</button>
        <button wire:target="saveData" wire:loading type="button" disabled class="btn btn-black mt-0 gap-2">
            <span class="spinner-border" style="width: 18px;height:18px;font-size:10px;"></span>
            Loading...
        </button>
        <div class="mt-2 small text-white"><small>By clicking Submit, I accept the <a href="{{ route('terms') }}"
                    target="_blank" class="text-black">T&C</a> and <a href="{{ route('privacy') }}" class="text-black"
                    target="_blank">Privacy
                    Policy</a>.</small></div>
    </div>
</form>
