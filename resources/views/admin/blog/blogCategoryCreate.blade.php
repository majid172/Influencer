@extends('admin.layouts.master')

@section('title')
	@lang('Create Blog Category')
@endsection

@section('content')
	<div class="main-content">
		<section class="section">
			<div class="section-header">
				<h1>@lang("Create Blog Category")</h1>
				<div class="section-header-breadcrumb">
					<div class="breadcrumb-item active"><a href="{{ route('admin.home') }}">@lang("Dashboard")</a></div>
					<div class="breadcrumb-item"><a href="{{route('admin.blogList')}}">@lang("Blog List")</a></div>
					<div class="breadcrumb-item">@lang("Create Blog Category")</div>
				</div>
			</div>

			<div class="section-body">
				<div class="row">
					<div class="col-12 col-md-12 col-lg-12">
						<div class="card mb-4 card-primary shadow-sm">
							<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
								<h5>@lang("Create Blog Category")</h5>

								<a href="{{route('admin.blogCategory')}}" class="btn btn-sm  btn-primary mr-2">
									<span><i class="fas fa-arrow-left"></i> @lang('Back')</span>
								</a>
							</div>
							<div class="card-body">
								<ul class="nav nav-tabs" id="myTab" role="tablist">
									@foreach($languages as $key => $language)
										<li class="nav-item">
											<a class="nav-link {{ $loop->first ? 'active' : '' }}" data-toggle="tab"
											   href="#lang-tab-{{ $key }}" role="tab"
											   aria-controls="lang-tab-{{ $key }}"
											   aria-selected="{{ $loop->first ? 'true' : 'false' }}">@lang($language->name)</a>
										</li>
									@endforeach
								</ul>

								<div class="tab-content mt-2" id="myTabContent">
									@foreach($languages as $key => $language)
										<div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}"
											 id="lang-tab-{{ $key }}" role="tabpanel">
											<form method="post"
												  action="{{ route('admin.blogCategoryStore', $language->id) }}"
												  class="mt-4" enctype="multipart/form-data">
												@csrf
												<div class="row">
													<div class="col-sm-12 col-md-12 mb-3">
														<label for="name"> @lang('Category Name') </label>
														<input type="text" name="name[{{ $language->id }}]"
															   class="form-control  @error('name'.'.'.$language->id) is-invalid @enderror"
															   value="{{ old('name'.'.'.$language->id) }}">
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
					</div>
				</div>
			</div>
		</section>
	</div>
@endsection

@push('scripts')
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
@endpush
