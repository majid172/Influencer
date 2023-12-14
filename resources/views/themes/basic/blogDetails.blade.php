@extends($theme.'layouts.app')
@section('title',trans('Blog Details'))

@section('content')

    <!-- BLOG -->
	<section class="blog-page blog-details">
		<div class="container">
			<div class="row g-lg-5">
				<div class="col-lg-8">
					<div class="blog-box">
						<div class="img-box">
							<img src="{{getFile($singleBlog->driver,$singleBlog->image)}}" class="img-fluid" alt="@lang('blog img')" />
						</div>
						<div class="text-box">
							<div class="date-author d-flex justify-content-between">
								<span><i class="fal fa-clock"></i> {{dateTime($singleBlog->created_at,'d M, Y')}}</span>
								<span><i class="fal fa-user-circle"></i> @lang(optional($singleBlog->details)->author)</span>
								<span><i class="fal fa-tags"></i> @lang($thisCategory->name)</span>
							</div>
							<h5 class="title">@lang(optional($singleBlog->details)->title)</h5>
							<p>{!! trans(optional($singleBlog->details)->details) !!}</p>
						</div>
					</div>

					<div id="shareBlock">
						<h4>@lang('Share now') : </h4>
					</div>
				</div>


				<div class="col-lg-4">
					<div class="side-bar">

						<div class="side-box search-box">
							<form action="{{ route('blogSearch') }}" method="get">
                                @csrf
								<h4>@lang('Search here')</h4>
								<div class="input-group">
									<input type="text" class="form-control" name="search" id="search" placeholder="@lang('search here...')"/>
									<button type="submit"><i class="fal fa-search" aria-hidden="true"></i></button>
								</div>
							</form>
						</div>


						@if (count($relatedBlogs) > 0)
							<div class="side-box">
								<h4>@lang('Recent Posts')</h4>
								@foreach ($relatedBlogs->take(3)->sortDesc()->shuffle() as $blog)
									<div class="blog-box">
										<div class="img-box">
											<img class="img-fluid" src="{{ getFile($blog->driver, $blog->image) }}" alt="@lang('related blog img')" />
										</div>
										<div class="text-box">
											<span class="date">{{dateTime($blog->created_at,'d M, Y')}}</span>
											<a href="{{route('blogDetails',[slug($blog->details->title), $blog->id])}}" class="title">@lang(\Illuminate\Support\Str::limit(optional($blog->details)->title,40))</a>
										</div>
									</div>
								@endforeach
							</div>
						@endif


						<div class="side-box">
							<h4>@lang('categories')</h4>
							<ul class="links">
								@foreach ($blogCategory as $category)
								<li><a href="{{ route('CategoryWiseBlog', [slug(optional($category->details)->name), $category->id]) }}">@lang(optional($category->details)->name) ({{$category->blog_count}})</a></li>
								@endforeach
							</ul>
						</div>

					</div>
				</div>

			</div>
		</div>
	</section>
    <!-- /BLOG -->
@endsection
