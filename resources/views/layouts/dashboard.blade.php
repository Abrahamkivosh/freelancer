<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>



    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->

    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" id="light-style" />
    <link href="{{ asset('assets/css/app-dark.min.css') }}" rel="stylesheet" type="text/css" id="dark-style" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-star-rating/4.0.2/css/star-rating.min.css" />

</head>
<body data-layout-config='{"leftSideBarTheme":"dark","layoutBoxed":false, "leftSidebarCondensed":false, "leftSidebarScrollable":false,"darkMode":false, "showRightSidebarOnStart": true}'>
<!-- Begin page -->
<div class="wrapper">
    <!-- ========== Left Sidebar Start ========== -->
    <div class="left-side-menu">
        <!-- LOGO -->
        <a href="{{ route('home') }}" class="logo text-center logo-light">
                    <span class="logo-lg">
                        FreeLance
{{--                        <img src="{{ asset('assets/images/logo.png') }}" alt="" height="16">--}}
                    </span>
            <span class="logo-sm">
                FreeLance
{{--                        <img src="{{ asset('assets/images/logo_sm.png') }}" alt="" height="16">--}}
                    </span>
        </a>

        <div class="h-100" id="left-side-menu-container" data-simplebar>

            <!--- Sidemenu -->
            <ul class="metismenu side-nav">

                <li class="side-nav-title side-nav-item">Navigation</li>
                <li class="side-nav-item">
                    <a href="{{ route('home') }}" class="side-nav-link">
                        <i class="uil-home-alt"></i>
                        <span> Dashboard </span>
                    </a>
                </li>
                <li class="side-nav-item">
                    <a href="javascript: void(0);" class="side-nav-link">
                        <i class="uil-comments-alt"></i>
                        <span> Jobs </span>
                    </a>
                    <ul class="side-nav-second-level" aria-expanded="false">

                        <li>
                            <a href="{{ route('job.index') }}">All Jobs</a>
                        </li>
                        @if( auth()->user()->role_id == 3 || auth()->user()->role_id == 1)  
                        <!-- client can create new job -->
                            <li>
                                <a href="{{ route('job.create') }}">New Job</a>
                            </li>
                        @endif
                        @if( Auth::user() -> role_id == 2)
                            <li>
                                <a href="{{ route('jobs.applied') }}">Jobs Applied</a>
                            </li>
                        @endif

                    </ul>
                </li>
                <li class="side-nav-item">
                    <a href="{{ route('wallet') }}" class="side-nav-link">
                        <i class="uil-wallet"></i>
                        <span> Wallet </span>
                    </a>
                </li>

                <li class="side-nav-item">
                    <a href="{{ route('users.index') }}" class="side-nav-link">
                        <i class="clarity:users-solid-badged"></i>
                        
                        <span> Users </span>
                    </a>
                </li>

            </ul>

            <div class="clearfix"></div>

        </div>
        <!-- Sidebar -left -->

    </div>
    <!-- Left Sidebar End -->

    <!-- ============================================================== -->
    <!-- Start Page Content here -->
    <!-- ============================================================== -->

    <div class="content-page">
        <div class="content">
            <!-- Topbar Start -->
            <div class="navbar-custom">
                <ul class="list-unstyled topbar-right-menu float-right mb-0">

                    <li class="dropdown notification-list">
                        <a class="nav-link dropdown-toggle nav-user arrow-none mr-0" data-toggle="dropdown" href="#" role="button" aria-haspopup="false"
                           aria-expanded="false">
                            <span class="account-user-avatar">
                                <img src="{{ asset('assets/images/users/avatar-1.jpg') }}" alt="user-image" class="rounded-circle">
                            </span>
                            <span>
                                <span class="account-user-name">{{ Auth::user()->username }}</span>
                            </span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-animated topbar-dropdown-menu profile-dropdown">
                            <!-- item-->
                            <!-- item-->
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                <i class="mdi mdi-logout mr-1"></i> {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>

                        </div>
                    </li>

                </ul>
                <button class="button-menu-mobile open-left disable-btn">
                    <i class="mdi mdi-menu"></i>
                </button>
            </div>
            <!-- end Topbar -->

            <!-- Start Content-->
            <div class="container-fluid">

                <!-- start page title -->

                <!-- end page title -->


                <main class="py-4">
                    @yield('content')
                </main>

            </div> <!-- container -->

        </div> <!-- content -->

        <!-- Footer Start -->
        <footer class="footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6">
                         2021 © Peter Kenya.
                    </div>
                    <div class="col-md-6">
                        <div class="text-md-right footer-links d-none d-md-block">
                            
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!-- end Footer -->

    </div>

    <!-- ============================================================== -->
    <!-- End Page content -->
    <!-- ============================================================== -->


</div>
<!-- END wrapper -->

<div class="rightbar-overlay"></div>
<!-- Scripts -->
<script src="{{ asset('assets/js/vendor.min.js') }}"></script>
<script src="{{ asset('assets/js/app.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-star-rating/4.0.2/js/star-rating.min.js"></script>


</body>
</html>
