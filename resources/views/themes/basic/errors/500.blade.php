@extends($theme.'layouts.app')
@section('title','500')

@section('content')
	<section class="error-page">
		<div class="container h-100">
			<div class="row h-100 align-items-center">
				<div class="col-lg-6">
					<div class="img-box">
						<img class="img-fluid" src="{{asset($themeTrue.'images/500.png')}}" alt="@lang('500 img')"/>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="text-box">
						<h2>@lang('Internal Server Error')</h2>
						<p>@lang("The server encountered an internal error misconfiguration and was unable to complate your request. Please contact the server administrator.")</p>
						<a class="btn-custom mt-3" href="{{url('/')}}">@lang('Back To Home')</a>
					</div>
				</div>
			</div>
		</div>
	</section>
@endsection
