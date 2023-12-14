@extends('admin.layouts.master')

@section('title')
	@lang('Edit Sub-Category')
@endsection

@section('content')

	<div class="main-content">
		<section class="section">
			<div class="section-header">
				<h1>@lang("Edit Sub-Category")</h1>
				<div class="section-header-breadcrumb">
					<div class="breadcrumb-item active"><a href="{{ route('admin.home') }}">@lang("Dashboard")</a></div>
					<div class="breadcrumb-item"><a href="{{route('admin.subCategory.index')}}">@lang("Sub-Category List")</a></div>
					<div class="breadcrumb-item">@lang("Edit Sub-Category")</div>
				</div>
			</div>
			<div class="card mb-4 card-primary shadow-sm">
				<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
					<h5>@lang("Edit Sub-Category")</h5>

					<a href="{{route('admin.subCategory.index')}}" class="btn btn-sm  btn-primary mr-2">
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
								<form method="post" action="{{ route('admin.subCategory.update',[$id, $language->id]) }}"
									  class="mt-4" enctype="multipart/form-data">
									@csrf
									@method('put')

									@if ($loop->index == 0)
										<div class="row mb-3">
											<div class="col-sm-12 col-md-12 mb-3">
												<label for="category_id"> @lang('Select Category') </label>
												<select name="category_id"
														class="form-control @error('category_id'.'.'.$language->id) is-invalid @enderror">
													@forelse ($category as $item)
														<option
															value="{{ optional($item->details)->category_id }}" {{old('category_id'), optional($item->details)->category_id == @$SubCategoryDetails[$language->id][0]->subCategory->category_id ? 'selected' : '' }}>@lang(optional($item->details)->name)</option>
													@empty
													@endforelse
												</select>

												<div class="invalid-feedback">
													@error('category_id'.'.'.$language->id) @lang($message) @enderror
												</div>
												<div class="valid-feedback"></div>
											</div>
										</div>
									@endif


									<div class="row">
										<div class="col-sm-12 col-md-12 mb-3">
											<label for="name"> @lang('Sub-Category Name') </label>
											<input type="text" name="name[{{ $language->id }}]"
												   class="form-control  @error('name'.'.'.$language->id) is-invalid @enderror"
												   value="<?php echo old('name'.$language->id, isset($SubCategoryDetails[$language->id]) ? @$SubCategoryDetails[$language->id][0]->name : '') ?>">
											<div class="invalid-feedback">
												@error('name'.'.'.$language->id) @lang($message) @enderror
											</div>
											<div class="valid-feedback"></div>
										</div>
									</div>

									@if ($loop->index == 0)
										<div class="row">
											<div class="col-sm-12 col-md-4">
												<div class="form-group">
													<label>@lang('Status')</label>
													<div class="selectgroup w-100">
														<label class="selectgroup-item">
															<input type="radio" name="status" value="1"
																class="selectgroup-input" {{ optional($SubCategoryDetails[$language->id][0]->subCategory)->status == 1 ? 'checked' : ''}}>
															<span class="selectgroup-button">@lang('ON')</span>
														</label>
														<label class="selectgroup-item">
															<input type="radio" name="status" value="0" class="selectgroup-input" {{ optional($SubCategoryDetails[$language->id][0]->subCategory)->status == 0 ? 'checked' : ''}}>
															<span class="selectgroup-button">@lang('OFF')</span>
														</label>
													</div>
													@error('status')
														<span class="text-danger" role="alert">
															<strong>{{ __($message) }}</strong>
														</span>
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


@section('scripts')
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
