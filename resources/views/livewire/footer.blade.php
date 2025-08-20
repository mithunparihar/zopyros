<footer>
    <div class="container row justify-content-sm-between justify-content-center row-gap-4">
        <div class="col-lg-3 text-center d-flex flex-column align-items-center justify-content-center gap-2 pe-lg-4">
            <a href="" class="d-inline-block mb-2"><img loading="lazy" fetchpriority="low"
                    src="{{ \App\Enums\Url::IMG }}logo.svg" alt="{{ \Content::ProjectName() }}" width="200"
                    height="168" class="flogo"></a>
            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the
                industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and
                scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap
                into electronic typesetting, remaining essentially unchanged.</p>
        </div>
        <div class="col-lg-2">
            <h3 class="mb-md-3 mb-2">Quick Link</h3>
            <div class="links">
                <a href="{{ route('home') }}">Home</a>
                <a href="{{ route('about') }}">About Us</a>
                <a href="{{ route('projects') }}">Projects</a></li>
                <a href="{{ route('awards') }}">Awards & Recognitions</a>
                <a href="{{ route('testimonials') }}">Testimonials</a>
                <a href="{{ route('team') }}">Our Team</a>
                <a href="{{ route('blog') }}">Blog</a>
            </div>
        </div>
        <div class="col-lg-2">
            <h3 class="mb-md-3 mb-2">Category</h3>
            <div class="links">
                <?php for($cat=1; $cat<=5; $cat++) { ?>
                <a href="category.php">Category <?= $cat ?></a>
                <?php } ?>
            </div>
        </div>
        <div class="col-lg-2">
            <h3 class="mb-md-3 mb-2">Information</h3>
            <div class="links">
                <a href="contact.php">Contact Us</a>
                <a href="career.php">Career</a>
                <a href="faqs.php">FAQs</a>
                <a href="privacy-policy.php">Privacy Policy</a>
                <a href="terms-and-conditions.php">Terms & Conditions</a>
                <a href="sitemap.php">Site Map</a>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="ps-lg-4">
                <h3 class="mb-md-3 mb-2">Subscribe</h3>
                <p>Get all the latest offers & info</p>
                <input type="text" class="form-control" placeholder="Enter your Email ID">
                <button class="btn btn-o-thm1">Submit</button>
            </div>
        </div>
    </div>
    <div class="fbottom">
        <div class="container row align-items-center small">
            <div class="col-lg-4 text-md-start text-center">&copy; Copyright <?= $year = date('Y') ?> <strong
                    class="text-u fw-semibold">{{ \Content::ProjectName() }}</strong>. All Rights Reserved.</div>
            <div class="col-lg-4 text-center">
                <div class="icons justify-content-center mt-3">
                    <a href="https://www.facebook.com/" target="_blank" title="Facebook"><img loading="lazy"
                            fetchpriority="low" src="{{ \App\Enums\Url::IMG }}facebook-i-w.svg" alt="Facebook"
                            width="20" height="20"></a>
                    <a href="https://www.instagram.com/" target="_blank" title="Instagram"><img loading="lazy"
                            fetchpriority="low" src="{{ \App\Enums\Url::IMG }}instagram-i-w.svg" alt="Instagram"
                            width="20" height="20"></a>
                    <a href="https://www.twitter.com/" target="_blank" title="Twitter"><img loading="lazy"
                            fetchpriority="low" src="{{ \App\Enums\Url::IMG }}twitter-i-x-w.svg" alt="Twitter"
                            width="20" height="20"></a>
                    <a href="https://www.linkedin.com/" target="_blank" title="Linkedin"><img loading="lazy"
                            fetchpriority="low" src="{{ \App\Enums\Url::IMG }}linkedin-i-w.svg" alt="Linkedin"
                            width="20" height="20"></a>
                    <a href="https://www.youtube.com/" target="_blank" title="Youtube"><img loading="lazy"
                            fetchpriority="low" src="{{ \App\Enums\Url::IMG }}youtube-i-w.svg" alt="Youtube"
                            width="20" height="20"></a>
                    <a href="https://www.pinterest.com/" target="_blank" title="Pinterest"><img loading="lazy"
                            fetchpriority="low" src="{{ \App\Enums\Url::IMG }}pinterest-i-w.svg" alt="Pinterest"
                            width="20" height="20"></a>
                    <a href="https://wa.me/<?= $Whatsapp ?? '' ?>?text=Hi,&nbsp;I&nbsp;would&nbsp;like&nbsp;to&nbsp;get&nbsp;more&nbsp;information..!"
                        target="_blank" title="Whatsapp"><img loading="lazy" fetchpriority="low"
                            src="{{ \App\Enums\Url::IMG }}whatsapp-w.svg" alt="Whatsapp" width="20"
                            height="20"></a>
                </div>
            </div>
            <div class="col-lg-4 text-md-end text-center">Made with <span class="text-danger">&#10084;</span> by <a
                    href="https://www.samwebstudio.com/" class="fw-semibold text-u" target="_blank">SAM Web
                    Studio</a></div>
        </div>
    </div>
</footer>
