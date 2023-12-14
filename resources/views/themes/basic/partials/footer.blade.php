<!-- footer section -->
<footer class="footer-section" id="subscribe">
	<div class="overlay">
		<div class="container">
			<div class="row gy-5 gy-lg-0">
				<div class="col-lg-3 col-md-6">
					<div class="footer-box">
						<a class="navbar-brand" href="{{route('home')}}">
							<img src="{{ getFile(config('basic.default_file_driver'),config('basic.logo_image')) }}" alt="{{config('basic.site_title')}}">
						</a>
						<p class="company-bio">
							@if(isset($contactUs['contact'][0]) && $contact = $contactUs['contact'][0])
								{!! @$contact->description->footer_short_details !!}
							@endif
						</p>

						<h5 class="mt-4">@lang('follow us on')</h5>
						@if(isset($contentDetails['social-links']))
							<div class="social-links">
								@foreach($contentDetails['social-links'] as $data)
									<a href="{{@$data->content->contentMedia->description->social_link}}" target="_blank">
										<i class="{{@$data->content->contentMedia->description->social_icon}}"></i>
									</a>
								@endforeach
							</div>
						@endif
					</div>
				</div>

				<div class="col-lg-9">
					<div class="row">
						<div class="col-lg-4 col-md-6">
							<div class="footer-box">
								<h5>@lang("Quick Links")</h5>
								<ul>
									<li><a href="{{route('home')}}">@lang('Home')</a></li>
									<li><a href="{{route('influencers')}}">@lang('Influencers')</a></li>
									<li><a href="{{route('allListings')}}">Listings</a></li>
									<li><a href="{{route('jobs')}}">@lang('Jobs')</a></li>
									<li><a href="{{route('faq')}}">@lang('Faq')</a></li>
								</ul>
							</div>
						</div>

						<div class="col-lg-4 col-md-6">
							<div class="footer-box">
								<h5>@lang('Useful Links')</h5>
								<ul>
									<li><a href="{{route('contact')}}">@lang('Contact')</a></li>
									<li><a href="{{route('blog')}}">@lang('Blogs')</a></li>
									@if(isset($contentDetails['pages']))
										@foreach($contentDetails['pages'] as $data)
											<li>
												<a href="{{route('getLink', [slug($data->description->title), $data->content_id])}}">@lang(optional($data->description)->title)</a>
											</li>
										@endforeach
									@endif
								</ul>
							</div>
						</div>

						<div class="col-lg-4 col-md-6">
							<div class="footer-box">
								<h5>@lang('Contact us')</h5>
								<ul>
									@if(isset($contactUs['contact'][0]) && $contact = $contactUs['contact'][0])
										<li><i class="fal fa-map-marker-alt"></i> <span>@lang($contact->description->location)</span></li>
										<li><i class="fal fa-envelope"></i> <span>@lang($contact->description->email)</span></li>
										<li><i class="fal fa-phone-alt"></i> <span>@lang($contact->description->phone)</span></li>
									@endif
								</ul>
							</div>
						</div>

						<div class="col-12">
							<div class="footer-box newsletter-box">
								<div class="row align-items-center">
									<div class="col-md-6">
										@if(isset($newsLetter['news-letter'][0]) && $newsLetters = $newsLetter['news-letter'][0])
											<h4>@lang($newsLetters->description->title)</h4>
											<p>@lang($newsLetters->description->sub_title)</p>
										@endif
									</div>

									<div class="col-md-6">
										<form action="{{ route('subscribe') }}" method="post">
											@csrf
											<div class="input-group">
												<input type="email" class="form-control" name="email" placeholder="@lang('enter email')"/>
												<button type="submit" class="btn-custom">
													<i class="fal fa-paper-plane" aria-hidden="true"></i>
												</button>
											</div>

										</form>
									</div>

								</div>
							</div>
						</div>

					</div>
				</div>
			</div>

			<div class="d-flex copyright justify-content-between">
				<div>
					<span> @lang('All rights reserved') &copy; {{ __(date('Y')) }} @lang('by')<a href="{{route('home')}}">@lang($basic->site_title)</a> </span>
				</div>
				<div class="language d-flex">
					@forelse($languages as $language)
					<a href="{{route('language',[$language->short_name])}}" class="{{session()->get('trans') == $language->short_name ? 'redColorText' : ''}}">
                        <div class="d-flex">
                            <span class="mx-2 flag-icon flag-icon-{{strtolower($language->short_name)}}"></span> <span>{{$language->name}}</span>
                        </div>
                    </a>
					@empty
					@endforelse
				</div>
			</div>
		</div>
	</div>
</footer>


<!-- arrow up -->
<a href="#" class="scroll-up">
	<span><i class="fal fa-long-arrow-up"></i></span>
</a>
