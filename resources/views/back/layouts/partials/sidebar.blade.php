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
                <span class="smini-visible">B<span class="opacity-75">x</span></span>
                <span class="smini-hidden">{{ config('app.name') }}</span>
            </a>
            <!-- END Logo -->

            <!-- Options -->
            <div>
                <!-- Toggle Sidebar Style -->
                <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
                <!-- Class Toggle, functionality initialized in Helpers.coreToggleClass() -->
            <!--    <a class="js-class-toggle text-white-75" data-target="#sidebar-style-toggler" data-class="fa-toggle-off fa-toggle-on" onclick="Dashmix.layout('sidebar_style_toggle');Dashmix.layout('header_style_toggle');" href="javascript:void(0)">
                    <i class="fa fa-toggle-off" id="sidebar-style-toggler"></i>
                </a>-->
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
                        <span class="nav-main-link-name">{{ __('back/layout.dashboard') }}</span>
                        {{--<span class="nav-main-link-badge badge badge-pill badge-success">5</span>--}}
                    </a>
                </li>

                <li class="nav-main-item">
                    <a class="nav-main-link{{ request()->routeIs(['apartments', 'apartments.*']) ? ' active' : '' }}" href="{{ route('apartments') }}">
                        <i class="nav-main-link-icon si si-home"></i>
                        <span class="nav-main-link-name">{{ __('back/apartment.titles') }}</span>
                    </a>
                </li>
                {{--<li class="nav-main-heading">Various</li>--}}


                <li class="nav-main-item">
                    <a class="nav-main-link{{ request()->routeIs(['orders', 'orders.*']) ? ' active' : '' }}" href="{{ route('orders') }}">
                        <i class="nav-main-link-icon si si-basket-loaded"></i>
                        <span class="nav-main-link-name">{{ __('back/layout.sidebar.orders') }}</span>
                    </a>
                </li>

                <li class="nav-main-item">
                    <a class="nav-main-link{{ request()->routeIs(['calendar', 'calendar.*']) ? ' active' : '' }}" href="{{ route('calendar') }}">
                        <i class="nav-main-link-icon si si-calendar"></i>
                        <span class="nav-main-link-name">{{ __('back/layout.sidebar.calendar') }}</span>
                    </a>
                </li>

                <li class="nav-main-item{{ request()->is(['admin/marketing/*']) ? ' open' : '' }}">
                    <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="true" href="#">
                        <i class="nav-main-link-icon si si-bar-chart"></i>
                        <span class="nav-main-link-name">{{ __('back/layout.sidebar.marketing') }}</span>
                    </a>
                    <ul class="nav-main-submenu">
                        <li class="nav-main-item">
                            <a class="nav-main-link{{ request()->routeIs(['actions', 'actions.*']) ? ' active' : '' }}" href="{{ route('actions') }}">
                                <span class="nav-main-link-name">{{ __('back/layout.sidebar.actions') }}</span>
                            </a>
                        </li>
                        <li class="nav-main-item">
                            <a class="nav-main-link{{ request()->routeIs(['blogs', 'blogs.*']) ? ' active' : '' }}" href="{{ route('blogs') }}">
                                <span class="nav-main-link-name">{{ __('back/layout.sidebar.blog') }}</span>
                            </a>
                        </li>
                        <li class="nav-main-item">
                            <a class="nav-main-link{{ request()->routeIs(['widgets', 'widgets.*']) ? ' active' : '' }}" href="{{ route('widgets') }}">
                                <span class="nav-main-link-name">{{ __('back/layout.sidebar.widgets') }}</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-main-item">
                    <a class="nav-main-link{{ request()->routeIs(['users', 'users.*']) ? ' active' : '' }}" href="{{ route('users') }}">
                        <i class="nav-main-link-icon si si-users"></i>
                        <span class="nav-main-link-name">{{ __('back/layout.sidebar.users') }}</span>
                    </a>
                </li>

                <li class="nav-main-heading">{{ __('back/layout.sidebar.application') }}</li>

                <li class="nav-main-item">
                    <a class="nav-main-link{{ request()->routeIs(['profile', 'profile.*']) ? ' active' : '' }}" href="{{ route('profile.show') }}">
                        <i class="nav-main-link-icon si si-user"></i>
                        <span class="nav-main-link-name">{{ __('back/layout.sidebar.my_profile') }}</span>
                    </a>
                </li>

                <li class="nav-main-item{{ request()->is(['admin/settings/*']) ? ' open' : '' }}">
                    <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="true" href="#">
                        <i class="nav-main-link-icon si si-settings"></i>
                        <span class="nav-main-link-name">{{ __('back/layout.sidebar.settings') }}</span>
                    </a>
                    <ul class="nav-main-submenu">
                        <li class="nav-main-item{{ request()->is(['admin/settings/general/*']) ? ' open' : '' }}">
                            <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
                                <span class="nav-main-link-name">{{ __('back/layout.sidebar.system') }}</span>
                            </a>

                            <ul class="nav-main-submenu">
                                <li class="nav-main-item">
                                    <a class="nav-main-link{{ request()->routeIs(['categories', 'category.*']) ? ' active' : '' }}" href="{{ route('categories') }}">
                                        <span class="nav-main-link-name">{{ __('back/layout.sidebar.category') }}</span>
                                    </a>
                                </li>
                                <li class="nav-main-item">
                                    <a class="nav-main-link{{ request()->routeIs(['pages', 'pages.*']) ? ' active' : '' }}" href="{{ route('pages') }}">
                                        <span class="nav-main-link-name">{{ __('back/layout.sidebar.pages') }}</span>
                                    </a>
                                </li>
                                <li class="nav-main-item">
                                    <a class="nav-main-link{{ request()->routeIs(['faqs', 'faqs.*']) ? ' active' : '' }}" href="{{ route('faqs') }}">
                                        <span class="nav-main-link-name">{{ __('back/layout.sidebar.faq') }}</span>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-main-item{{ request()->is(['admin/settings/application/*']) ? ' open' : '' }}">
                            <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
                                <span class="nav-main-link-name">{{ __('back/layout.sidebar.local_settings') }}</span>
                            </a>

                            <ul class="nav-main-submenu">
                                <li class="nav-main-item">
                                    <a class="nav-main-link{{ request()->routeIs(['languages']) ? ' active' : '' }}" href="{{ route('languages') }}">
                                        <span class="nav-main-link-name">{{ __('back/layout.sidebar.languages') }}</span>
                                    </a>
                                </li>
                                <li class="nav-main-item">
                                    <a class="nav-main-link{{ request()->routeIs(['geozones', 'geozones.*']) ? ' active' : '' }}" href="{{ route('geozones') }}">
                                        <span class="nav-main-link-name">{{ __('back/layout.sidebar.geozones') }}</span>
                                    </a>
                                </li>
                                <li class="nav-main-item">
                                    <a class="nav-main-link{{ request()->routeIs(['order.statuses']) ? ' active' : '' }}" href="{{ route('order.statuses') }}">
                                        <span class="nav-main-link-name">{{ __('back/layout.sidebar.order_statuses') }}</span>
                                    </a>
                                </li>
                                <li class="nav-main-item">
                                    <a class="nav-main-link{{ request()->routeIs(['taxes']) ? ' active' : '' }}" href="{{ route('taxes') }}">
                                        <span class="nav-main-link-name">{{ __('back/layout.sidebar.taxes') }}</span>
                                    </a>
                                </li>
                                <li class="nav-main-item">
                                    <a class="nav-main-link{{ request()->routeIs(['currencies']) ? ' active' : '' }}" href="{{ route('currencies') }}">
                                        <span class="nav-main-link-name">{{ __('back/layout.sidebar.currencies') }}</span>
                                    </a>
                                </li>
                                <li class="nav-main-item">
                                    <a class="nav-main-link{{ request()->routeIs(['payments']) ? ' active' : '' }}" href="{{ route('payments') }}">
                                        <span class="nav-main-link-name">{{ __('back/layout.sidebar.payments') }}</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-main-item">
                            <a class="nav-main-link{{ request()->routeIs(['history', 'history.*']) ? ' active' : '' }}" href="{{ route('history') }}">
                                <span class="nav-main-link-name">History</span>
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
