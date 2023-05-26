<!doctype html>
<html lang="en" data-layout="vertical" data-layout-style="detached" data-layout-position="fixed" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-layout-width="fluid">


<head>

    <meta charset="utf-8" />
    <title>{{ env('APP_NAME') }} - Portal</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="{{ env('APP_NAME') }}" name="description" />
    <meta content="Oladipo Damilare(KoderiaNG)" name="author" />
    <meta name="robots" content="noindex">
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{asset('assets/images/favicon.ico')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!--datatable css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />
    <!--datatable responsive css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" />

    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">

    <!-- Layout config Js -->
    <script src="{{asset('assets/js/layout.js')}}"></script>
    <!-- Bootstrap Css -->
    <link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{asset('assets/css/icons.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{asset('assets/css/app.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- custom Css-->
    <link href="{{asset('assets/css/custom.min.css')}}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <script src="https://cdn.tiny.cloud/1/b9d45cy4rlld8ypwkzb6yfzdza63fznxtcoc3iyit61r4rv9/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: 'textarea',
            plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
        });
    </script>


</head>

<body>
    @include('sweetalert::alert')
    <!-- Begin page -->
    <div id="layout-wrapper">

        <header id="page-topbar">
    <div class="layout-width">
        <div class="navbar-header">
            <div class="d-flex">
                <!-- LOGO -->
                <div class="navbar-brand-box horizontal-logo">
                    <a href="{{ url('/admin/home') }}" class="logo logo-dark">
                        <span class="logo-sm">
                            <img src="{{asset('asset/images/logo.png')}}" alt="" height="22">
                        </span>
                        <span class="logo-lg">
                            <img src="{{asset('assets/images/logo.png')}}" alt="" height="80">
                        </span>
                    </a>

                    <a href="{{ url('/admin/home') }}" class="logo logo-light">
                        <span class="logo-sm">
                            <img src="{{asset('assets/images/logo.png')}}" alt="" height="22">
                        </span>
                        <span class="logo-lg">
                            <img src="{{asset('assets/images/logo.png')}}" alt="" height="80">
                        </span>
                    </a>
                </div>

                <button type="button" class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger shadow-none" id="topnav-hamburger-icon">
                    <span class="hamburger-icon">
                        <span></span>
                        <span></span>
                        <span></span>
                    </span>
                </button>


            </div>

            <div class="d-flex align-items-center">


                <div class="ms-1 header-item d-none d-sm-flex">
                    <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle shadow-none" data-toggle="fullscreen">
                        <i class='bx bx-fullscreen fs-22'></i>
                    </button>
                </div>

                <div class="ms-1 header-item d-none d-sm-flex">
                    <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle light-dark-mode shadow-none">
                        <i class='bx bx-moon fs-22'></i>
                    </button>
                </div>

                <div class="dropdown ms-sm-3 header-item topbar-user">
                    <button type="button" class="btn shadow-none" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="d-flex align-items-center">
                            <img class="rounded-circle header-profile-user" src="{{asset('assets/images/users/user.png')}}" alt="Header Avatar">
                            @auth
                            <span class="text-start ms-xl-2">
                                <span class="d-none d-xl-inline-block ms-1 fw-medium user-name-text">{{ Auth::guard('admin')->user()->name }}</span>
                                <span class="d-none d-xl-block ms-1 fs-12 text-muted user-name-sub-text">Administrator</span>
                            </span>
                            @endauth
                        </span>
                    </button>
                    @auth
                    <div class="dropdown-menu dropdown-menu-end">
                        <!-- item-->
                        <h6 class="dropdown-header">Welcome Back {{ Auth::guard('admin')->user()->name }}!</h6>
                        @if(Auth::guard('admin')->user()->role >= 10)<a class="dropdown-item" href="{{ url('admin/profile') }}"><i class="mdi mdi-account-circle text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Profile</span></a>@endif
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ url('/admin/logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i> <span class="align-middle" data-key="t-logout">Logout</span></a>
                        <form id="logout-form" action="{{ url('/admin/logout') }}" method="POST" style="display: none;">@csrf</form>
                    </div>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</header>
<!-- ========== App Menu ========== -->
<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <!-- Dark Logo-->
        <a href="{{ url('/admin/home') }}" class="logo logo-dark">
            <span class="logo-sm">
                <img src="{{asset('assets/images/logo.png')}}" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="{{asset('assets/images/logo.png')}}" alt="" height="80">
            </span>
        </a>
        <!-- Light Logo-->
        <a href="{{ url('/admin/home') }}" class="logo logo-light">
            <span class="logo-sm">
                <img src="{{asset('assets/images/logo.png')}}" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="{{asset('assets/images/logo.png')}}" alt="" height="80">
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
                    <a class="nav-link menu-link" href="{{ url('admin/home') }}">
                        <i class="mdi mdi-view-dashboard"></i> <span data-key="t-dashboards">Dashboard</span>
                    </a>
                </li> <!-- end Dashboard Menu -->

                <li class="nav-item">
                    <a class="nav-link menu-link" href="#siteSettings" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarForms">
                        <i class="mdi mdi-database-settings"></i> <span data-key="t-forms">Site Settings</span>
                    </a>
                    <div class="collapse menu-dropdown" id="siteSettings">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a class="nav-link menu-link" href="{{ url('admin/globalSettings') }}"
                                    data-key="t-profile">Global Settings
                                </a>
                            </li>   
                        </ul>

                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="#media" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarForms">
                        <i class="mdi mdi-camera-image"></i> <span data-key="t-forms">Media Files</span>
                    </a>
                    <div class="collapse menu-dropdown" id="media">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a class="nav-link menu-link" href="{{ url('admin/media') }}"
                                    data-key="t-profile">Media Files
                                </a>
                            </li>   
                        </ul>

                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="#examination" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarForms">
                        <i class="mdi mdi-notebook-check"></i> <span data-key="t-forms">External Examinations</span>
                    </a>
                    <div class="collapse menu-dropdown" id="examination">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a class="nav-link menu-link" href="{{ url('admin/externalExamination') }}"
                                    data-key="t-profile">Manage External Examinations
                                </a>
                            </li> 
                        </ul>

                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="#department" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarForms">
                        <i class="mdi mdi-warehouse"></i> <span data-key="t-forms">Departments</span>
                    </a>
                    <div class="collapse menu-dropdown" id="department">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a class="nav-link menu-link" href="{{ url('admin/department') }}"
                                    data-key="t-profile">Manage Department
                                </a>
                            </li> 
                        </ul>

                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="#news" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarForms">
                        <i class="mdi mdi-newspaper-variant"></i> <span data-key="t-forms">News & Events</span>
                    </a>
                    <div class="collapse menu-dropdown" id="news">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a class="nav-link menu-link" href="{{ url('admin/news') }}"
                                    data-key="t-profile">Manage News
                                </a>
                            </li> 

                            <li class="nav-item">
                                <a class="nav-link menu-link" href="{{ url('admin/events') }}"
                                    data-key="t-profile">Manage Events
                                </a>
                            </li> 
                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="#testimony" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarForms">
                        <i class="mdi mdi-comment-account"></i> <span data-key="t-forms">Testimonials</span>
                    </a>
                    <div class="collapse menu-dropdown" id="testimony">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a class="nav-link menu-link" href="{{ url('admin/testimonials') }}"
                                    data-key="t-profile">Manage Testimonials
                                </a>
                            </li> 
                        </ul>

                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="#awards" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarForms">
                        <i class="mdi mdi-trophy-award"></i> <span data-key="t-forms">Awards</span>
                    </a>
                    <div class="collapse menu-dropdown" id="awards">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a class="nav-link menu-link" href="{{ url('admin/awards') }}"
                                    data-key="t-profile">Manage Awards
                                </a>
                            </li> 
                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="#prefects" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarForms">
                        <i class="mdi mdi-account-check"></i> <span data-key="t-forms">Student Leadership</span>
                    </a>
                    <div class="collapse menu-dropdown" id="prefects">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a class="nav-link menu-link" href="{{ url('admin/prefects') }}"
                                    data-key="t-profile">Manage Prefects
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="#staffs" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarForms">
                        <i class="mdi mdi-account-circle"></i> <span data-key="t-forms">Staff</span>
                    </a>
                    <div class="collapse menu-dropdown" id="staffs">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a class="nav-link menu-link" href="{{ url('admin/staff') }}"
                                    data-key="t-profile">Manage Staff
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="#alumni" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarForms">
                        <i class="mdi mdi-account-reactivate"></i> <span data-key="t-forms">Alumni</span>
                    </a>
                    <div class="collapse menu-dropdown" id="alumni">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a class="nav-link menu-link" href="{{ url('admin/alumni') }}"
                                    data-key="t-profile">Manage Alumni
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="#student" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarForms">
                        <i class="mdi mdi-camera-image"></i> <span data-key="t-forms">Student Board</span>
                    </a>
                    <div class="collapse menu-dropdown" id="student">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a class="nav-link menu-link" href="{{ url('admin/studentBoard') }}"
                                    data-key="t-profile">Manage Student Board
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sponsor" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarForms">
                        <i class="mdi mdi-bag-suitcase"></i> <span data-key="t-forms">Sponsors</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sponsor">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a class="nav-link menu-link" href="{{ url('admin/sponsors') }}"
                                    data-key="t-profile">Manage Sponsors
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#pages" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarForms">
                        <i class="mdi mdi-book-open-page-variant"></i> <span data-key="t-forms">Pages</span>
                    </a>
                    <div class="collapse menu-dropdown" id="pages">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a class="nav-link menu-link" href="{{ url('admin/pageSetting') }}"
                                    data-key="t-profile">Page Settings
                                </a>
                            </li>  
                            <li class="nav-item">
                                <a class="nav-link menu-link" href="{{ url('admin/pages') }}"
                                    data-key="t-profile">Manage Pages
                                </a>
                            </li> 
                        </ul>
                    </div>
                </li>
                
                {{-- <li class="nav-item">
                    <a class="nav-link menu-link" href="#supports" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarForms">
                        <i class="mdi mdi-help-box"></i> <span data-key="t-forms">Supports</span>
                    </a>
                    <div class="collapse menu-dropdown" id="supports">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a class="nav-link menu-link" href="{{ url('admin/supports') }}"
                                    data-key="t-profile">Manage Support Requests
                                </a>
                            </li> 
                        </ul>
                    </div>
                </li> --}}

                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ url('admin/logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="mdi mdi-power"></i> <span data-key="t-logout">Logout</span>
                    </a>
                </li> <!-- end Logout Menu -->

            </ul>
        </div>
        <!-- Sidebar -->
    </div>


    <div class="sidebar-background"></div>
</div>
<!-- Left Sidebar End -->
<!-- Vertical Overlay-->
<div class="vertical-overlay"></div>
