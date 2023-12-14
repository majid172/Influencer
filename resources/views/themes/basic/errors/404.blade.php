@extends($theme.'layouts.app')
@section('title','404')

@section('content')
    <!-- 404 page -->
	<section class="error-page">
		<div class="container h-100">
			<div class="row h-100 align-items-center">
				<div class="col-lg-6">
					<div class="img-box">
						<img class="img-fluid" src="{{asset($themeTrue.'images/404.png')}}" alt="@lang('404 img')"/>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="text-box">
						<h2>@lang('Page not found!')</h2>
						<p>@lang('The page you are looking for no longer exists. Perhaps you can return back to the site’s
							homepage and see if you can find what you are looking for.')</p>
						<a class="btn-custom mt-3" href="{{url('/')}}">@lang('Back To Home')</a>
					</div>
				</div>
			</div>
		</div>
	</section>
@endsection
