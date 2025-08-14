<nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
    id="layout-navbar">
    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none"><a
            class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)"><i class="bx bx-menu bx-sm"></i></a></div>
    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
        <div class="navbar-nav align-items-center">
            {{-- <div class="nav-item navbar-search-wrapper mb-0"><a class="nav-item nav-link search-toggler px-0" href="javascript:void(0);"><i class="bx bx-search bx-sm"></i><span class="d-none d-md-inline-block text-muted">Search (Ctrl+/)</span></a></div> --}}
        </div>
        <ul class="navbar-nav flex-row align-items-center ms-auto">
            <li class="nav-item dropdown-style-switcher dropdown me-2 me-xl-0">
                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown"><i
                        class='bx bx-sm'></i></a>
                <ul class="dropdown-menu dropdown-menu-end dropdown-styles">
                    <li><a class="dropdown-item" href="javascript:void(0);" data-theme="light"><span
                                class="align-middle"><i class='bx bx-sun me-2'></i>Light</span></a></li>
                    <li><a class="dropdown-item" href="javascript:void(0);" data-theme="dark"><span
                                class="align-middle"><i class="bx bx-moon me-2"></i>Dark</span></a></li>
                    <li><a class="dropdown-item" href="javascript:void(0);" data-theme="system"><span
                                class="align-middle"><i class="bx bx-desktop me-2"></i>System</span></a></li>
                </ul>
            </li>
            <li class="nav-item dropdown-notifications navbar-dropdown dropdown me-3 me-xl-1">

                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown"
                    data-bs-auto-close="outside" aria-expanded="false">
                    <i id="badge-notifications-bell"
                        class="{{ count(\Content::adminInfo()->unreadnotifications) > 0 ? 'bell text-dark' : '' }}  bx bx-bell bx-sm"></i>
                    <span id="badge-notifications"
                        class="badge bg-danger rounded-pill badge-notifications">{{ count(\Content::adminInfo()->unreadnotifications) }}</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end py-0">
                    <li class="dropdown-menu-header border-bottom">
                        <div class="dropdown-header d-flex align-items-center py-3">
                            <h5 class="text-body mb-0 me-auto">Notification</h5>
                            <audio id="bellSound" src="{{ asset('frontend/sound/cartoon-bell.wav') }}" preload="auto"></audio>

                        </div>
                    </li>
                    <li class="dropdown-notifications-list scrollable-container">
                        <ul class="list-group list-group-flush" id="badge-notifications-list">
                            @if (count(\Content::adminInfo()->unreadnotifications) == 0)
                                <li class="list-group-item list-group-item-action dropdown-notifications-item"
                                    style="cursor: auto;">
                                    <p class="mb-0 text-center">No notifications pending to read</p>
                                </li>
                            @endif

                            @foreach (\Content::adminInfo()->unreadnotifications as $notifications)
                                <li class="list-group-item list-group-item-action dropdown-notifications-item"
                                    style="cursor: auto;">
                                    <div class="d-flex align-items-start">
                                        <a role="button"
                                            wire:click='redirectData("{{ \CommanFunction::getNotificationType($notifications)[3] }}","{{ $notifications->type }}")'
                                            class="flex-shrink-0 me-3">
                                            <div class="avatar">
                                                <span
                                                    class="avatar-initial rounded-circle bg-label-{{ \CommanFunction::getNotificationType($notifications)[2] }}">
                                                    {{ \CommanFunction::getNotificationType($notifications)[0] }}
                                                </span>
                                            </div>
                                        </a>
                                        <div class="flex-grow-1">
                                            {{-- <h6 class="mb-1">Charles Franklin</h6> --}}
                                            <a role="button"
                                                wire:click='redirectData("{{ \CommanFunction::getNotificationType($notifications)[3] }}","{{ $notifications->type }}")'
                                                class="mb-0">
                                                {!! \CommanFunction::getNotificationType($notifications)[1] !!}</a>
                                            <small
                                                class="text-muted d-block">{{ $notifications->created_at->diffForHumans() }}</small>
                                        </div>
                                        <div class="flex-shrink-0 dropdown-notifications-actions">
                                            {{-- <a href="javascript:void(0)" class="dropdown-notifications-read"><span class="badge badge-dot"></span></a> --}}
                                            <a
                                                href="{{ route('admin.notifications.remove', ['id' => $notifications->id]) }}"><span
                                                    class="bx bx-x"></span></a>
                                        </div>
                                    </div>
                                </li>
                                @if ($loop->iteration > 8)
                                    @break
                                @endif
                            @endforeach
                        </ul>
                    </li>
                    <li class="dropdown-menu-footer border-top p-3">
                        <a href="{{ route('admin.notifications') }}"
                            class="btn btn-primary btn-sm text-uppercase w-100">view all notifications</a>
                    </li>
                </ul>
            </li>
            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                    <div class="avatar avatar-online">
                        <x-image-preview class="w-px-40 h-auto rounded-circle" alt="{{ \Content::adminInfo()->name }}"
                            imagepath="admin" width="100" :image="\Content::adminInfo()->profile" />
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <a class="dropdown-item" href="{{ route('admin.profile') }}">
                            <div class="d-flex">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar avatar-online">
                                        <x-image-preview width="100" alt="{{ \Content::adminInfo()->name }}" class="w-px-40 h-auto rounded-circle" imagepath="admin" :image="\Content::adminInfo()->profile" />
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <span class="fw-semibold d-block">{{ \Content::adminInfo()->name }}</span>
                                    <small class="text-muted">
                                        @if (\Content::adminInfo()->role == 0)
                                            Administrator
                                        @endif
                                    </small>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <div class="dropdown-divider"></div>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('admin.profile') }}">
                            <i class="bx bx-user me-2"></i>
                            <span class="align-middle">My Profile</span>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('admin.security') }}">
                            <i class="bx bx-lock-alt me-2"></i>
                            <span class="align-middle">Security</span>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('admin.socialMedia') }}">
                            <i class="bx bx-link me-2"></i>
                            <span class="align-middle">Social Media</span>
                        </a>
                    </li>
                    <li>
                        <div class="dropdown-divider"></div>
                    </li>
                    <li>
                        <a class="dropdown-item" href="javascript:void(0)"
                            wire:confirm="Do you really want to log out? You will be signed out of your account."
                            wire:click="Logout">
                            <i class="bx bx-power-off me-2"></i>
                            <span class="align-middle">Log Out</span>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
    <div class="navbar-search-wrapper search-input-wrapper d-none">
        <input type="text" class="form-control search-input container-xxl border-0" placeholder="Search..."
            aria-label="Search...">
        <i class="bx bx-x bx-sm search-toggler cursor-pointer"></i>
    </div>
</nav>
