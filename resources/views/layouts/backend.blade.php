<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="Responsive HTML Admin Dashboard Template based on Bootstrap 5">
    <meta name="author" content="Sayeed">
    <meta name="keywords" content="EDMS, bootstrap, bootstrap 5, bootstrap5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') | {{ config('app.name','') }}</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    <!-- End fonts -->
    <!-- core:css -->
    <link rel="stylesheet" href="{{asset('backend/assets/vendors/core/core.css')}}">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    @stack('css')
    <link rel="stylesheet" href="{{asset('backend/assets/vendors/flatpickr/flatpickr.min.css')}}">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="{{asset('backend//assets/fonts/feather-font/css/iconfont.css')}}">
    <link rel="stylesheet" href="{{asset('backend/assets/vendors/flag-icon-css/css/flag-icon.min.css')}}">
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="{{asset('backend/assets/css/demo1/style.css')}}">
    <link rel="stylesheet" href="{{asset('backend/assets/css/custom.css')}}">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="{{asset('backend/assets/images/favicon.png')}}" />
    
</head>

<body>

    <div class="main-wrapper">
        <!-- partial:partials/_sidebar.html -->
        <nav class="sidebar">
            <div class="sidebar-header">
                <a href="#" class="sidebar-brand">
                    NREL<span>EDMS</span>
                </a>
                <div class="sidebar-toggler not-active">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>

            @php
                $role = Auth::user()->type
            @endphp
            
            @include('partials.sidenav')
        </nav>
 
        <!-- partial -->

        <div class="page-wrapper">

            <!-- partial:partials/_navbar.html -->
            <nav class="navbar">
                <a href="#" class="sidebar-toggler">
                    <i data-feather="menu"></i>
                </a>
                <div class="navbar-content">
                    <form class="search-form">
                        <div class="input-group">
                            <div class="input-group-text">
                                <i data-feather="search"></i>
                            </div>
                            <input type="text" class="form-control" id="navbarForm" placeholder="Search here...">
                        </div>
                    </form>
                    <ul class="navbar-nav">
                        <!-- <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="messageDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i data-feather="mail"></i>
                            </a>
                            <div class="dropdown-menu p-0" aria-labelledby="messageDropdown">
                                <div class="px-3 py-2 d-flex align-items-center justify-content-between border-bottom">
                                    <p>9 New Messages</p>
                                    <a href="javascript:;" class="text-muted">Clear all</a>
                                </div>
                                <div class="p-1">
                                    <a href="javascript:;" class="dropdown-item d-flex align-items-center py-2">
                                        <div class="me-3">
                                            <img class="wd-30 ht-30 rounded-circle" src="https://via.placeholder.com/30x30" alt="userr">
                                        </div>
                                        <div class="d-flex justify-content-between flex-grow-1">
                                            <div class="me-4">
                                                <p>Leonardo Payne</p>
                                                <p class="tx-12 text-muted">Project status</p>
                                            </div>
                                            <p class="tx-12 text-muted">2 min ago</p>
                                        </div>
                                    </a>
                                    <a href="javascript:;" class="dropdown-item d-flex align-items-center py-2">
                                        <div class="me-3">
                                            <img class="wd-30 ht-30 rounded-circle" src="https://via.placeholder.com/30x30" alt="userr">
                                        </div>
                                        <div class="d-flex justify-content-between flex-grow-1">
                                            <div class="me-4">
                                                <p>Carl Henson</p>
                                                <p class="tx-12 text-muted">Client meeting</p>
                                            </div>
                                            <p class="tx-12 text-muted">30 min ago</p>
                                        </div>
                                    </a>
                                    
                                </div>
                                <div class="px-3 py-2 d-flex align-items-center justify-content-center border-top">
                                    <a href="javascript:;">View all</a>
                                </div>
                            </div>
                        </li> -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="notificationDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i data-feather="bell"></i>
                                <div class="indicator">
                                    <div class="circle"></div>
                                </div>
                            </a>
                            <div class="dropdown-menu p-0" aria-labelledby="notificationDropdown">
                                <div class="px-3 py-2 d-flex align-items-center justify-content-between border-bottom">
                                    <p>1 New Notifications</p>
                                    <a href="javascript:;" class="text-muted">Clear all</a>
                                </div>
                                <div class="p-1">
                                    <a href="javascript:;" class="dropdown-item d-flex align-items-center py-2">
                                        <div class="wd-30 ht-30 d-flex align-items-center justify-content-center bg-primary rounded-circle me-3">
                                            <i class="icon-sm text-white" data-feather="gift"></i>
                                        </div>
                                        <div class="flex-grow-1 me-2">
                                            <p>New Order Recieved</p>
                                            <p class="tx-12 text-muted">30 min ago</p>
                                        </div>
                                    </a>
                              
                                </div>
                                <div class="px-3 py-2 d-flex align-items-center justify-content-center border-top">
                                    <a href="javascript:;">View all</a>
                                </div>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img class="wd-30 ht-30 rounded-circle" src="https://via.placeholder.com/30x30" alt="profile">
                            </a>
                            <div class="dropdown-menu p-0" aria-labelledby="profileDropdown">
                                <div class="d-flex flex-column align-items-center border-bottom px-5 py-3">
                                    <div class="text-center">
                                        <p class="tx-16 fw-bolder">{{Auth::user()->name}}</p>
                                        <p class="tx-12 text-muted">{{Auth::user()->email}}</p>
                                    </div>
                                </div>
                                <ul class="list-unstyled p-1">
                                    <li class="dropdown-item py-2">
                                        <a href="#" class="text-body ms-0">
                                            <i class="me-2 icon-md" data-feather="user"></i>
                                            <span>Profile</span>
                                        </a>
                                    </li>
                                    <li class="dropdown-item py-2">
                                        <a href="{{ route('logout') }}"
											onclick="event.preventDefault();
															document.getElementById('logout-form').submit();" class="text-body ms-0">
                                            <i class="me-2 icon-md" data-feather="log-out"></i>
                                            <span>Log Out</span>

                                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
												@csrf
											</form>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
            <!-- partial -->

            @yield('content')

            <!-- partial:partials/_footer.html -->
            <footer class="footer d-flex flex-column flex-md-row align-items-center justify-content-between px-4 py-3 border-top small">
                <p class="text-muted mb-1 mb-md-0">Copyright © 2023 <a href="https://www.navana-realestate.com" target="_blank">LEDMS</a>.</p>
                <p class="text-muted">Design & Developed By <a href="https://sayeedinfo.com" target="_blank">IC&T</a></p>
            </footer>
            <!-- partial -->

        </div>
    </div>

    <!-- core:js -->
    <script src="{{asset('backend/assets/vendors/core/core.js')}}"></script>
    <!-- endinject -->

    <!-- Plugin js for this page -->
    @stack('js')
    <script src="{{asset('backend/assets/vendors/flatpickr/flatpickr.min.js')}}"></script>
    <script src="{{asset('backend/assets/vendors/apexcharts/apexcharts.min.js')}}"></script>
    <!-- End plugin js for this page -->

    <!-- inject:js -->
    <script src="{{asset('backend/assets/vendors/feather-icons/feather.min.js')}}"></script>
    <script src="{{asset('backend/assets/js/template.js')}}"></script>
    <!-- endinject -->

    <!-- Custom js for this page -->
    <script src="{{asset('backend/assets/js/dashboard-light.js')}}"></script>
    <script src="{{asset('backend/assets/js/custom.js')}}"></script>
    <!-- end custom js for this page -->
    
</body>

</html>