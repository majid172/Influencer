@if(isset($templates['experience'][0]) && $experience = $templates['experience'][0])
	<section class="experience-section">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="wrapper">
						<div class="row g-4 align-items-center">
						<div class="col-lg-4">
							<h3>@lang(optional($experience->description)->title)</h3>
						</div>
						<div class="col-lg-4">
							<div class="text">
								<p class="mb-0">@lang(optional($experience->description)->sub_title)</p>
							</div>
						</div>
						<div class="col-lg-4">
							<div class="d-flex justify-content-around">
								<div class="box">
									<h1>@lang(optional($experience->description)->years_experience)+</h1>
									<p>@lang('Years Experience')</p>
								</div>
								<div class="box">
									<h1>@lang(optional($experience->description)->project_done)%</h1>
									<p>@lang('Project Done')</p>
								</div>
							</div>
						</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
@endif
