@extends('admin.layouts.master')
@section('title')
	@lang('Create Level')
@endsection

@section('content')
	<div class="main-content">
		<section class="section">
			<div class="section-header">
				<h1>@lang("Create Level")</h1>
				<div class="section-header-breadcrumb">
					<div class="breadcrumb-item active"><a href="{{ route('admin.home') }}">@lang("Dashboard")</a></div>
					<div class="breadcrumb-item"><a href="{{route('admin.level.index')}}">@lang("Level List")</a></div>
					<div class="breadcrumb-item">@lang("Create Level")</div>
				</div>
			</div>

			<div class="section-body">
				<div class="row">
					<div class="col-12 col-md-12 col-lg-12">
						<div class="card mb-4 card-primary shadow-sm">
							<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
								<h5>@lang("Create Level")</h5>

								<a href="{{route('admin.level.index')}}" class="btn btn-sm  btn-primary mr-2">
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
												  action="{{ route('admin.level.store', $language->id) }}"
												  class="mt-4" enctype="multipart/form-data">
												@csrf
												<div class="row">
													<div class="col-sm-12 col-md-6 mb-3">
														<label for="name">@lang('Level Name')</label> <span class="text-danger">*</span>
														<input type="text" name="name[{{ $language->id }}]"
															   class="form-control  @error('name'.'.'.$language->id) is-invalid @enderror"
															   value="{{ old('name'.'.'.$language->id) }}" placeholder="@lang('Enter Level Name')">
														<div class="invalid-feedback">
															@error('name'.'.'.$language->id) @lang($message) @enderror
														</div>
														<div class="valid-feedback"></div>
													</div>


													@if ($loop->index == 0)

														<div class="form-group col-sm-12 col-md-6 mb-4">
															<label for="minimum_complete_orders">@lang('Minimum Completed Orders (All Time)')</label> <span class="text-danger">*</span>
															<div class="input-group">
																<input type="text"
																	class="form-control"
																	name="minimum_complete_orders"
																	value="{{ old('minimum_complete_orders') }}"
																	onkeyup="this.value = this.value.replace (/^\.|[^\d\.]/g, '')"
																	placeholder="@lang('Enter Minimum completed orders')">
																<div class="input-group-append">
																	<div class="form-control">@lang('All Time')</div>
																</div>
															</div>
															@error('minimum_complete_orders')
																<span class="text-danger">{{ __($message) }}</span>
															@enderror
														</div>

														<div class="form-group col-sm-12 col-md-6 mb-4">
															<label for="minimum_earn_amount">@lang('Minimum Earn Amount')</label> <span class="text-danger">*</span>
															<div class="input-group">
																<input type="text"
																	class="form-control"
																	name="minimum_earn_amount"
																	value="{{ old('minimum_earn_amount') }}"
																	onkeyup="this.value = this.value.replace (/^\.|[^\d\.]/g, '')"
																	placeholder="@lang('Enter Minimum Earn Amount')">
																<div class="input-group-append">
																	<div class="form-control">
																		{{ config('basic.base_currency') ?? trans('USD') }}
																	</div>
																</div>
															</div>
															@error('minimum_earn_amount')
																<span class="text-danger">{{ __($message) }}</span>
															@enderror
														</div>

														<div class="form-group col-sm-12 col-md-6 mb-4">
															<label for="add_extra_services">@lang('Add Extra Services')</label> <span class="text-danger">*</span>
															<div class="input-group">
																<input type="text"
																	class="form-control @error('add_extra_services') is-invalid @enderror"
																	name="add_extra_services"
																	value="{{ old('add_extra_services') }}"
																	onkeyup="this.value = this.value.replace (/^\.|[^\d\.]/g, '')"
																	placeholder="@lang('Enter Add Extra Services')">
																<div class="input-group-append">
																	<div class="form-control">@lang('Per Service')</div>
																</div>
															</div>
															@error('add_extra_services')
																<span class="text-danger">{{ __($message) }}</span>
															@enderror
														</div>

												

														<div class="col-sm-12 col-md-4">
															<div class="form-group">
																<label>@lang('Status')</label> <span class="text-danger">*</span>
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

														<div class="col-sm-12 col-md-4">
															<div class="form-group mb-4">
																<label class="col-form-label">@lang("Upload Image")</label>
																<div id="image-preview" class="image-preview">
																	<label for="image-upload" id="image-label">@lang('Choose File')</label>
																	<input type="file" name="image" id="image-upload" required/>
																</div>
																@error('image')
																	<span class="text-danger">{{ __($message) }}</span>
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
