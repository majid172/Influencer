<!DOCTYPE html>
<!--[if lt IE 7 ]>
<html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]>
<html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]>
<html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!-->
<html class="no-js" lang="en" @if(session()->get('rtl') == 1) dir="rtl" @endif >
<head>

    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1'/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>

    @include('partials.seo')

		<link rel="stylesheet" href="{{asset($themeTrue.'css/bootstrap.min.css')}}"/>
		<link rel="stylesheet" href="{{asset($themeTrue.'css/all.min.css')}}"/>
		<link rel="stylesheet" href="{{asset($themeTrue.'css/fontawesome.min.css')}}"/>
		<link rel="stylesheet" href="{{asset($themeTrue.'css/animate.css')}}"/>
		<link rel="stylesheet" href="{{asset($themeTrue.'css/owl.carousel.min.css')}}"/>
		<link rel="stylesheet" href="{{asset($themeTrue.'css/owl.theme.default.min.css')}}"/>
		<link rel="stylesheet" href="{{asset($themeTrue.'css/select2.min.css')}}"/>
		<link rel="stylesheet" href="{{asset($themeTrue.'css/range-slider.css')}}"/>
		<link rel="stylesheet" href="{{asset($themeTrue.'css/flag-icon.min.css')}}" />

		@stack('css-lib')
		<link rel="stylesheet" href="{{asset($themeTrue.'css/style.css')}}"/>
		@stack('style')

</head>

<body class="@if(session()->get('rtl') == 1) rtl @endif">

	<div id="preloader">
		<div class="loader">
			<div class="loader-inner">
				<div></div>
				<div></div>
				<div></div>
				<div></div>
			</div>
		</div>
	</div>

	<!-- navbar -->
	<nav class="navbar navbar-expand-lg fixed-top">
		<div class="container">
			<a class="navbar-brand" href="{{route('home')}}">
				<img src="{{ getFile(config('basic.default_file_driver'),config('basic.logo_image')) }}" alt="{{config('basic.site_title')}}">
			</a>

			<button class="navbar-toggler p-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
				<i class="far fa-bars"></i>
			</button>

			<div class="collapse navbar-collapse" id="navbarNav">
				<ul class="navbar-nav">
					<li class="nav-item">
						<a class="nav-link {{Request::routeIs('home') ? 'active' : ''}}" href="{{ route('home') }}">
							@lang('Home')
						</a>
					</li>
					<li class="nav-item">
						<a class="nav-link {{Request::routeIs('influencers') ? 'active' : ''}}" href="{{route('influencers')}}">@lang('Influencers')</a>
					</li>
					<li class="nav-item">
						<a class="nav-link {{Request::routeIs('allListings') ? 'active' : ''}}" href="{{route('allListings')}}">@lang('Listings')</a>
					</li>
					<li class="nav-item">
						<a class="nav-link {{Request::routeIs('jobs') ? 'active' : ''}}" href="{{route('jobs')}}">@lang('Jobs')</a>
					</li>
					<li class="nav-item">
						<a class="nav-link {{Request::routeIs('blog') ? 'active' : ''}}" href="{{ route('blog')}} ">@lang('Blog')</a>
					</li>
					<li class="nav-item">
						<a class="nav-link {{Request::routeIs('contact') ? 'active' : ''}}" href="{{ route('contact') }}">@lang('Contact')</a>
					</li>
				</ul>
			</div>


			<!-- navbar text -->
			<span class="navbar-text">
				<!-- user panel -->
				@auth

					<!-- notification panel -->
					@include($theme.'partials.pushNotify')
					<div class="user-panel">
						<span class="profile">
							{!! auth()->user()->profilePicture() !!}

						</span>
						<ul class="user-dropdown">

							<li>
								<a href="{{route('user.dashboard')}}"> <i class="fal fa-user"></i>@lang('Dashboard')</a>
							</li>

							<li>
								<a href="{{route('user.message')}}"> <i class="fal fa-comments-alt"></i> @lang('Messages') </a>
							</li>


							<li>
								<a href="{{route('user.profile')}}"> <i class="fal fa-user-cog"></i> @lang('Account Settings') </a>
							</li>

							<li>
								<a href="{{route('user.twostep.security')}}"><i class="fal fa-user-lock"></i>@lang('2 FA Security')</a>
							</li>

							<li>
								<a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
									<i class="fal fa-sign-out-alt"></i>@lang('Sign Out')
								</a>
								<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
									@csrf
								</form>
							</li>
						</ul>
					</div>
				@else
					<a href="{{route('login')}}" class="btn-custom"><i class="fa-regular fa-arrow-right-to-bracket"></i> @lang('Sign In')</a>
				@endauth

			</span>
		</div>
	</nav>


@include($theme.'partials.banner')
@yield('content')
@include($theme.'partials.footer')
@stack('extra-content')
	@include($theme.'partials.scripts')
@stack('script')

@include('plugins')

@include($theme.'partials.notification')

@if ($errors->any())
	@php
		$collection = collect($errors->all());
		$errors = $collection->unique();
	@endphp

@endif

<script>
    $(document).ready(function () {
        $(".language").find("select").change(function () {
            window.location.href = "{{route('language')}}/" + $(this).val()
        })
    })

	var getTimeZone = Intl.DateTimeFormat().resolvedOptions().timeZone;
	$('.timeZone').val(getTimeZone);
</script>

</body>
</html>
