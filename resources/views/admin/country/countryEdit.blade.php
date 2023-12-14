@extends('admin.layouts.master')
@section('title')
	@lang('Edit Country')
@endsection

@section('content')
	<div class="main-content">
		<section class="section">
			<div class="section-header">
				<h1>@lang("Edit Country")</h1>
				<div class="section-header-breadcrumb">
					<div class="breadcrumb-item active"><a href="{{ route('admin.home') }}">@lang("Dashboard")</a></div>
					<div class="breadcrumb-item"><a href="{{route('admin.countryList')}}">@lang("Country List")</a></div>
					<div class="breadcrumb-item">@lang("Edit Country")</div>
				</div>
			</div>

			<div class="section-body">
				<div class="row">
					<div class="col-12 col-md-12 col-lg-12">
						<div class="card mb-4 card-primary shadow-sm">
							<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
								<h5>@lang("Edit Country")</h5>

								<a href="{{route('admin.countryList')}}" class="btn btn-sm  btn-primary mr-2">
									<span><i class="fas fa-arrow-left"></i> @lang('Back')</span>
								</a>
							</div>
							<div class="card-body">
								<form method="post" action="{{ route('admin.countryUpdate',[$id]) }}" class="mt-4" enctype="multipart/form-data">
									@csrf
									@method('put')
									<div class="row">
										<div class="col-sm-12 col-md-12 mb-3">
											<label for="name">@lang('Country Name')</label> <span class="text-danger">*</span>
											<input type="text" class="form-control @error('name') is-invalid @enderror"
												name="name"
												value="<?php echo old('name', isset($countryList) ? @$countryList[0]->name : '') ?>"
												placeholder="@lang('Enter Country Name')"
											>
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
