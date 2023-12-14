@extends('admin.layouts.master')

@section('title')
	@lang('Edit Blog Category')
@endsection

@section('content')
	<div class="main-content">
		<section class="section">
			<div class="section-header">
				<h1>@lang("Edit Blog Category")</h1>
				<div class="section-header-breadcrumb">
					<div class="breadcrumb-item active"><a href="{{ route('admin.home') }}">@lang("Dashboard")</a></div>
					<div class="breadcrumb-item"><a href="{{route('admin.blogList')}}">@lang("Blog List")</a></div>
					<div class="breadcrumb-item">@lang("Edit Blog Category")</div>
				</div>
			</div>
			<div class="card mb-4 card-primary shadow-sm">
				<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
					<h5>@lang("Edit Blog Category")</h5>
				</div>
				<div class="card-body">
					<div class="media mb-4 justify-content-end">
						<a href="{{route('admin.blogCategory')}}" class="btn btn-sm  btn-primary mr-2">
							<span><i class="fas fa-arrow-left"></i> @lang('Back')</span>
						</a>
					</div>


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
								<form method="post"
									  action="{{ route('admin.blogCategoryUpdate',[$id, $language->id]) }}" class="mt-4"
									  enctype="multipart/form-data">
									@csrf
									@method('put')
									<div class="row">
										<div class="col-sm-12 col-md-12 mb-3">
											<label for="name"> @lang('Category Name') </label>
											<input type="text" name="name[{{ $language->id }}]"
												   class="form-control  @error('name'.'.'.$language->id) is-invalid @enderror"
												   value="<?php echo old('name'.$language->id, isset($blogCategoryDetails[$language->id]) ? @$blogCategoryDetails[$language->id][0]->name : '') ?>">
											<div class="invalid-feedback">
												@error('name'.'.'.$language->id) @lang($message) @enderror
											</div>
											<div class="valid-feedback"></div>
										</div>

									</div>

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

@section('javascripts')

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
