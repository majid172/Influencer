@extends('admin.layouts.master')
@section('title')
	@lang('Edit City')
@endsection

@section('content')
	<div class="main-content">
		<section class="section">
			<div class="section-header">
				<h1>@lang("Edit City")</h1>
				<div class="section-header-breadcrumb">
					<div class="breadcrumb-item active"><a href="{{ route('admin.home') }}">@lang("Dashboard")</a></div>
					<div class="breadcrumb-item"><a href="{{route('admin.cityList')}}">@lang("City List")</a></div>
					<div class="breadcrumb-item">@lang("Edit City")</div>
				</div>
			</div>

			<div class="section-body">
				<div class="row">
					<div class="col-12 col-md-12 col-lg-12">
						<div class="card mb-4 card-primary shadow-sm">
							<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
								<h5>@lang("Edit City")</h5>

								<a href="{{route('admin.cityList')}}" class="btn btn-sm  btn-primary mr-2">
									<span><i class="fas fa-arrow-left"></i> @lang('Back')</span>
								</a>
							</div>
							<div class="card-body">
								<form method="post" action="{{ route('admin.cityUpdate',[$id]) }}" class="mt-4" enctype="multipart/form-data">
									@csrf
									@method('put')
									<div class="row">
										<div class="col-sm-12 col-md-12 mb-4">
											<label for="state_id"> @lang('Select State') </label>
											<select name="state_id" class="form-control @error('state_id') is-invalid @enderror">
												@forelse ($stateList as $item)
													<option value="{{ $item->id }}" {{ $item->id == $cityList[0]->state_id ? 'selected' : '' }}>@lang($item->name)</option>
												@empty
												@endforelse
											</select>

											<div class="invalid-feedback mt-3">
												@error('state_id') @lang($message) @enderror
											</div>
											<div class="valid-feedback"></div>
										</div>

										<div class="col-sm-12 col-md-12 mb-3">
											<label for="name"> @lang('City Name') </label>
											<input type="text" name="name"
												class="form-control  @error('name') is-invalid @enderror"
												value="<?php echo old('name', isset($cityList) ? @$cityList[0]->name : '') ?>">
											<div class="invalid-feedback">
												@error('name') @lang($message) @enderror
											</div>
											<div class="valid-feedback"></div>
										</div>
									</div>

									<button type="submit" class="btn waves-effect waves-light btn-rounded btn-primary btn-block mt-3">
										@lang('Save')
									</button>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
	</div>
@endsection


@push('extra_styles')
	<link rel="stylesheet" href="{{ asset('assets/dashboard/css/select2.min.css') }}">
@endpush
@push('extra_scripts')
	<script src="{{ asset('assets/dashboard/js/select2.min.js') }}"></script>
@endpush

@push('scripts')
	<script>
		"use strict";
		$(document).ready(function (e) {
			$('select').select2({
				selectOnClose: true
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
@endpush
