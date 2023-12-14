<!DOCTYPE html>
<html lang="en" @if(session()->get('rtl') == 1) dir="rtl" @endif />
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link href="{{ getFile(config('basic.default_file_driver'),config('basic.favicon_image')) }}" rel="icon">
	<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
	<link rel="stylesheet" href="{{asset($themeTrue.'css/code.jquery-ui.css')}}">

	<title> @yield('title') | {{ basicControl()->site_title }} </title>

	@include($theme.'partials.user.styles')
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

<div id="app">
	<div class="main-wrapper main-wrapper-1">
		@include($theme.'partials.user.topbar')
		@include($theme.'partials.banner')

		<section class="influencer-panel">
			<div class="container">
				<div class="row g-4 g-lg-5">
					@include($theme.'partials.user.sidebar')
					@section('content')
					@show
				</div>
			</div>
		</section>


		@include($theme.'partials.footer')
	</div>
</div>

@include($theme.'partials.user.scripts')
@include($theme.'partials.user.flash-message')

@yield('scripts')
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
</body>
</html>
