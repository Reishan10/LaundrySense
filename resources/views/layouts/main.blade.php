<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>@yield('title') | LaundrySense</title>
    <meta content="{{ csrf_token() }}" name="csrf-token">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description">
    <meta content="Coderthemes" name="author">
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets') }}/images/favicon.ico">

    <!-- third party css -->
    <link href="{{ asset('assets') }}/css/vendor/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css">
    <!-- third party css end -->

    <!-- App css -->
    <link href="{{ asset('assets') }}/css/icons.min.css" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets') }}/css/app.min.css" rel="stylesheet" type="text/css" id="light-style">
    <link href="{{ asset('assets') }}/css/app-dark.min.css" rel="stylesheet" type="text/css" id="dark-style">
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"
        integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
    <!-- Datatables css -->
    <link href="{{ asset('assets') }}/css/vendor/dataTables.bootstrap5.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets') }}/css/vendor/responsive.bootstrap5.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="loading" data-layout="detached"
    data-layout-config='{"layoutBoxed":false, "leftSidebarCondensed":false, "leftSidebarScrollable":false,"darkMode":false, "showRightSidebarOnStart": true}'>
</body>

<!-- Topbar Start -->
<div class="navbar-custom topnav-navbar">
    <div class="container-fluid">

        <!-- LOGO -->
        <a href="index.html" class="topnav-logo">
            <span class="topnav-logo-lg">
                <strong style="font-size:1.3rem;">LaundrySense</strong>
            </span>
            <span class="topnav-logo-sm">
                <strong style="font-size:1.3rem;">LS</strong>
            </span>
        </a>

        <ul class="list-unstyled topbar-menu float-end mb-0">
            <li class="dropdown notification-list">
                <a class="nav-link dropdown-toggle nav-user arrow-none me-0" data-bs-toggle="dropdown"
                    id="topbar-userdrop" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                    <span class="account-user-avatar">
                        <img src="{{ asset('assets') }}/images/avatar.png" alt="user-image" class="rounded-circle">
                    </span>
                    <span>
                        <span class="account-user-name">{{ auth()->user()->name }}</span>
                        <span class="account-position">{{ auth()->user()->level }}</span>
                    </span>
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated topbar-dropdown-menu profile-dropdown"
                    aria-labelledby="topbar-userdrop">
                    <!-- item-->
                    <div class=" dropdown-header noti-title">
                        <h6 class="text-overflow m-0">Selamat datang !</h6>
                    </div>

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <i class="mdi mdi-account-edit me-1"></i>
                        <span>Pengaturan</span>
                    </a>

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <i class="mdi mdi-logout me-1"></i>
                        <span>Logout</span>
                    </a>

                </div>
            </li>

        </ul>
        <a class="button-menu-mobile disable-btn">
            <i class="mdi mdi-menu"></i>
        </a>
    </div>
</div>
<!-- end Topbar -->

<!-- Start Content-->
<div class="container-fluid">

    <!-- Begin page -->
    <div class="wrapper">

        @include('layouts.sidebar')

        @yield('content')
        <!-- content-page -->
    </div> <!-- end wrapper-->
</div>
<!-- END Container -->

<!-- bundle -->
<script src="{{ asset('assets') }}/js/vendor.min.js"></script>
<script src="{{ asset('assets') }}/js/app.min.js"></script>

<!-- third party js -->
<script src="{{ asset('assets') }}/js/vendor/apexcharts.min.js"></script>
<script src="{{ asset('assets') }}/js/vendor/jquery-jvectormap-1.2.2.min.js"></script>
<script src="{{ asset('assets') }}/js/vendor/jquery-jvectormap-world-mill-en.js"></script>
<!-- third party js ends -->

<!-- demo app -->
<script src="{{ asset('assets') }}/js/pages/demo.dashboard.js"></script>
<!-- end demo js-->
<script src="{{ asset('assets') }}/js/vendor/jquery.dataTables.min.js"></script>

<!-- Datatables js -->
<script src="{{ asset('assets') }}/js/vendor/dataTables.bootstrap5.js"></script>
<script src="{{ asset('assets') }}/js/vendor/dataTables.responsive.min.js"></script>
<script src="{{ asset('assets') }}/js/vendor/responsive.bootstrap5.min.js"></script>

<!-- Datatable Init js -->
<script src="{{ asset('assets') }}/js/pages/demo.datatable-init.js"></script>

</html>
