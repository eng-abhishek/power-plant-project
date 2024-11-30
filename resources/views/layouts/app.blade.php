<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<!-- begin::Head -->
<head>
	<meta charset="utf-8" />

	<!-- CSRF Token -->
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<title>{{ config('app.name', 'Power Plant') }}</title>
	
	<meta name="description" content=""> 
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
	<meta name="csrf-token" content="{{ csrf_token() }}" />
	<!--begin::Web font -->
	<script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
	<script>
		WebFont.load({
			google: {"families":["Poppins:300,400,500,600,700","Roboto:300,400,500,600,700"]},
			active: function() {
				sessionStorage.fonts = true;
			}
		});
	</script>
	<!--end::Web font -->

	<!--begin::Page Vendors Styles -->
	<link href="{{asset('assets/backend/plugins/fullcalendar/fullcalendar.bundle.css')}}" rel="stylesheet" type="text/css" />
	<!--end::Page Vendors Styles -->

	<!--begin::Page Vendors Styles -->
	<link href="{{asset('assets/backend/plugins/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css" />
	<!--end::Page Vendors Styles -->
	
	<!--begin::Base Styles -->
	<link href="{{asset('assets/backend/css/vendors.bundle.css')}}" rel="stylesheet" type="text/css" />
	<link href="{{asset('assets/backend/css/style.bundle.css')}}" rel="stylesheet" type="text/css" />
	<!--end::Base Styles -->

	<link rel="shortcut icon" href="{{asset('assets/backend/images/favicon.ico')}}" />

	<style type="text/css">
		.invalid-feedback{
			display: block;
		}
	    .error-help-block{
            color:#ce2f3b;
          }
	</style>

	@yield('styles')
</head>
<!-- end::Head -->

