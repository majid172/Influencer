@extends('admin.layouts.master')

@section('title')
	@lang('Create Blog')
@endsection


@section('content')
	<div class="main-content">
		<section class="section">
			<div class="section-header">
				<h1>@lang("Create Blog")</h1>
				<div class="section-header-breadcrumb">
					<div class="breadcrumb-item active"><a href="{{ route('admin.home') }}">@lang("Dashboard")</a></div>
					<div class="breadcrumb-item"><a href="{{route('admin.blogList')}}">@lang("Blog List")</a></div>
					<div class="breadcrumb-item">@lang("Create Blog")</div>
				</div>
			</div>
		</section>
		<div class="section-body">
			<div class="row">
				<div class="col-12 col-md-12 col-lg-12">
					<div class="card mb-4 card-primary shadow-sm">
						<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
							<h5>@lang("Create Blog")</h5>

							<a href="{{route('admin.blogList')}}" class="btn btn-sm  btn-primary mr-2">
								<span><i class="fas fa-arrow-left"></i> @lang('Back')</span>
							</a>
						</div>
						<div class="card-body">
							<ul class="nav nav-tabs" id="myTab" role="tablist">
								@foreach($languages as $key => $language)
									<li class="nav-item">
										<a class="nav-link {{ $loop->first ? 'active' : '' }}" data-toggle="tab" href="#lang-tab-{{ $key }}" role="tab" aria-controls="lang-tab-{{ $key }}"
										   aria-selected="{{ $loop->first ? 'true' : 'false' }}">@lang($language->name)</a>
									</li>
								@endforeach
							</ul>

							<div class="tab-content mt-2" id="myTabContent">
								@foreach($languages as $key => $language)

									<div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="lang-tab-{{ $key }}" role="tabpanel">
										<form method="post" action="{{ route('admin.blogStore', $language->id) }}"  class="mt-4" enctype="multipart/form-data">
											@csrf

											@if ($loop->index == 0)
												<div class="row mb-3">
													<div class="col-sm-12 col-md-12 mb-3">
														<label for="blog_category_id"> @lang('Select Category') </label>
														<select name="blog_category_id" class="form-control @error('blog_category_id') is-invalid @enderror">
															<option value="" disabled selected>@lang('Select One')</option>
															@foreach ($blogCategory as $item)
																<option value="{{ optional($item->details)->blog_category_id }}">@lang(optional($item->details)->name)</option>
															@endforeach
														</select>

														<div class="invalid-feedback">
															@error('blog_category_id') @lang($message) @enderror
														</div>
														<div class="valid-feedback"></div>
													</div>
												</div>
											@endif


											<div class="row">
												<div class="col-sm-12 col-md-12 mb-3">
													<label for="author"> @lang('Author') </label>
													<input type="text" name="author[{{ $language->id }}]"
														   class="form-control  @error('author'.'.'.$language->id) is-invalid @enderror"
														   value="{{ old('author'.'.'.$language->id) }}">
													<div class="invalid-feedback">
														@error('author'.'.'.$language->id) @lang($message) @enderror
													</div>
													<div class="valid-feedback"></div>
												</div>
											</div>

											<div class="row">
												<div class="col-sm-12 col-md-12 mb-3">
													<label for="name"> @lang('Title') </label>
													<input type="text" name="title[{{ $language->id }}]"
														   class="form-control  @error('title'.'.'.$language->id) is-invalid @enderror"
														   value="{{ old('title'.'.'.$language->id) }}">
													<div class="invalid-feedback">
														@error('title'.'.'.$language->id) @lang($message) @enderror
													</div>
													<div class="valid-feedback"></div>
												</div>
											</div>

											<div class="row">
												<div class="col-sm-12 col-md-12 my-3">
													<div class="form-group ">
														<label for="details"> @lang('Details') </label>
														<textarea class="form-control mb-0 summernote @error('details'.'.'.$language->id) is-invalid @enderror" name="details[{{ $language->id }}]" id="summernote" rows="15" value="{{ old('details'.'.'.$language->id) }}">{{old('details'.'.'.$language->id)}}</textarea>

														<div class="invalid-feedback">
															@error('details'.'.'.$language->id) @lang($message) @enderror
														</div>
														<div class="valid-feedback"></div>
													</div>
												</div>
											</div>

											@if ($loop->index == 0)
												<div class="row">
													<div class="col-sm-12 col-md-4">
														<div class="form-group mb-4">
															<label class="col-form-label">@lang("Upload Image")</label>
															<div id="image-preview" class="image-preview" style="background-image: url({{ getFile(config('location.category.path'))}}">
																<label for="image-upload" id="image-label">@lang('Choose File')</label>
																<input type="file" name="image" class="" id="image-upload"/>
															</div>
															@error('image')
																<span class="text-danger">{{ $message }}</span>
															@enderror
														</div>
													</div>
												</div>
											@endif

											<button type="submit" class="btn waves-effect waves-light btn-rounded btn-primary btn-block mt-3">@lang('Save')</button>
										</form>
									</div>
								@endforeach
							</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection


@push('extra_scripts')
	<script src="{{ asset('assets/dashboard/js/jquery.uploadPreview.min.js') }}"></script>
@endpush

@section('scripts')
	<script type="text/javascript">
		'use strict';
		$(document).ready(function() {
			$.uploadPreview({
				input_field: "#image-upload",
				preview_box: "#image-preview",
				label_field: "#image-label",
				label_default: "Choose File",
				label_selected: "Change File",
				no_label: false
			});
		});
	</script>

	@if ($errors->any())
		@php
			$collection = collect($errors->all());
			$errors = $collection->unique();
		@endphp
		<script>
			"use strict";
			@foreach ($errors as $error)
				Notiflix.Notify.Failure("{{trans($error)}}");
			@endforeach
		</script>
	@endif
@endsection
