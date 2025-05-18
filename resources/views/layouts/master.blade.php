<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title') | {{ config('app.name','') }}</title>
    <!-- core:css -->
    <link rel="stylesheet" href="{{asset('backend/assets/vendors/core/core.css')}}">
    <!-- endinject -->
    <!-- plugin css for this page -->
    <!-- end plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="{{asset('backend/assets/fonts/feather-font/css/iconfont.css')}}">
    <link rel="stylesheet" href="{{asset('backend/assets/vendors/flag-icon-css/css/flag-icon.min.css')}}">
    <!-- endinject -->
    <!-- Layout styles -->  
    <link rel="stylesheet" href="{{asset('backend/assets/css/demo_5/style.css')}}">
	<link rel="stylesheet" href="{{asset('backend/assets/css/custom.css')}}">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="{{asset('backend/assets/images/favicon.png')}}" />
    @stack('css')
</head>
<body>
	<div class="main-wrapper">

		<!-- partial:../../partials/_navbar.html -->
		<div class="horizontal-menu">
			<nav class="navbar top-navbar">
				<div class="container">
					<div class="navbar-content">
						<a href="{{url('/')}}" class="navbar-brand">
							NREL<span>EDMS</span>
						</a>
						<form class="search-form">
							<div class="input-group">
								<div class="input-group-prepend">
									<div class="input-group-text">
										<i data-feather="search"></i>
									</div>
								</div>
								<input type="text" class="form-control" id="navbarForm" placeholder="Search here..." disabled>
							</div>
						</form>
						<ul class="navbar-nav">
							<li class="nav-item dropdown nav-notifications">
								<a class="nav-link dropdown-toggle" href="#" id="notificationDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									<i data-feather="bell"></i>
									<div class="indicator">
										<div class="circle"></div>
									</div>
								</a>
							</li>
							
								@guest
									@if (Route::has('login'))
										<li class="nav-item">
											<a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
										</li>
									@endif
									
									@if (Route::has('register'))
										<!-- <li class="nav-item">
											<a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
											https://via.placeholder.com/30x30
										</li> -->
									@endif
								@else
									<li class="nav-item dropdown nav-profile">
										<a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
											<img src="{{asset('uploads/img/')}}/{{Auth::user()->image}}" alt="profile">
										</a>
										<div class="dropdown-menu" aria-labelledby="profileDropdown">
											<div class="dropdown-header d-flex flex-column align-items-center">
												<div class="info text-center">
													<p class="name font-weight-bold mb-0">{{ Auth::user()->name }}</p>
													<p class="email text-muted mb-3">{{Auth::user()->email}}</p>
												</div>
											</div>
											<div class="dropdown-body">
												<ul class="profile-nav p-0 pt-3">
													<li class="nav-item">
														<a href="{{route('user.profile',Auth::user()->id)}}" class="nav-link">
															<i data-feather="user"></i>
															<span>Profile</span>
														</a>
													</li>
													<li class="nav-item">
														<a href="{{route('user.profile',Auth::user()->id)}}" class="nav-link">
															<i data-feather="edit"></i>
															<span>Edit Profile</span>
														</a>
													</li>
													<li class="nav-item">
														<a class="nav-link" href="{{ route('logout') }}"
														onclick="event.preventDefault();
																		document.getElementById('logout-form').submit();"><i data-feather="log-out"></i>
															{{ __('Logout') }}
														</a>

														<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
															@csrf
														</form>
													</li>
												</ul>
											</div>
										</div>
									</li>
								@endguest

							
						</ul>
						<button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="horizontal-menu-toggle">
							<i data-feather="menu"></i>					
						</button>
					</div>
				</div>
			</nav>
			
		</div>
		<!-- partial -->
	
		<div class="page-wrapper">

                @yield('content')
			

			<!-- partial:../../partials/_footer.html -->
			<footer class="footer d-flex flex-column flex-md-row align-items-center justify-content-between">
				<p class="text-muted text-center text-md-left">Copyright © 2021 <a href="#" target="_blank">NREL</a>. All rights reserved</p>
				<p class="text-muted text-center text-md-left mb-0 d-none d-md-block">Design & Developed By NREL MIS</p>
			</footer>
			<!-- partial -->
	
		</div>
	</div>

    <!-- core:js -->
    <script src="{{asset('backend/assets/vendors/core/core.js')}}"></script>
    <!-- endinject -->
    <!-- plugin js for this page -->
    <!-- end plugin js for this page -->
    <!-- inject:js -->
    <script src="{{asset('backend/assets/vendors/feather-icons/feather.min.js')}}"></script>
    <script src="{{asset('backend/assets/js/template.js')}}"></script>
    <!-- endinject -->
    <!-- custom js for this page -->
    <!-- end custom js for this page -->
    @stack('js')
</body>
</html>