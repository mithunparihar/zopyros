<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand justify-content-center demo ">
        <a href="{{ route('admin.dashboard') }}" class="app-brand-link">
            <span class="app-brand-logo demo">
                <img src="{{ asset('admin/img/logo.svg') }}" alt="{{ \Content::ProjectName() }}">
            </span>
        </a>
        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>
    <div class="menu-inner-shadow"></div>
    <ul class="menu-inner py-1 ps--scrolling-y">
        <li class="menu-item {{ request()->segment(2) == 'dashboard' ? 'active' : '' }}">
            <a href="{{ route('admin.dashboard') }}" class="menu-link ">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Dashboard">Dashboard</div>
            </a>
        </li>
        <li
            class="menu-item {{ in_array(request()->segment(2), ['banner']) || (request()->segment(2) == 'cms' && in_array(request()->segment(3), [1, 2, 3, 4, 5, 6])) ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class='menu-icon tf-icons bx bx-spreadsheet'></i>
                <div class="text-truncate" data-i18n="Home Page">Home Page</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->segment(2) == 'banner' ? 'active' : '' }}">
                    <a href="{{ route('admin.banner.index') }}" class="menu-link">
                        <div class="text-truncate" title="Banner Management" data-i18n="Banner">Banner</div>
                    </a>
                </li>
                <li
                    class="menu-item {{ request()->segment(2) == 'cms' && request()->segment(3) == 1 ? 'active' : '' }}">
                    <a href="{{ route('admin.cms.edit', ['cm' => 1]) }}" class="menu-link">
                        <div class="text-truncate" title="About Us" data-i18n="About Us">
                            About Us</div>
                    </a>
                </li>
                <li
                    class="menu-item {{ request()->segment(2) == 'cms' && request()->segment(3) == 2 ? 'active' : '' }}">
                    <a href="{{ route('admin.cms.edit', ['cm' => 2]) }}" class="menu-link">
                        <div class="text-truncate" title="Category Section (Heading)"
                            data-i18n="Category Section (Heading)">
                            Category Section (Heading)</div>
                    </a>
                </li>
                <li
                    class="menu-item {{ request()->segment(2) == 'cms' && request()->segment(3) == 3 ? 'active' : '' }}">
                    <a href="{{ route('admin.cms.edit', ['cm' => 3]) }}" class="menu-link">
                        <div class="text-truncate" title="Product Section (Heading)"
                            data-i18n="Product Section (Heading)">
                            Product Section (Heading)</div>
                    </a>
                </li>
                <li
                    class="menu-item {{ request()->segment(2) == 'cms' && request()->segment(3) == 4 ? 'active' : '' }}">
                    <a href="{{ route('admin.cms.edit', ['cm' => 4]) }}" class="menu-link">
                        <div class="text-truncate" title="Blog Section (Heading)" data-i18n="Blog Section (Heading)">
                            Blog Section (Heading)</div>
                    </a>
                </li>
                <li
                    class="menu-item {{ request()->segment(2) == 'cms' && request()->segment(3) == 5 ? 'active' : '' }}">
                    <a href="{{ route('admin.cms.edit', ['cm' => 5]) }}" class="menu-link">
                        <div class="text-truncate" title="Contact Section (Heading)"
                            data-i18n="Contact Section (Heading)">
                            Contact Section (Heading)</div>
                    </a>
                </li>
                <li
                    class="menu-item {{ request()->segment(2) == 'cms' && request()->segment(3) == 6 ? 'active' : '' }}">
                    <a href="{{ route('admin.cms.edit', ['cm' => 6]) }}" class="menu-link">
                        <div class="text-truncate" title="Testimonial Section (Heading)"
                            data-i18n="Testimonial Section (Heading)">
                            Testimonial Section (Heading)</div>
                    </a>
                </li>
            </ul>
        </li>


        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Categories & Products</span>
        </li>
        <li class="menu-item @if (request()->segment(2) == 'categories' || (request()->segment(2) == 'cms' && request()->segment(3) == '16')) active @endif">
            <a href="{{ route('admin.categories.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bxs-category"></i>
                <div data-i18n="Categories">Categories</div>
            </a>
        </li>
        <li class="menu-item @if (request()->segment(2) == 'variants') active @endif">
            <a href="{{ route('admin.variants.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bxs-cube"></i>
                <div data-i18n="Variants">Variants</div>
            </a>
        </li>
        <li class="menu-item @if (request()->segment(2) == 'products') active @endif">
            <a href="{{ route('admin.products.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bxs-box"></i>
                <div data-i18n="Products">Products</div>
            </a>
        </li>

        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Inquiry Management</span>
        </li>
        <li class="menu-item @if (request()->segment(2) == 'enquiry' && request()->segment(3) == 'contact') active @endif">
            <a role="button" wire:click='redirectData("{{ route('admin.enquiry.contact') }}","contact")'
                class="menu-link">
                <i class="menu-icon tf-icons bx bx-detail"></i>
                <div data-i18n="Contact Enquiry">Contact</div>
                <span style="display:{{ ($contactCount ?? 0) > 0 ? 'block' : 'none' }}" id="contactNotification"
                    class="badge rounded-pill bg-primary ms-auto">{{ $contactCount ?? 0 }}</span>
            </a>
        </li>
        <li class="menu-item @if (request()->segment(2) == 'enquiry' && request()->segment(3) == 'career') active @endif">
            <a role="button" wire:click='redirectData("{{ route('admin.enquiry.career') }}","career")'
                class="menu-link">
                <i class="menu-icon tf-icons bx bx-user"></i>
                <div data-i18n="Career">Career</div>
                <span style="display:{{ ($careerCount ?? 0) > 0 ? 'block' : 'none' }}" id="careerNotification"
                    class="badge rounded-pill bg-dark ms-auto">{{ $careerCount ?? 0 }}</span>
            </a>
        </li>
        <li class="menu-item @if (request()->segment(2) == 'enquiry' && request()->segment(3) == 'subscribe') active @endif">
            <a role="button" wire:click='redirectData("{{ route('admin.enquiry.subscribe') }}","subscribe")'
                class="menu-link">
                <i class="menu-icon tf-icons bx bxs-comment-detail"></i>
                <div data-i18n="Newsletter">Newsletter</div>
                <span style="display:{{ ($subscribeNotification ?? 0) > 0 ? 'block' : 'none' }}"
                    id="subscribeNotification"
                    class="badge rounded-pill bg-info ms-auto">{{ $subscribeNotification }}</span>
            </a>
        </li>


        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Quick Link</span>
        </li>
        <li
            class="menu-item {{ in_array(request()->segment(2), ['team', 'insurance']) || (request()->segment(2) == 'cms' && in_array(request()->segment(3), [7, 8, 9])) ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class='menu-icon tf-icons bx bx-spreadsheet'></i>
                <div class="text-truncate" data-i18n="About Us">About Us</div>
            </a>
            <ul class="menu-sub">
                <li
                    class="menu-item {{ request()->segment(2) == 'cms' && request()->segment(3) == 7 ? 'active' : '' }}">
                    <a href="{{ route('admin.cms.edit', ['cm' => 7]) }}" class="menu-link">
                        <div class="text-truncate" title="About Us" data-i18n="About Us">
                            About Us</div>
                    </a>
                </li>
                <li
                    class="menu-item {{ request()->segment(2) == 'cms' && request()->segment(3) == 8 ? 'active' : '' }}">
                    <a href="{{ route('admin.cms.edit', ['cm' => 8]) }}" class="menu-link">
                        <div class="text-truncate" title="Our Mission" data-i18n="Our Mission">
                            Our Mission</div>
                    </a>
                </li>
                <li
                    class="menu-item {{ request()->segment(2) == 'cms' && request()->segment(3) == 9 ? 'active' : '' }}">
                    <a href="{{ route('admin.cms.edit', ['cm' => 9]) }}" class="menu-link">
                        <div class="text-truncate" title="Our Vision" data-i18n="Our Vision">Our Vision</div>
                    </a>
                </li>
            </ul>
        </li>

        <li class="menu-item @if (in_array(request()->segment(2), ['projects']) || (request()->segment(2) == 'cms' && request()->segment(3) == '13')) active @endif">
            <a href="{{ route('admin.projects.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bxs-customize"></i>
                <div data-i18n="Projects">Projects</div>
            </a>
        </li>
        <li class="menu-item @if (in_array(request()->segment(2), ['awards'])) active @endif">
            <a href="{{ route('admin.awards.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bxs-award"></i>
                <div data-i18n="Awards & Recognitions">Awards & Recognitions</div>
            </a>
        </li>
        <li class="menu-item @if (in_array(request()->segment(2), ['testimonial']) ||
                (request()->segment(2) == 'cms' && request()->segment(3) == '10')) active @endif">
            <a href="{{ route('admin.testimonial.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bxs-user-badge"></i>
                <div data-i18n="Testimonials">Testimonials</div>
            </a>
        </li>
        <li class="menu-item @if (in_array(request()->segment(2), ['team']) || (request()->segment(2) == 'cms' && request()->segment(3) == '15')) active @endif">
            <a href="{{ route('admin.team.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bxs-user-account"></i>
                <div data-i18n="Our Team">Our Team</div>
            </a>
        </li>
        <li class="menu-item @if (in_array(request()->segment(2), ['blog', 'blog-category']) ||
                (request()->segment(2) == 'cms' && request()->segment(3) == '8')) active @endif">
            <a href="{{ route('admin.blog.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bxl-blogger"></i>
                <div data-i18n="Blog">Blog</div>
            </a>
        </li>

        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Information</span>
        </li>
        <li class="menu-item @if (in_array(request()->segment(2), ['contact-information'])) active @endif">
            <a href="{{ route('admin.contact-information.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bxs-contact"></i>
                <div data-i18n="Contact">Contact</div>
            </a>
        </li>
        <li class="menu-item @if (in_array(request()->segment(2), ['career']) || (request()->segment(2) == 'cms' && request()->segment(3) == '14')) active @endif">
            <a href="{{ route('admin.career.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bxs-user-badge"></i>
                <div data-i18n="Career">Career</div>
            </a>
        </li>
        <li class="menu-item @if (in_array(request()->segment(2), ['faq', 'faq-category']) ||
                (request()->segment(2) == 'cms' && request()->segment(3) == '16')) active @endif">
            <a href="{{ route('admin.faq.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-sitemap"></i>
                <div data-i18n="FAQs">FAQs</div>
            </a>
        </li>
        <li class="menu-item @if (request()->segment(2) == 'cms' && request()->segment(3) == '11') active @endif">
            <a href="{{ route('admin.cms.edit', ['cm' => 11]) }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-detail"></i>
                <div data-i18n="Terms & Conditions">Terms & Conditions</div>
            </a>
        </li>
        <li class="menu-item @if (request()->segment(2) == 'cms' && request()->segment(3) == '12') active @endif">
            <a href="{{ route('admin.cms.edit', ['cm' => 12]) }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-detail"></i>
                <div data-i18n="Privacy Policy">Privacy Policy</div>
            </a>
        </li>

        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Others Links</span>
        </li>

        <li class="menu-item  @if (request()->segment(2) == 'countries') active @endif">
            <a href="{{ route('admin.countries.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bxs-map"></i>
                <div data-i18n="Countries">Countries</div>
            </a>
        </li>
        <li class="menu-item @if (request()->segment(2) == 'meta') active @endif">
            <a href="{{ route('admin.meta.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bxs-detail"></i>
                <div data-i18n="Meta Management">Meta Management</div>
            </a>
        </li>
    </ul>
</aside>
