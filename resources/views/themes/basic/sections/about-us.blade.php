@if(isset($templates['about-us'][0]) && $aboutUs = $templates['about-us'][0])
	<!-- ABOUT-US -->
	<section class="about-section">
		<div class="container">
			<div class="row gy-5 g-lg-5">
				<div class="col-lg-6">
					<div class="img-wrapper">
						<div class="img-box">
							<img src="{{getFile(optional($aboutUs->media)->driver,@$aboutUs->templateMedia()->image)}}" alt="@lang('about img')" />
						</div>
						<img class="shape shape-1" src="{{asset($themeTrue.'images/follow.png')}}" alt="@lang('about img1')" />
						<img class="shape shape-2" src="{{asset($themeTrue.'images/heart.png')}}" alt="@lang('about img2')" />
					</div>
				</div>
				<div class="col-lg-6">
					<div class="text-box">
						<div class="header-text">
							<h5>@lang(@$aboutUs['description']->title)</h5>
							<h2 class="mb-4">@lang(@$aboutUs['description']->sub_title)</h2>
							<p>@lang(@$aboutUs['description']->short_description)</p>
							<a href="{{@$aboutUs->templateMedia()->button_link}}" target="_blank" class="btn-custom mt-4">@lang(@$aboutUs['description']->button_name)</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- /ABOUT-US -->
@endif
