@extends('admin.layouts.master')
@section('title')
	@lang('Create Category')
@endsection

@section('content')
	<div class="main-content">
		<section class="section">
			<div class="section-header">
				<h1>@lang("Create Category")</h1>
				<div class="section-header-breadcrumb">
					<div class="breadcrumb-item active"><a href="{{ route('admin.home') }}">@lang("Dashboard")</a></div>
					<div class="breadcrumb-item"><a href="{{route('admin.category.index')}}">@lang("Category List")</a></div>
					<div class="breadcrumb-item">@lang("Create Category")</div>
				</div>
			</div>

			<div class="section-body">
				<div class="row">
					<div class="col-12 col-md-12 col-lg-12">
						<div class="card mb-4 card-primary shadow-sm">
							<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
								<h5>@lang("Create Category")</h5>

								<a href="{{route('admin.category.index')}}" class="btn btn-sm  btn-primary mr-2">
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
												  action="{{ route('admin.category.store', $language->id) }}"
												  class="mt-4" enctype="multipart/form-data">
												@csrf
												<div class="row">
													<div class="col-sm-12 col-md-12 mb-3">
														<label for="name">@lang('Category Name')</label> <span class="text-danger">*</span>
														<input type="text" name="name[{{ $language->id }}]"
															   class="form-control  @error('name'.'.'.$language->id) is-invalid @enderror"
															   value="{{ old('name'.'.'.$language->id) }}" placeholder="@lang('Enter Category Name')">
														<div class="invalid-feedback">
															@error('name'.'.'.$language->id) @lang($message) @enderror
														</div>
														<div class="valid-feedback"></div>
													</div>

													@if ($loop->index == 0)
														<div class="col-sm-12 col-md-4">
															<div class="form-group">
																<label>@lang('Status')</label>
																<div class="selectgroup w-100">
																	<label class="selectgroup-item">
																		<input type="radio" name="status" value="1"
																			class="selectgroup-input" checked="">
																		<span class="selectgroup-button">@lang('ON')</span>
																	</label>
																	<label class="selectgroup-item">
																		<input type="radio" name="status" value="0" class="selectgroup-input">
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
													@endif
												</div>

												<button type="submit" class="btn waves-effect waves-light btn-rounded btn-primary btn-block mt-3">
													@lang('Save')
												</button>
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
