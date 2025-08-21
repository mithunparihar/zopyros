<section class="bgthm p-0 SecCon">
            <div class="StartTuch">
                <div class="row justify-content-between lh-1">
                    <div class="col-md-6 map pe-xl-5 pe-lg-4 h-auto"><iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3501.519140335166!2d77.16769487546323!3d28.644170583552196!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x390d02ef1d6d6159%3A0x15037bd28ff5cf3c!2sSAM%20Web%20Studio!5e0!3m2!1sen!2sin!4v1738848172392!5m2!1sen!2sin"
                            width="600" height="450" allowfullscreen fetchpriority="low" loading="lazy"
                            title="Map" referrerpolicy="no-referrer-when-downgrade"></iframe></div>
                    <div class="col-md-6 py-5 my-xl-5">
                        @if (!empty(\Content::cmsData(5)->heading))
                            <span class="SubTitle">{{ \Content::cmsData(5)->heading }}</span>
                        @endif
                        <h2 class="Heading h1">{{ \Content::cmsData(5)->title }}</h2>
                        <div class="row row-gap-4 row-xl-gap-5 mt-5">
                            <div class="col-lg-6">
                                <input type="text" placeholder="Full Name *" class="form-control">
                            </div>
                            <div class="col-lg-6">
                                <input type="email" placeholder="Email Address *" class="form-control">
                            </div>
                            <div class="col-lg-6">
                                <input type="number" placeholder="Contact No. *" maxlength="10" class="form-control">
                            </div>
                            <div class="col-lg-6">
                                <input type="text" placeholder="Subject *" class="form-control">
                            </div>
                            <div class="col-12">
                                <textarea placeholder="Message *" class="form-control"></textarea>
                                <button class="btn btn-o-thm1">Submit Now</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>