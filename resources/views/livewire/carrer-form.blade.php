<form wire:submit="saveCareer" class="modal-content resume" enctype="multipart/form-data">
    <div class="modal-header p-0 border-0"><button type="button" class="btn-close" data-bs-dismiss="modal"
            aria-label="Close"></button></div>
    <div class="modal-body px-xl-4 grey d-flex flex-column gap-3 contact">
        <h3 class="fs-3 text-center m-0">{{ $info->title }}</h3>
        <div class="row row-gap-4">
            <div class="col-sm-6">
                <div class="form-floating">
                    <input type="text" wire:model="name"
                        class="form-control onlyAplha @error('name') is-invalid @enderror" id="name" name="name"
                        value="" placeholder="Name">
                    <label for="name" class="form-label">Name <small class="text-danger">*</small></label>
                </div>
                @error('name')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="col-sm-6">
                <div class="form-floating">
                    <input type="text" wire:model="email"
                        class="form-control onlyEmail @error('email') is-invalid @enderror" id="Email"
                        name="email" value="" placeholder="Email ID">
                    <label for="Email" class="form-label">Email <small class="text-danger">*</small></label>
                </div>
                @error('email')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="col-sm-6">
                <div class="d-flex gap-2">
                    <div class="form-floating w-100">
                        <input type="text" wire:model="phone"
                            class="form-control onlyNumber @error('phone') is-invalid @enderror" id="Phone"
                            maxlength="15" oninput="maxLengthCheck(this)" name="phone" value=""
                            placeholder="Phone No.">
                        <label for="Phone" class="form-label">Phone No. <small class="text-danger">*</small></label>
                    </div>
                </div>
                @error('phone')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="col-sm-6">
                <div class="form-floating">
                    <select class="form-select @error('experience') is-invalid @enderror" wire:model="experience"
                        aria-label=".form-select-lg example" name="experience">
                        <option disabled="" selected="" value="" class="d-none">Select Experience
                        </option>
                        <option value="0-1">0-1 Year</option>
                        <option value="1-2">1-2 Year</option>
                        <option value="2-5">2-5 Year</option>
                        <option value="5-8">5-8 Year</option>
                        <option value="8+">8+ Year</option>
                    </select>
                    <label for="experience" class="form-label">Experience <small class="text-danger">*</small></label>
                </div>
                @error('experience')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="col-sm-12">
                <label for="Name" class="form-label m-0">Upload Your Resume <span
                        class="text-danger">*</span></label>
                <div class="form-floating">
                    <input type="file" wire:model="resume" class="form-control @error('resume') is-invalid @enderror"
                        id="upResume" accept=".pdf" name="resume">
                </div>
                @error('resume')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="col-sm-12">
                <div class="form-floating">
                    <textarea class="form-control otherValidation @error('message') is-invalid @enderror" wire:model="message"
                        placeholder="" name="message" id="Comments"></textarea>
                    <label for="Comments">Cover Letter <small class="text-danger">*</small></label>
                </div>
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
