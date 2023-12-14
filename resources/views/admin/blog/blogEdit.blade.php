@extends('admin.layouts.master')

@section('title')
	@lang('Edit Blog')
@endsection

@section('content')

	<div class="main-content">
		<section class="section">
			<div class="section-header">
				<h1>@lang("Edit Blog")</h1>
				<div class="section-header-breadcrumb">
					<div class="breadcrumb-item active"><a href="{{ route('admin.home') }}">@lang("Dashboard")</a></div>
					<div class="breadcrumb-item"><a href="{{route('admin.blogList')}}">@lang("Blog List")</a></div>
					<div class="breadcrumb-item">@lang("Edit Blog")</div>
				</div>
			</div>
			<div class="card mb-4 card-primary shadow-sm">
				<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
					<h5>@lang("Edit Blog Category")</h5>

					<a href="{{route('admin.blogCategory')}}" class="btn btn-sm  btn-primary mr-2">
						<span><i class="fas fa-arrow-left"></i> @lang('Back')</span>
					</a>
				</div>
				<div class="card-body">
					<ul class="nav nav-tabs" id="myTab" role="tablist">
						@foreach($languages as $key => $language)
							<li class="nav-item">
								<a class="nav-link {{ $loop->first ? 'active' : '' }}" data-toggle="tab"
								   href="#lang-tab-{{ $key }}" role="tab" aria-controls="lang-tab-{{ $key }}"
								   aria-selected="{{ $loop->first ? 'true' : 'false' }}">@lang($language->name)</a>
							</li>
						@endforeach
					</ul>

					<div class="tab-content mt-2" id="myTabContent">
						@foreach($languages as $key => $language)
							<div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="lang-tab-{{ $key }}"
								 role="tabpanel">
								<form method="post" action="{{ route('admin.blogUpdate',[$id, $language->id]) }}"
									  class="mt-4" enctype="multipart/form-data">
									@csrf
									@method('put')

									@if ($loop->index == 0)
										<div class="row mb-3">
											<div class="col-sm-12 col-md-12 mb-3">
												<label for="blog_category_id"> @lang('Select Category') </label>
												<select name="blog_category_id"
														class="form-control @error('blog_category_id'.'.'.$language->id) is-invalid @enderror">
													@forelse ($blogCategory as $item)
														<option
															value="{{ optional($item->details)->blog_category_id }}" {{ optional($item->details)->blog_category_id == @$blogDetails[$language->id][0]->blog->blog_category_id ? 'selected' : '' }}>@lang(optional($item->details)->name)</option>
													@empty
													@endforelse
												</select>

												<div class="invalid-feedback">
													@error('blog_category_id'.'.'.$language->id) @lang($message) @enderror
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
												   value="<?php echo old('author'.$language->id, isset($blogDetails[$language->id]) ? @$blogDetails[$language->id][0]->author : '') ?>">
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
												   value="<?php echo old('title'.$language->id, isset($blogDetails[$language->id]) ? @$blogDetails[$language->id][0]->title : '') ?>">
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
												<textarea
													class="form-control summernote @error('details'.'.'.$language->id) is-invalid @enderror"
													name="details[{{ $language->id }}]" id="summernote" rows="15"
													value="<?php echo old('details'.$language->id, isset($blogDetails[$language->id]) ? @$blogDetails[$language->id][0]->details : '') ?>"><?php echo old('details' . $language->id, isset($blogDetails[$language->id]) ? @$blogDetails[$language->id][0]->details : '') ?></textarea>

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
													<div id="image-preview" class="image-preview"
														 style="background-image: url({{getFile((isset($blogDetails[$language->id]) ? @$blogDetails[$language->id][0]->blog->driver : ''),(isset($blogDetails[$language->id]) ? @$blogDetails[$language->id][0]->blog->image : ''))}}">
														<label for="image-upload"
															   id="image-label">@lang('Choose File')</label>
														<input type="file" name="image" class="" id="image-upload"/>
													</div>
													@error('image')
														<span class="text-danger">{{ $message }}</span>
													@enderror
												</div>
											</div>
										</div>
									@endif
									<button type="submit"
											class="btn waves-effect waves-light btn-rounded btn-primary btn-block mt-3">@lang('Save')</button>
								</form>
							</div>
						@endforeach
					</div>
				</div>
			</div>
		</section>
	</div>
@endsection

@push('extra_scripts')
	<script src="{{ asset('assets/dashboard/js/jquery.uploadPreview.min.js') }}"></script>
@endpush

@section('scripts')
	<script type="text/javascript">
		'use strict';
		$(document).ready(function () {
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
@endsection
