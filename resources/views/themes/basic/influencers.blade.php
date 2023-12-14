@extends($theme.'layouts.app')
@section('title', trans('Talented Influencers'))

@section('content')
	<section class="influencers-section">
		<div class="container">
			<div class="row g-4 g-xl-5">
				@foreach ($influencers as $influencer)
					<div class="col-xl-3 col-lg-4 col-md-6">
						<div class="influencer-box">
							<div class="img-box">
								{!! $influencer->profilePicture() !!}
							</div>

							<div class="text-box">
								<a href="{{route('influencer.profile',$influencer->username)}}" class="name">@lang($influencer->name)</a>
								<span class="title">@lang(optional($influencer->profile)->designation)</span>

								<div class="followers">
									<p>
										<a href="{{ route('social.oauth', 'facebook') }}" target="_blank"><i class="fab fa-facebook"></i></a>
									</p>
									<p>
										<a href="{{ route('social.oauth', 'twitter') }}" target="_blank"><i class="fa-brands fa-twitter"></i></a>
									</p>
									<p>
										<a href="{{ route('social.oauth', 'linkedin') }}" target="_blank"><i class="fab fa-linkedin-in"></i></a>
									</p>
								</div>
							</div>
						</div>
					</div>
				@endforeach
			</div>
			<div class="row">
				{{$influencers->links()}}
			</div>
		</div>
	</section>
@endsection
