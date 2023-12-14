@extends($theme.'layouts.app')
@section('title', trans($title))

@section('content')
    <!-- BLOG -->
	<section class="blog-section blog-page">
		<div class="container">
			<div class="row g-4 g-lg-5">
				@forelse ($allBlogs as $blog)
					@isset($blog->details)
						<div class="col-lg-4 col-md-6">
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
									</div>
									<p>{!! trans(\Illuminate\Support\Str::limit(optional($blog->details)->details,220)) !!}</p>
									<a href="{{route('blogDetails',[slug(optional($blog->details)->title), $blog->id])}}" class="btn-custom">@lang('Read More')</a>
								</div>
							</div>
						</div>
					@endisset
				@empty
					<div class="d-flex flex-column justify-content-center align-items-center">
						<img src="{{asset($themeTrue.'images/blog_search.png')}}" class="img-fluid no-blog-img" alt="">
						<h3 class="">@lang('Opps!')</h3>
						<h4 class="">@lang('No Blog Post Available.')</h4>
						<a href="{{ request()->routeIs('blog') ? route('home') : route('blog')  }}" class="btn-custom mt-4 text-center"><i class="fas fa-arrow-left"></i> @lang('Back')</a>
					</div>
				@endforelse
			</div>

			{{ $allBlogs->appends($_GET)->links() }}

		</div>
	</section>


@endsection
