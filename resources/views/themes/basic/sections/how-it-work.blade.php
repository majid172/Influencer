@if(isset($templates['how-it-work'][0]) && $howItWork = $templates['how-it-work'][0])
	<section class="how-it-works">
		<div class="container">
			<div class="row">
				<div class="col-lg-6">
					<div class="header-text">
						<h5>@lang(@$howItWork['description']->title)</h5>
						<h2>@lang(@$howItWork['description']->sub_title)</h2>
						<p>@lang(@$howItWork['description']->short_description)</p>
					</div>

					<div class="work-box-wrapper">
						@if(isset($contentDetails['how-it-work']) && $howItWorkContents = $contentDetails['how-it-work'])
							@if(0 < count($contentDetails['how-it-work']))
								@foreach($howItWorkContents->take(3) as $key => $howItWorkContent)
									<div class="work-box">
										<div class="number">
											<h3>{{++$key}}</h3>
										</div>
										<div class="text">
											<h4>@lang(optional($howItWorkContent->description)->title)</h4>
											<p>{!! __(optional($howItWorkContent->description)->short_description) !!}</p>
										</div>
									</div>
								@endforeach
							@endif
						@endif
					</div>

				</div>
			</div>
		</div>

		<div class="img-box">
			<img src="{{getFile(optional($howItWork->media)->driver,@$howItWork->templateMedia()->image)}}" class="img-fluid" alt="@lang('howItWork img')" />
		</div>
	</section>
@endif

