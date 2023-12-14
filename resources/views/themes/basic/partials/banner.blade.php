<style>
	.banner-section {
		padding: 170px 0 90px 0;
		position: relative;
		background: url({{asset($themeTrue.'images/banner-bg.png')}});
		background-size: cover;
		background-repeat: no-repeat;
		background-position: center top;
		border-bottom-right-radius: 40px;
		z-index: 1;
	}
</style>

@if(!request()->routeIs('home'))
	<!-- PAGE-BANNER -->
	<section class="banner-section">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<h3>@yield('title')</h3>
					<nav aria-label="breadcrumb">
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="{{route('home')}}">@lang('Home')</a></li>
						<li class="breadcrumb-item active" aria-current="page">@yield('title')</li>
					</ol>
					</nav>
				</div>
			</div>
		</div>
	</section>
	<!-- /PAGE-BANNER -->
@endif
