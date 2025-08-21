<div>
    <nav class="navbar menu">
        <div class="st">
            <div class="container">
                <div class="col NavMenu z-lg-2">
                    <button class="navbar-toggler order-2 collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navigatin" aria-label="MenuBar"><svg viewBox="0 0 37 30">
                            <path d="M2,2H35" />
                            <path d="M2,28H35" />
                            <path d="M2,15H26" />
                        </svg></button>
                    <span class="MenuBg"></span>
                </div>
                <div class="col logom"><a class="navbar-brand" href="{{ route('home') }}"><img loading="lazy"
                            fetchpriority="low" src="{{ \App\Enums\Url::IMG }}logo.svg"
                            alt="{{ \Content::ProjectName() }}" width="180" height="152"></a></div>
                <div class="col LastNav z-lg-3">
                    <div class="SearchBoxs">
                        <form action="#" id="Hsearch" class="collapse" tabindex="-1">
                            <div class="tabtype">
                                <a href="#Hsearch" data-bs-toggle="collapse" aria-expanded="false"
                                    aria-controls="Hsearch" title="Close" class="IconImg Dsearch collapsed"><svg
                                        viewBox="0 0 8 8">
                                        <path d="M1,7,7,1M7,7,1,1" />
                                    </svg></a>
                                <input type="text" name="search" id="SearchB" class="form-control"
                                    placeholder="Search..." autocomplete="off">
                            </div>
                        </form>
                        <label data-bs-toggle="collapse" data-bs-target="#Hsearch" for="SearchB"
                            aria-controls="Hsearch" title="Search" class="IconImg Dsearch collapsed"><svg
                                viewBox="0 0 14 14">
                                <path d="M13,13l-3-3M6,1A5,5,0,1,1,1,6,5,5,0,0,1,6,1Z" />
                            </svg></label>
                    </div>
                    <div class="btns">
                        <a href="#getInTouch" data-bs-toggle="modal" aria-expanded="false" title="Get in Touch"
                            class="btn btn-white m-0 loginB">Get in Touch</a>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <div class="navbar-collapse collapse" id="navigatin">
        <div class="NavAni">
            <div class="container">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navigatin"
                    aria-label="MenuBar"><svg viewBox="0 0 20 20">
                        <path d="M1,19,19,1M19,19,1,1" />
                    </svg></button>
                <ul class="navbar-nav">
                    <li class="nav-item active"><a href="" class="nav-link">Home</a></li>
                    <li class="nav-item"><a href="about.php" class="nav-link">About Us</a></li>
                    <li class="nav-item dropdown CatMegamenu"><a href="{{ route('categories') }}"
                            class="nav-link">Category</a>
                        <div class="dropdown-menu Megamenu Mmenu p-0 ps-md-4">
                            <div class="row">
                                @foreach ($categories as $category)
                                    <div class="col-md-6"><a class="TitleMenu fw-semibold"
                                            href="{{ route('category', ['category' => $category->fullURL()]) }}"
                                            title="{{ $category->title }}">{{ $category->title }}</a></div>
                                @endforeach
                            </div>
                        </div>
                    </li>
                    <li class="nav-item"><a href="projects.php" class="nav-link">Projects</a></li>
                    <li class="nav-item"><a href="career.php" class="nav-link">Career</a></li>
                    <li class="nav-item"><a href="testimonials.php" class="nav-link">Testimonials</a>
                    </li>
                    <li class="nav-item"><a href="contact.php" class="nav-link">Contact Us</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
