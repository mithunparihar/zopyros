<form wire:submit="saveCareer" class="modal-content resume" enctype="multipart/form-data">
    <div class="modal-header p-0 border-0"><button type="button" class="btn-close" data-bs-dismiss="modal"
            aria-label="Close"></button></div>
    <div class="modal-body bgthm justify-content-center shadow-lg p-4 d-flex flex-column gap-3 contact">
        <h3 class="fs-3 text-center m-0">{{ $info->title }}</h3>
        <div class="row row-gap-4">
            <div class="col-sm-6">
                <label for="name" class="form-label small lh-1 m-0 small">Name <small class="text-danger">*</small></label>
                <input type="text" wire:model="name"
                    class="form-control onlyAplha @error('name') is-invalid @enderror" id="name" name="name"
                    value="" placeholder="Enter Your Name">
                @error('name')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="col-sm-6">
                <label for="Email" class="form-label small lh-1 m-0 small">Email <small class="text-danger">*</small></label>
                <input type="text" wire:model="email"
                    class="form-control onlyEmail @error('email') is-invalid @enderror" id="Email"
                    name="email" value="" placeholder="Enter Your Email ID">
                @error('email')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="col-sm-6">
                <label for="Phone" class="form-label small lh-1 m-0 small">Phone No. <small class="text-danger">*</small></label>
                <input type="text" wire:model="phone"
                    class="form-control onlyNumber @error('phone') is-invalid @enderror" id="Phone"
                    maxlength="15" oninput="maxLengthCheck(this)" name="phone" value=""
                    placeholder="Enter Your Phone No.">
                @error('phone')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="col-sm-6">
                    <label for="experience" class="form-label small lh-1 m-0 small">Experience <small class="text-danger">*</small></label>
                <select class="form-select form-control @error('experience') is-invalid @enderror" id="experience" wire:model="experience"
                    aria-label=".form-select-lg example" name="experience">
                    <option disabled="" selected="" value="" class="d-none">Select Experience
                    </option>
                    <option value="0-1">0-1 Year</option>
                    <option value="1-2">1-2 Year</option>
                    <option value="2-5">2-5 Year</option>
                    <option value="5-8">5-8 Year</option>
                    <option value="8+">8+ Year</option>
                </select>
                @error('experience')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="col-sm-12">
                <label for="upResume" class="form-label small lh-1 m-0 small">Upload Your Resume <span
                        class="text-danger">*</span></label>
                <input type="file" wire:model="resume" class="form-control @error('resume') is-invalid @enderror"
                    id="upResume" accept=".pdf" name="resume">
                @error('resume')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="col-sm-12">
                <label for="Comments" class="form-label small lh-1 m-0 small">Cover Letter <small class="text-danger">*</small></label>
                <textarea class="form-control otherValidation @error('message') is-invalid @enderror" wire:model="message"
                    placeholder="" name="message" id="Comments"></textarea>
                @error('message')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>
        <div class="text-center">
            <button type="submit" wire:target="saveCareer" wire:loading.remove class="btn btn-black m-0">Send Now</button>
            <button wire:target="saveContact" wire:loading type="button" disabled class="btn btn-black mt-0">
                <span class="spinner-border" style="width: 18px;height:18px;font-size:10px;"></span>
                Loading...
            </button>
        </div>
    </div>
</form>
