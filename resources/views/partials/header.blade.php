    <!-- Header Start -->
    <header class="main-header">
        <div class="header-sticky active">
            <nav class="container">
                <div class="navbar navbar-expand-lg">
                    <!-- Logo Start -->
                    <a class="navbar-brand" href="{{ route('home') }}">
                        <img src="{{ asset('images/downloads/logo-full.png') }}" alt="Vega Homes - We Bring Your Dream Space to Life">
                    </a>
                    <!-- Logo End -->

                    <!-- Main Menu Start -->
                    <div class="collapse navbar-collapse main-menu">
                        <div class="nav-menu-wrapper"></div>
                        <ul class="navbar-nav mr-auto" id="menu">
                            <li class="nav-item {{ request()->routeIs('home') ? 'active' : '' }}"><a class="nav-link" href="{{ route('home') }}">Home</a>
                            <li class="nav-item"><a class="nav-link" href="#" style="display: none;">Portfolio</a>
                            <li class="nav-item submenu" style="display: none;"><a class="nav-link" href="#">Pages</a>
                                <ul>
                                    <li class="nav-item"><a class="nav-link" href="#">Page 1</a></li>
                                    <li class="nav-item"><a class="nav-link" href="#">Page 2</a></li>
                                    <li class="nav-item"><a class="nav-link" href="#">Page 3</a></li>
                                </ul>
                            </li>
                            <li class="nav-item {{ request()->routeIs('about') ? 'active' : '' }}"><a class="nav-link" href="{{ route('about') }}">About Us</a>
                            <li class="nav-item {{ request()->routeIs('services') ? 'active' : '' }}"><a class="nav-link" href="{{ route('services') }}">Services</a></li>
                            <li class="nav-item {{ request()->routeIs('projects') ? 'active' : '' }}"><a class="nav-link" href="{{ route('projects') }}">Projects</a></li>
                            <li class="nav-item {{ request()->routeIs('contact') ? 'active' : '' }}"><a class="nav-link" href="{{ route('contact') }}">Contact Us</a></li>
                        </ul>
                    </div>
                    <!-- Main Menu End -->
                    <div class="navbar-toggle" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample"></div>
                </div>
            </nav>
            <div class="responsive-menu"></div>
        </div>
    </header>

    <!--offcanvas-->
    <div class="offcanvas offcanvas-start w-100" tabindex="-1" id="offcanvasExample"
        aria-labelledby="offcanvasExampleLabel"
        style="background:url('{{ asset('images/downloads/hero/New/SH-30.jpg') }}') no-repeat; color:white; background-size: cover;">
        <div class="offcanvas-header">
            <button type="button" data-bs-theme="dark" class="btn-close bg-white" data-bs-dismiss="offcanvas"
                aria-label="Close"></button>
        </div>
        <div class="offcanvas-body w-100" style="margin: 0%;padding:0%;">
            <ul class="navbar-nav mr-auto" style="padding:10px 10px">
                <li class="nav-item {{ request()->routeIs('home') ? 'active' : '' }}"><a class="nav-link text-center" href="{{ route('home') }}">Home</a>
                <li class="nav-item d-none">
                    <div class="btn-group dropdown-center" style="width: 100%;">
                        <button class="dropdown-toggle btn nav-link text-center" type="button" data-bs-toggle="dropdown"
                            style="padding:8px 0px 8px 0px;margin:0px; border:0px; width:100%;">
                            Pages
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item text-center" href="#">Page 1</a></li>
                            <li><a class="dropdown-item text-center" href="#">Page 2</a></li>
                            <li><a class="dropdown-item text-center" href="#">Page 3</a></li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item {{ request()->routeIs('about') ? 'active' : '' }}"><a class="nav-link text-center" href="{{ route('about') }}">About Us</a>
                <li class="nav-item {{ request()->routeIs('services') ? 'active' : '' }}"><a class="nav-link text-center" href="{{ route('services') }}">Services</a></li>
                <li class="nav-item {{ request()->routeIs('projects') ? 'active' : '' }}"><a class="nav-link text-center" href="{{ route('projects') }}">Projects</a></li>
                <li class="nav-item {{ request()->routeIs('contact') ? 'active' : '' }}"><a class="nav-link text-center" href="{{ route('contact') }}">Contact Us</a></li>
            </ul>
        </div>
    </div>
    <!-- Header End -->