<!-- begin::Body -->
<body class="m-page--fluid m--skin- m-content--skin-light2 m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--fixed m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default">

	<!-- begin:: Page -->
	<div class="m-grid m-grid--hor m-grid--root m-page">
		<header id="m_header" class="m-grid__item    m-header "  m-minimize-offset="200" m-minimize-mobile-offset="200">
			<div class="m-container m-container--fluid m-container--full-height">
				<div class="m-stack m-stack--ver m-stack--desktop">
					<!-- BEGIN: Brand -->
					<div class="m-stack__item m-brand  m-brand--skin-dark ">
						<div class="m-stack m-stack--ver m-stack--general">
							{{-- <div class="m-stack__item m-stack__item--middle m-brand__logo">
								<a href="{{url('/backend')}}" class="m-brand__logo-wrapper">
									<img alt="" src="{{asset('assets/backend/images/logo_default_dark.png')}}"/>
								</a>  
							</div> --}}
							<div class="m-stack__item m-stack__item--middle m-brand__tools">
								
								<!-- BEGIN: Left Aside Minimize Toggle -->
								<a href="javascript:;" id="m_aside_left_minimize_toggle" class="m-brand__icon m-brand__toggler m-brand__toggler--left m--visible-desktop-inline-block  ">
									<span></span>
								</a>
								<!-- END -->
								
								<!-- BEGIN: Responsive Aside Left Menu Toggler -->
								<a href="javascript:;" id="m_aside_left_offcanvas_toggle" class="m-brand__icon m-brand__toggler m-brand__toggler--left m--visible-tablet-and-mobile-inline-block">
									<span></span>
								</a>
								<!-- END -->
								
								<!-- BEGIN: Responsive Header Menu Toggler -->
								<a id="m_aside_header_menu_mobile_toggle" href="javascript:;" class="m-brand__icon m-brand__toggler m--visible-tablet-and-mobile-inline-block">
									<span></span>
								</a>
								<!-- END -->
								

								<!-- BEGIN: Topbar Toggler -->
								<a id="m_aside_header_topbar_mobile_toggle" href="javascript:;" class="m-brand__icon m--visible-tablet-and-mobile-inline-block">
									<i class="flaticon-more"></i>
								</a>
								<!-- BEGIN: Topbar Toggler -->
							</div>
						</div>
					</div>
					<!-- END: Brand -->

					<div class="m-stack__item m-stack__item--fluid m-header-head" id="m_header_nav">

						<!-- BEGIN: Topbar -->
						<div id="m_header_topbar" class="m-topbar m-stack m-stack--ver m-stack--general m-stack--fluid">
							<div class="m-stack__item m-topbar__nav-wrapper">
								<ul class="m-topbar__nav m-nav m-nav--inline">

									<li class="m-nav__item m-topbar__user-profile m-topbar__user-profile--img  m-dropdown m-dropdown--medium m-dropdown--arrow m-dropdown--header-bg-fill m-dropdown--align-right m-dropdown--mobile-full-width m-dropdown--skin-light" m-dropdown-toggle="click">
										<a href="#" class="m-nav__link m-dropdown__toggle">
											<span class="m-topbar__userpic">	
												<img src="{{auth()->user()->avatar_url}}" class="m--img-rounded m--marginless" alt="Avatar"/>
											</span>
											<span class="m-topbar__username m--hide">{{auth()->user()->name}}</span>
										</a>
										<div class="m-dropdown__wrapper">
											<span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
											<div class="m-dropdown__inner">
												<div class="m-dropdown__header m--align-center" style="background: url('{{asset('assets/backend/images/user_profile_bg.jp')}}'); background-size: cover;background-color:#7948e1">
													<div class="m-card-user m-card-user--skin-dark">
														<div class="m-card-user__pic">
															<img src="{{auth()->user()->avatar_url}}" class="m--img-rounded m--marginless" alt="Avatar"/>
														</div>
														<div class="m-card-user__details">
															<span class="m-card-user__name m--font-weight-500">{{auth()->user()->name}}</span>
															<a href="javascript:;" class="m-card-user__email m--font-weight-300 m-link">{{auth()->user()->email}}</a>
														</div>
													</div>
												</div>
												<div class="m-dropdown__body">
													<div class="m-dropdown__content">
														<ul class="m-nav m-nav--skin-light">
															
															<li class="m-nav__item">
																<a href="{{route('account.profile.view')}}" class="m-nav__link">
																	<i class="m-nav__link-icon flaticon-profile-1"></i>
																	<span class="m-nav__link-text">My Profile</span>
																</a>
															</li>
													
															<li class="m-nav__separator m-nav__separator--fit">
															</li>
															<li class="m-nav__item">
																<a href="{{ route('logout') }}" class="btn m-btn--pill btn-secondary m-btn m-btn--custom m-btn--label-brand m-btn--bolder" onclick="event.preventDefault();document.getElementById('logout-form').submit();">Logout</a>
															</li>
															<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
																@csrf
															</form>
														</ul>
													</div>
												</div>
											</div>
										</div>
									</li>
								</ul>
							</div>	
						</div>
					</div>
				</div>
			</div>
		</header>
		<!-- END: Header -->

		<!-- begin::Body -->
		<div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-body">
			<!-- BEGIN: Left Aside -->
			<button class="m-aside-left-close  m-aside-left-close--skin-dark " id="m_aside_left_close_btn"><i class="la la-close"></i></button>

			<div id="m_aside_left" class="m-grid__item	m-aside-left  m-aside-left--skin-dark">
				<!-- BEGIN: Aside Menu -->
				<div id="m_ver_menu" class="m-aside-menu  m-aside-menu--skin-dark m-aside-menu--submenu-skin-dark" m-menu-vertical="1" m-menu-scrollable="1" m-menu-dropdown-timeout="500" style="position: relative;">
					<ul class="m-menu__nav  m-menu__nav--dropdown-submenu-arrow">
						
						<li class="m-menu__item {{(Route::currentRouteName() == 'dashboard')?'m-menu__item--active':''}}" aria-haspopup="true">
							<a href="{{route('dashboard')}}" class="m-menu__link ">
								<i class="m-menu__link-icon flaticon-dashboard"></i>
								<span class="m-menu__link-title">
									<span class="m-menu__link-wrap">
										<span class="m-menu__link-text">Dashboard</span>
									</span>
								</span>
							</a>
						</li>

						<li class="m-menu__item {{in_array(Route::currentRouteName(), ['schedule.index','schedule.create','schedule.edit'])?'m-menu__item--active':''}}" aria-haspopup="true">
							<a href="{{route('schedule.index')}}" class="m-menu__link ">
								<i class="m-menu__link-icon flaticon-dashboard"></i>
								<span class="m-menu__link-title">
									<span class="m-menu__link-wrap">
										<span class="m-menu__link-text">Power Scheduling</span>
									</span>
								</span>
							</a>
						</li>

						<li class="m-menu__item {{in_array(Route::currentRouteName(), ['schedule-with-ajax'])?'m-menu__item--active':''}}" aria-haspopup="true">
							<a href="{{route('schedule-with-ajax')}}" class="m-menu__link ">
								<i class="m-menu__link-icon flaticon-dashboard"></i>
								<span class="m-menu__link-title">
									<span class="m-menu__link-wrap">
										<span class="m-menu__link-text">Power Scheduling With Ajax</span>
									</span>
								</span>
							</a>
						</li>

					</ul>
				</div>
				<!-- END: Aside Menu -->
			</div>
			<!-- END: Left Aside -->

			<div class="m-grid__item m-grid__item--fluid m-wrapper">

				@yield('content')

			</div>
		</div>
		<!-- end:: Body -->
		
		<!-- begin::Footer -->
		<footer class="m-grid__item	m-footer ">
			<div class="m-container m-container--fluid m-container--full-height m-page__container">
				<div class="m-stack m-stack--flex-tablet-and-mobile m-stack--ver m-stack--desktop">
					<div class="m-stack__item m-stack__item--left m-stack__item--middle m-stack__item--last">
						<span class="m-footer__copyright">
							{{date('Y')}} &copy; <a href="{{url('/superadmin')}}" class="m-link">{{config('app.name')}}</a>
						</span>
					</div>
					<div class="m-stack__item m-stack__item--right m-stack__item--middle m-stack__item--first">
					
					</div>	
				</div>
			</div>
		</footer>
		<!-- end::Footer -->

	</div>
	<!-- end:: Page -->

	<!-- begin::Scroll Top -->
	<div id="m_scroll_top" class="m-scroll-top">
		<i class="la la-arrow-up"></i>
	</div>
	<!-- end::Scroll Top -->

	<script type="text/javascript">
		var website_url = @json(url('/'));
	</script>

	<!--begin::Base Scripts -->        
	<script src="{{asset('assets/backend/js/vendors.bundle.js')}}" type="text/javascript"></script>
	<script src="{{asset('assets/backend/js/scripts.bundle.js')}}" type="text/javascript"></script>
	<!--end::Base Scripts -->

	<!--begin::Page Vendors Scripts -->
	<script src="{{asset('assets/backend/plugins/fullcalendar/fullcalendar.bundle.js')}}" type="text/javascript"></script>
	<!--end::Page Vendors Scripts -->

	<!--Datatables -->
	<script src="{{asset('assets/backend/plugins/datatables/datatables.bundle.js')}}" type="text/javascript"></script>

	<!-- Laravel Javascript Validation -->
	<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>

	<!--Select2 --> 
	<script src="{{asset('assets/backend/plugins/select2/select2.js')}}" type="text/javascript"></script>

	<script src="{{asset('assets/backend/js/common.js')}}" type="text/javascript"></script>

	<!-- Jquery Nestable --> 
	<script src="{{asset('assets/backend/plugins/jquery-nestable/jquery.nestable.js')}}" type="text/javascript"></script>

	@yield('scripts')
	
</body>
<!-- end::Body -->

</html>	