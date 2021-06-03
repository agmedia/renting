<!-- Sidebar -->
<!--
    Sidebar Mini Mode - Display Helper classes

    Adding 'smini-hide' class to an element will make it invisible (opacity: 0) when the sidebar is in mini mode
    Adding 'smini-show' class to an element will make it visible (opacity: 1) when the sidebar is in mini mode
        If you would like to disable the transition animation, make sure to also add the 'no-transition' class to your element

    Adding 'smini-hidden' to an element will hide it when the sidebar is in mini mode
    Adding 'smini-visible' to an element will show it (display: inline-block) only when the sidebar is in mini mode
    Adding 'smini-visible-block' to an element will show it (display: block) only when the sidebar is in mini mode
-->
<nav id="sidebar" aria-label="Main Navigation">
    <!-- Side Header -->
    <div class="bg-header-dark">
        <div class="content-header bg-white-10">
            <!-- Logo -->
            <a class="font-w600 text-white tracking-wide" href="/">
                            <span class="smini-visible">
                                D<span class="opacity-75">x</span>
                            </span>
                <span class="smini-hidden">
                                Dash<span class="opacity-75">mix</span>
                            </span>
            </a>
            <!-- END Logo -->

            <!-- Options -->
            <div>
                <!-- Toggle Sidebar Style -->
                <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
                <!-- Class Toggle, functionality initialized in Helpers.coreToggleClass() -->
                <a class="js-class-toggle text-white-75" data-target="#sidebar-style-toggler" data-class="fa-toggle-off fa-toggle-on" onclick="Dashmix.layout('sidebar_style_toggle');Dashmix.layout('header_style_toggle');" href="javascript:void(0)">
                    <i class="fa fa-toggle-off" id="sidebar-style-toggler"></i>
                </a>
                <!-- END Toggle Sidebar Style -->

                <!-- Close Sidebar, Visible only on mobile screens -->
                <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
                <a class="d-lg-none text-white ml-2" data-toggle="layout" data-action="sidebar_close" href="javascript:void(0)">
                    <i class="fa fa-times-circle"></i>
                </a>
                <!-- END Close Sidebar -->
            </div>
            <!-- END Options -->
        </div>
    </div>
    <!-- END Side Header -->

    <!-- Sidebar Scrolling -->
    <div class="js-sidebar-scroll">
        <!-- Side Navigation -->
        <div class="content-side content-side-full">
            <ul class="nav-main">
                {{--<li class="nav-main-heading">Katalog</li>--}}

                <li class="nav-main-item">
                    <a class="nav-main-link{{ request()->routeIs('dashboard') ? ' active' : '' }}" href="{{ route('dashboard') }}">
                        <i class="nav-main-link-icon si si-grid"></i>
                        <span class="nav-main-link-name">Dashboard</span>
                        {{--<span class="nav-main-link-badge badge badge-pill badge-success">5</span>--}}
                    </a>
                </li>
                {{--<li class="nav-main-heading">Various</li>--}}
                <li class="nav-main-item{{ request()->is(['admin/catalog/*']) ? ' open' : '' }}">
                    <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="true" href="#">
                        <i class="nav-main-link-icon si si-layers"></i>
                        <span class="nav-main-link-name">Katalog</span>
                    </a>
                    <ul class="nav-main-submenu">
                        <li class="nav-main-item">
                            <a class="nav-main-link{{ request()->routeIs(['categories', 'category.*']) ? ' active' : '' }}" href="{{ route('categories') }}">
                                <span class="nav-main-link-name">Kategorije</span>
                            </a>
                        </li>
                        <li class="nav-main-item">
                            <a class="nav-main-link{{ request()->routeIs(['publishers', 'publishers.*']) ? ' active' : '' }}" href="{{ route('publishers') }}">
                                <span class="nav-main-link-name">Izdavači</span>
                            </a>
                        </li>
                        <li class="nav-main-item">
                            <a class="nav-main-link{{ request()->routeIs(['authors', 'authors.*']) ? ' active' : '' }}" href="{{ route('authors') }}">
                                <span class="nav-main-link-name">Autori</span>
                            </a>
                        </li>
                        <li class="nav-main-item">
                            <a class="nav-main-link{{ request()->routeIs(['products', 'products.*']) ? ' active' : '' }}" href="{{ route('products') }}">
                                <span class="nav-main-link-name">Artikli</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-main-item">
                    <a class="nav-main-link{{ request()->routeIs(['orders', 'orders.*']) ? ' active' : '' }}" href="{{ route('orders') }}">
                        <i class="nav-main-link-icon si si-basket-loaded"></i>
                        <span class="nav-main-link-name">Narudžbe</span>
                    </a>
                </li>

                <li class="nav-main-item{{ request()->is(['admin/marketing/*']) ? ' open' : '' }}">
                    <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="true" href="#">
                        <i class="nav-main-link-icon si si-layers"></i>
                        <span class="nav-main-link-name">Marketing</span>
                    </a>
                    <ul class="nav-main-submenu">
                        <li class="nav-main-item">
                            <a class="nav-main-link{{ request()->routeIs(['actions', 'action.*']) ? ' active' : '' }}" href="{{ route('actions') }}">
                                <span class="nav-main-link-name">Akcije</span>
                            </a>
                        </li>
                        <li class="nav-main-item">
                            <a class="nav-main-link{{ request()->routeIs(['blogs', 'blog.*']) ? ' active' : '' }}" href="{{ route('blogs') }}">
                                <span class="nav-main-link-name">Blog</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-main-item">
                    <a class="nav-main-link{{ request()->routeIs(['users', 'users.*']) ? ' active' : '' }}" href="{{ route('users') }}">
                        <i class="nav-main-link-icon si si-users"></i>
                        <span class="nav-main-link-name">Korisnici</span>
                    </a>
                </li>

                <li class="nav-main-heading">Aplikacija</li>

                <li class="nav-main-item">
                    <a class="nav-main-link{{ request()->routeIs(['profile', 'profile.*']) ? ' active' : '' }}" href="{{ route('profile.show') }}">
                        <i class="nav-main-link-icon si si-user"></i>
                        <span class="nav-main-link-name">Moj Profil</span>
                    </a>
                </li>

                <li class="nav-main-item{{ request()->is(['admin/settings/*']) ? ' open' : '' }}">
                    <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="true" href="#">
                        <i class="nav-main-link-icon si si-settings"></i>
                        <span class="nav-main-link-name">Postavke</span>
                    </a>
                    <ul class="nav-main-submenu">
                        <li class="nav-main-item">
                            <a class="nav-main-link{{ request()->routeIs(['faqs', 'faq.*']) ? ' active' : '' }}" href="{{ route('faqs') }}">
                                <span class="nav-main-link-name">FAQ</span>
                            </a>
                        </li>
                        <li class="nav-main-item">
                            <a class="nav-main-link{{ request()->routeIs(['settings', 'settings.*']) ? ' active' : '' }}" href="{{ route('settings') }}">
                                <span class="nav-main-link-name">Postavke Aplikacije</span>
                            </a>
                        </li>
                    </ul>
                </li>

            </ul>
        </div>
        <!-- END Side Navigation -->
    </div>
    <!-- END Sidebar Scrolling -->
</nav>