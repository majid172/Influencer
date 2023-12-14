<!-- feature section -->
@if(isset($contentDetails['feature'][0]) && $featureContents = $contentDetails['feature'][0])
	<section class="feature-section">
		<div class="container">
			@if(isset($templates['feature'][0]) && $feature = $templates['feature'][0])
				<div class="row">
					<div class="col-12">
						<div class="header-text text-center">
							<h5>@lang(optional($feature->description)->title)</h5>
							<h3>@lang(optional($feature->description)->sub_title)</h3>
						</div>
					</div>
				</div>
			@endif

			<div class="row justify-content-center align-items-center g-4">
				@if(isset($contentDetails['feature']) && $featureContents = $contentDetails['feature'])
					@if(0 < count($contentDetails['feature']))
						@foreach($featureContents as $featureContent)
							<div class="col-lg-4 col-md-6 box">
								<div class="feature-box">
									<div class="icon-box">
										<img src="{{ getFile(optional($featureContent->content->contentMedia)->driver,optional($featureContent->content->contentMedia->description)->image) }}" alt="@lang('feature img')" />
									</div>
									<div class="text-box">
										<h4>@lang(optional($featureContent->description)->title)</h4>
										<p>{!! __(optional($featureContent->description)->short_description) !!}</p>
									</div>
								</div>
							</div>
						@endforeach
					@endif
				@endif
			</div>
		</div>
	</section>
@endif
