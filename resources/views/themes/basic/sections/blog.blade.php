<!-- BLOG -->
@if(isset($templates['blog'][0]) && $blog = $templates['blog'][0])
	@if(0 < count($blogs))
		<section class="blog-section">
			<div class="container">
				<div class="row">
					<div class="col-12">
						<div class="header-text text-center">
							<h5>@lang(optional($blog->description)->title)</h5>
							<h2>@lang(optional($blog->description)->sub_title)</h2>
						</div>
					</div>
				</div>
				<div class="row g-4 g-lg-5">
					<div class="col-lg-5 col-xl-6">
						@foreach($blogs->take(1)->sortDesc()->shuffle() as $key => $blog)
							@if($key == 0)
								<div class="blog-box">
									<div class="img-box">
										<img src="{{getFile($blog->driver,$blog->image)}}" class="img-fluid" alt="@lang('blog img')" />
									</div>
									<div class="text-box">
										<a href="{{route('blogDetails',[slug(optional($blog->details)->title), $blog->id])}}" class="title">@lang(\Illuminate\Support\Str::limit(optional($blog->details)->title,34))</a>
										<div class="date-author">
											<span><i class="fal fa-user-circle"></i> @lang(optional($blog->details)->author)</span>
											<span> | </span>
											<span class="date"><i class="fal fa-clock"></i> {{dateTime($blog->created_at,'d M, Y')}}</span>
											<span> | </span>
											<span><i class="fal fa-tags"></i> @lang(optional(optional($blog->category)->details)->name)</span>
										</div>
										<p>@lang(Str::limit(optional($blog->details)->details,220))</p>
										<a href="{{route('blogDetails',[slug(@$blog->details->title), $blog->id])}}" class="btn-custom">@lang('Read More')</a>
									</div>
								</div>
							@endif
						@endforeach
					</div>

					<div class="col-lg-7 col-xl-6">
						@foreach($blogs->take(4)->sortDesc()->shuffle() as $key => $blog)
							@if($key != 0)
								<div class="blog-box d-flex">
									<div class="img-box">
										<img src="{{getFile($blog->driver,$blog->image)}}" class="img-fluid" alt="" />
									</div>
									<div class="text-box">
										<a href="{{route('blogDetails',[slug(optional($blog->details)->title), $blog->id])}}" class="title">@lang(\Illuminate\Support\Str::limit(optional($blog->details)->title,34))</a>
										<div class="date-author">
											<span><i class="fal fa-user-circle"></i> @lang(optional($blog->details)->author)</span>
											<span> | </span>
											<span class="date"><i class="fal fa-clock"></i> {{dateTime($blog->created_at,'d M, Y')}}</span>
										</div>
										<p>@lang(Str::limit(optional($blog->details)->details,70))</p>
										<a href="{{route('blogDetails',[slug(optional($blog->details)->title), $blog->id])}}" class="btn-custom">@lang('Read More')</a>
									</div>
								</div>
							@endif
						@endforeach
					</div>
				</div>
			</div>
		</section>
	@endif
@endif
<!-- /BLOG -->

