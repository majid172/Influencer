@extends($theme.'layouts.app')
@section('title', trans($influencerProfile->username."'s Profile"))

@section('content')
	<section class="influencer-profile">
		<div class="container">
			<div class="row g-4">
				<div class="col-lg-4 col-md-6">
					<div class="sidebar-wrapper">
						<div class="cover">
							<div class="img">
								<img src="{{getFile(optional($influencerProfile->profile)->driver,optional($influencerProfile->profile)->cover_picture)}}" alt="@lang('influencer profile img')" class="img-fluid" />
							</div>
						</div>

						<div class="profile">
							<div class="img">
								{!! $influencerProfile->profilePicture() !!}
							</div>
							<div class="mb-3">
								<h5 class="name">
									@lang($influencerProfile->name)
									<i class="fas fa-check-circle" aria-hidden="true"></i>
								</h5>
								<span><span>@</span>@lang($influencerProfile->username)</span>
							</div>
						</div>

						<div class="additional-info">
							<div class="row">
								<div class="col-lg-6">
									<div class="rating">
										@if($influencerProfile->influencerRating->avg('ratings') > 0)
											@for($i=1;$i <= $influencerProfile->influencerRating->avg('ratings');$i++)
												<i class="fas fa-star"></i>
											@endfor
										@else
											<i class="fa-regular fa-star"></i>
										@endif

										<span>({{$influencerProfile->influencerRating->avg('ratings')??0}})</span>
									</div>
								</div>

							</div>


							<ul>
								<li>
									<span>
										<i class="fal fa-map-marker-alt"></i>
										@lang('From')
									</span>
									<span>@lang(optional(optional($influencerProfile->profile)->getCountry)->name)</span>
								</li>
								<li>
									<span>
										<i class="fal fa-user"></i>
										@lang('Member Since')
									</span>
									<span>@lang($influencerProfile->created_at->format('F Y'))</span>
								</li>


								<li>
									<span>
										<i class="fal fa-clipboard-list"></i>
										@lang('Total Orders')
									</span>
									<span>{{$totalOrders}}</span>
								</li>

							</ul>

						</div>
					</div>

					<div class="card-box mt-4">
						<h4>@lang('Description')</h4>
						<p>@lang(optional($influencerProfile->profile)->about_me)</p>
					</div>

					<div class="card-box followers mt-4">
						<h4>@lang('Social Links')</h4>
						<ul>
							@forelse($socialLinks as $item)
							<li>
								<span><a href="{{$item->link}}" target="_blank" class="text-primary"> @php echo $item->icon ; @endphp  {{__($item->sitename)}} </a> </span>
							</li>
							@empty
								<div class="">
									<div class="test-box">
										<div class="img-box text-center pt-3">
											<img src="{{asset($themeTrue.'images/no-data.png')}}" class="img-fluid no-data-img" alt="img" />
										</div>
										<div class="text-box">
											<h6 class="text-center">@lang('No information available ')</h6>
										</div>
									</div>
								</div>
							@endforelse

						</ul>
					</div>

					<div class="card-box skills mt-4">
						<h4>@lang('Skills')</h4>
						@forelse(explode(',',optional($influencerProfile->profile)->skills) as $key => $skill)
							<a href="javascript:void(0)">@lang($skill)</a>
						@empty

								<div class="img-box text-center pt-3">
									<img src="{{asset($themeTrue.'images/no-data.png')}}" class="img-fluid no-data-img" alt="img" />
								</div>
								<div class="text-box">
									<h6 class="text-center">@lang('No information available ')</h6>
								</div>

						@endforelse
					</div>

					<div class="card-box followers mt-4">
						<h4>@lang('Education')</h4>
						@forelse ($influencerProfile->education as $item)
							<div class="edu-box">
								<p class="pb-0 mb-0">@lang($item->degree)</p>
								<span>@lang($item->institution)</span> <br>
								<small>{{dateTime($item->start,'d M,Y')}} - {{ dateTime($item->end,'d M,Y') }}</small>
							</div>
						@empty

								<div class="img-box text-center pt-3">
									<img src="{{asset($themeTrue.'images/no-data.png')}}" class="img-fluid no-data-img" alt="img" />
								</div>
								<div class="text-box">
									<h6 class="text-center">@lang('No information available ')</h6>
								</div>

						@endforelse
					</div>

					<div class="card-box mt-4">
						<h4>@lang('Certifications')</h4>
						@forelse ($influencerProfile->certification as $item)
							<div class="edu-box">
								<p class="pb-0 mb-0">@lang($item->name)</p>
								<span>@lang($item->institution)</span> <br>
								<small>{{dateTime($item->start,'d M,Y')}} - {{ dateTime($item->end,'d M,Y') }}</small>
							</div>
						@empty

								<div class="img-box text-center pt-3">
									<img src="{{asset($themeTrue.'images/no-data.png')}}" class="img-fluid no-data-img" alt="img" />
								</div>
								<div class="text-box">
									<h6 class="text-center">@lang('No information available')</h6>
								</div>

						@endforelse
					</div>

					<div class="card-box mt-4">
						<h4>@lang('Language')</h4>
						<div class="edu-box mb-0">
							<p>@lang('Mother Tongue -') @lang(optional($influencerProfile->profile)->mother_tongue)</p>
						</div>
						<div class="edu-box">

							@if(optional($influencerProfile->profile)->known_languages)
								<p>

									@lang('Known Languages') :
									<strong  class="text-primary">{{optional($influencerProfile->profile)->known_languages}}</strong>
								</p>
								@else

									<div class="img-box text-center pt-3">
										<img src="{{asset($themeTrue.'images/no-data.png')}}" class="img-fluid no-data-img" alt="img" />
									</div>
									<div class="text-box">
										<h6 class="text-center">@lang('No information available ')</h6>
									</div>
								@endif

						</div>
					</div>

				</div>


				<div class="col-lg-8 col-md-6">

					<h4>@lang('Listings') ({{$listings->count()}})</h4>
					<div class="row g-4">
						@forelse($listings as $listing)
							<div class="col-xxl-4 col-lg-6 col-md-12 col-sm-6">
								<div class="listing-box">
								<div class="img-box">
									<img src="{{getFile($listing->driver,$listing->image)}}" class="img-fluid" alt="img" />
								</div>
								<div class="text-box">
									<div class="author">
										<div class="author-img">
											{!! optional($listing->user)->profilePicture() !!}
										</div>
										<div class="author-info">
											<a href="{{route('influencer.profile', optional($listing->user)->username)}}" class="name">@lang(optional($listing->user)->name)</a>
											<span>{{__(optional($listing->user)->profile->seller_type)}}</span>
										</div>
									</div>
									<a href="{{route('user.listing.details',[slug($listing->title), $listing->id])}}" class="title">@lang(\Illuminate\Support\Str::limit($listing->title,45))</a>
									<div class="d-flex justify-content-between">
										<p class="rating"><i class="fas fa-star"></i> <span> {{@$listing->review->avg('ratings')}}</span></p>
										<p class="price">@lang('Starting at') <span>{{$basic->currency_symbol}} {{$listing->firstPackage()}}</span></p>
									</div>
								</div>
							</div>
							</div>
						@empty
							<div class="col-12">
								<div class="card-box">
									<div class="img-box text-center pt-3">
										<img src="{{asset($themeTrue.'images/no-data.png')}}" class="img-fluid no-data-img" alt="img" />
									</div>

									<div class="text-box">
										<h6 class="text-center">@lang('No Listing Data')</h6>
									</div>
								</div>
							</div>
						@endforelse
					</div>


						<div class="card-box mt-5">
							<h4>@lang('Portfolio')</h4>
							@forelse($influencerProfile->portfolio as $portfolio)
								<div class="col-lg-3">
									<div class="author-portfolio-box">
										<div class="img-box">
											<img class="img-fluid" src="{{getFile($portfolio->driver,$portfolio->image)}}" alt="portfolio_img">
										</div>

										<p><a class="text-primary view" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#viewPortfolioModal" data-project_title="{{__($portfolio->project_title)}}" data-description="{{__($portfolio->description)}}"  data-img="{{getFile($portfolio->driver,$portfolio->image)}}" > {{ Illuminate\Support\Str::limit($portfolio->project_title, $limit = 25, $end = '...') }} </a></p>

									</div>
								</div>
							@empty
								<div class="">
									<div class="img-box text-center pt-3">
										<img src="{{asset($themeTrue.'images/no-data.png')}}" class="img-fluid no-data-img" alt="img" />
									</div>
									<div class="text-box">
										<p class="text-center">@lang('No portfolio information available ')</p>
									</div>
								</div>
							@endforelse
						</div>


						<div class="card-box mt-5">
						<h4>@lang('Testimonial') </h4>
						<p>@lang('Endorsements from past clients')</p>
						@forelse($influencerProfile->testimonial as $testimonial)
							@if($testimonial->is_accepted == 1)
								<div class="info-box mt-2">

									<div class="d-flex align-items-center mb-2">
										<p>{{__($testimonial->client_note)}}</p>

									</div>
									@for($i = 0; $i < $testimonial->ratings; $i++)
										<i class="fas fa-star text-primary"></i>
									@endfor
									<h6>{{__($testimonial->first_name)}} {{__($testimonial->last_name)}}</h6>
									<p><span>{{dateTime($testimonial->updated_at,'d M, Y')}}  </span> <span> <i class="fa-solid fa-circle-check text-primary"></i>@lang(' Varified')</span> </p>

								</div>

								<hr>
							@else
								<p>@lang(' Testimonial request awaiting for response')</p>
							@endif
						@empty
							<div class="">
								<div class="img-box text-center pt-3">
									<img src="{{asset($themeTrue.'images/no-data.png')}}" class="img-fluid no-data-img" alt="img" />
								</div>
								<div class="text-box">
									<p class="text-center">@lang('Showcasing client testimonials can strengthen your profile. ')</p>
								</div>
							</div>
						@endforelse
					</div>

						<div class="card-box mt-5">
						<h4>@lang('Employment History') </h4>

						@forelse($influencerProfile->employment as $employment)
							<div class="info-box mt-2">

								<div class="d-flex align-items-center">
									<h6> <span>{{__($employment->title)}}</span> | <span>{{__($employment->company)}}</span> </h6>

								</div>
								<p>{{__($employment->description)}}</p>
								<p> <span>{{dateTime($employment->from_period,'d M, Y')}} - @if(isset($employment->to_period))
											{{dateTime(@$employment->to_period,'d M, Y')}}
										@else
											@lang('Present')
										@endif
				</span>
								</p>

							</div>
							<hr>
						@empty
							<div class="">
								<div class="img-box text-center pt-3">
									<img src="{{asset($themeTrue.'images/no-data.png')}}" class="img-fluid no-data-img" alt="img" />
								</div>
								<div class="text-box">
									<p class="text-center">@lang('No employment history available ')</p>
								</div>
							</div>
						@endforelse
					</div>


				</div>
		</div>
		</div>

	</section>


	<div class="modal fade" id="viewPortfolioModal" tabindex="-1" aria-labelledby="viewPortfolioModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered ">
			<div class="modal-content">

				<div class="modal-body">
					<div class="row g-3">
						<div class="input-box col-12">
							<h5 class="title"></h5>
							<div class="img">
								<img src="" id="img" alt="">
							</div>

							<div class="mt-3">
								<h6 class="font-weight-bold">@lang('Project Description')</h6>
								<p class="description"></p>
							</div>
						</div>

					</div>

				</div>

			</div>
		</div>
	</div>
@endsection

@push('scripts')
	<script>
		$('.view').on('click',function (){
			let modal = $('#viewPortfolioModal');
			let title = ($(this).data('project_title'))
			let img = $(this).attr('data-img');
			modal.find('.title').text(title);
			modal.find('.description').text($(this).data('description'));
			modal.find('#img').attr('src',img)
		})
	</script>


@endpush
