<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <!-- Dark Logo-->
        <a href="index-2.html" class="logo logo-dark">
            <span class="logo-sm">
                <img src="{{ asset('dashboard/assets/images/logo-sm.png') }}" alt="" height="22">
            </span>

        </a>
        <!-- Light Logo-->
        <a href="index-2.html" class="logo logo-light">
            <span class="logo-sm">
                <img src="{{ asset('dashboard/assets/images/logo-sm.png') }}" alt="" height="22">
            </span>

        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div id="scrollbar">
        <div class="container-fluid">

            <div id="two-column-menu">
            </div>
            <ul class="navbar-nav" id="navbar-nav">
                <li class="menu-title"><span data-key="t-menu">Menu</span></li>

                <li class="nav-item">
                    <a class="nav-link menu-link {{ request()->routeIs('admin.home') ? 'active' : '' }}" href="{{ route('admin.home') }}">
                        <i class="ri-dashboard-2-line"></i> <span data-key="t-widgets">Dashboard</span>
                    </a>
                </li>

                <li class="menu-title"><i class="ri-more-fill"></i> <span data-key="t-components">Notify</span></li>

                <li class="nav-item">
                    <a class="nav-link menu-link {{ request()->routeIs('faculty.tag.index') ? 'active' : '' }}" href="{{ route('faculty.tag.index') }}">
                        <i class="ri-book-fill"></i> <span data-key="t-widgets">Tags</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link {{ request()->routeIs('faculty.notification.index') ? 'active' : '' }}" href="{{ route('faculty.notification.index') }}">
                        <i class="ri-book-fill"></i> <span data-key="t-widgets">Notifications</span>
                    </a>
                </li>



                <li class="nav-item">
                    <a class="nav-link menu-link {{ request()->routeIs('admin.users.index') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">
                        <i class="ri-book-fill"></i> <span data-key="t-widgets">Faculties</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link {{ request()->routeIs('admin.students.index') ? 'active' : '' }}" href="{{ route('admin.students.index') }}">
                        <i class="ri-book-fill"></i> <span data-key="t-widgets">Students</span>
                    </a>
                </li>


                {{-- <li class="nav-item">
                    <a class="nav-link menu-link active" href="#sidebarApps" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarApps">
                        <i class="ri-apps-2-line"></i> <span data-key="t-apps">E-Book</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarApps">
                        <ul class="nav nav-sm flex-column">

                            <li class="nav-item {{ request()->routeIs('faculty.notification.index') ? 'active' : '' }}">
                                <a href="{{ route('faculty.notification.index') }}" class="nav-link {{ request()->routeIs('faculty.notification.index') ? 'active' : '' }}" data-key="t-calendar"> Category </a>
                            </li>

                        </ul>
                    </div>
                </li> --}}
            </ul>
        </div>
        <!-- Sidebar -->
    </div>

    <div class="sidebar-background"></div>
</div>
