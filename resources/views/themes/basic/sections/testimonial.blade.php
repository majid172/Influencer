@if(isset($templates['testimonial'][0]) && $testimonial = $templates['testimonial'][0])
	@if(isset($contentDetails['testimonial']) && $testimonialContents = $contentDetails['testimonial'])
		@if(0 < count($contentDetails['testimonial']))
			<!-- TESTIMONIAL -->
			<section class="testimonial-section">
				<div class="container">
					<div class="row justify-content-center">
						<div class="col-lg-4">
							<div class="header-text">
								<h5>@lang(@$testimonial['description']->title)</h5>
								<h3>@lang(@$testimonial['description']->sub_title)</h3>
							</div>
						</div>
						<div class="col-lg-8">
							<div class="testimonial-wrapper">
								<div class="testimonials owl-carousel">
									@foreach($testimonialContents as $testimonialContent)
										<div class="review-box">
											<div class="text">
												<div class="rating">
													<span>
														@for($i = 1; $i <= $testimonialContent->description->review; $i++)
															<i class="fas fa-star"></i>
														@endfor
														@for($i = $testimonialContent->description->review; $i < 5; $i++)
															<i class="fa-light fa-star"></i>
														@endfor
													</span>
												</div>
												<p>{!! __(optional($testimonialContent->description)->short_description) !!}</p>

												<div class="user-box">
													<div class="img">
														<img src="{{ getFile(optional($testimonialContent->content->contentMedia)->driver,optional($testimonialContent->content->contentMedia->description)->image) }}" alt="@lang('testimonial img')" />
													</div>
													<div class="text">
														<h5>@lang(optional($testimonialContent->description)->title)</h5>
														<span class="title">@lang(optional($testimonialContent->description)->designation)</span>
													</div>
												</div>
											</div>
										</div>
									@endforeach
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>
			<!-- /TESTIMONIAL -->
		@endif
	@endif
@endif
