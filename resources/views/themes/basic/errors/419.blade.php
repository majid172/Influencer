@extends($theme.'layouts.app')
@section('title','419')

@section('content')
	<section class="error-page">
		<div class="container h-100">
			<div class="row h-100 align-items-center">
				<div class="col-lg-6">
					<div class="img-box">
						<img class="img-fluid" src="{{asset($themeTrue.'images/419.png')}}" alt="@lang('419 img')"/>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="text-box">
						<h2>@lang('419!')</h2>
						<p>@lang("Sorry, your session has expired")</p>
						<a class="btn-custom mt-3" href="{{url('/')}}">@lang('Back To Home')</a>
					</div>
				</div>
			</div>
		</div>
	</section>
@endsection
