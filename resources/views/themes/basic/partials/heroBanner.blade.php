@if(isset($templates['hero'][0]) && $hero = $templates['hero'][0])
	<section class="home-section">
		<div class="overlay h-100">
			<div class="container h-100">
				<div class="row gy-5 h-100 align-items-center">
					<div class="col-lg-6">
						<div class="text-box">
							<h1>@lang(@$hero['description']->title)</h1>
							<h3>@lang(@$hero['description']->sub_title)</h3>
							<p>@lang(@$hero['description']->short_description)</p>
							<a href="{{@$hero->templateMedia()->button_link}}" class="btn-custom mt-4" target="_blank">
								@lang(@$hero['description']->button_name)
							</a>
						</div>
					</div>
					<div class="col-lg-6">
						<div class="img-box">
							<img src="{{getFile(optional($hero->media)->driver,@$hero->templateMedia()->image)}}"
								 class="img-fluid" alt="@lang('hero img')"/>
							<img class="shape shape-2" src="{{asset($themeTrue.'images/like_comments.png')}}" alt="@lang('hero img2')"/>
							<img class="shape shape-1" src="{{asset($themeTrue.'images/comments.png')}}" alt="@lang('hero img1')"/>
							<img class="shape shape-3" src="{{asset($themeTrue.'images/hear_comments.png')}}" alt="@lang('hero img3')" />
							<img class="shape shape-4" src="{{asset($themeTrue.'images/dots.png')}}" alt="@lang('hero img4')"/>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
@endif
