<section class="bgthm p-0 SecCon">
    <div class="StartTuch">
        @php 
            $contact = \App\Models\Contact::find(1);
        @endphp
        <div class="row justify-content-between lh-1">
            <div class="col-md-6 map pe-xl-5 pe-lg-4 h-auto">{!! $contact->google_map !!}</div>
            <div class="col-md-6 py-5 my-xl-5">
                @if (!empty(\Content::cmsData(5)->heading))
                    <span class="SubTitle">{{ \Content::cmsData(5)->heading }}</span>
                @endif
                <h2 class="Heading h1">{{ \Content::cmsData(5)->title }}</h2>
                <form wire:submit="saveContact" class="row row-gap-4 row-xl-gap-5 mt-5">
                    <div class="col-lg-6">
                        <input type="text" placeholder="Full Name *" wire:model="name"
                            class="@error('name') is-invalid @enderror form-control">
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-lg-6">
                        <input type="email" placeholder="Email Address *" wire:model="email"
                            class="@error('email') is-invalid @enderror form-control">
                        @error('email')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-lg-6">
                        <input type="number" placeholder="Contact No. *" wire:model="contact" maxlength="10"
                            class="@error('contact') is-invalid @enderror form-control">
                        @error('contact')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-lg-6">
                        <input type="text" placeholder="Subject *" wire:model="subject"
                            class="@error('subject') is-invalid @enderror form-control">
                        @error('subject')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-12">
                        <div>
                            <textarea placeholder="Message *" wire:model="message" class="@error('message') is-invalid @enderror form-control"></textarea>
                            @error('message')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <button wire:target="saveContact" wire:loading.remove class="btn btn-o-thm1">Submit Now</button>
                        <button wire:target="saveContact" wire:loading type="button" disabled
                            class="btn btn-o-thm1 Noar">
                            <span class="spinner-border" style="width: 18px;height:18px;font-size:10px;"></span>
                            Loading...
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
