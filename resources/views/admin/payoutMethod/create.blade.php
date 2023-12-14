@extends('admin.layouts.master')
@section('page_title', __('Add Method'))
@section('content')
	<div class="main-content">
		<section class="section">
			<div class="section-header">
				<h1>@lang('Add Method')</h1>
				<div class="section-header-breadcrumb">
					<div class="breadcrumb-item active">
						<a href="{{ route('admin.home') }}">@lang('Dashboard')</a>
					</div>
					<div class="breadcrumb-item">@lang('Add Method')</div>
				</div>
			</div>

			<div class="row mb-3">
				<div class="container-fluid" id="container-wrapper">
					@php
						$fieldName = is_null(old('fieldName')) ? [] : old('fieldName');
						$fieldType = is_null(old('fieldType')) ? [] : old('fieldType');
						$fieldValidation = is_null(old('fieldValidation')) ? [] : old('fieldValidation');
					@endphp
					<div class="row justify-content-md-center">
						<div class="col-lg-12">
							<div class="card mb-4 card-primary shadow">
								<div
									class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
									<h6 class="m-0 font-weight-bold text-primary">@lang('Add Method')</h6>
									<a href="{{ route('payout.method.list') }}" class="btn btn-sm btn-outline-primary">
										<i
											class="fas fa-arrow-left"></i> @lang('Back')</a>
								</div>
								<div class="card-body">
									<form action="{{ route('payout.method.add') }}" method="post"
										  enctype="multipart/form-data">
										@csrf
										<div class="row">
											<div class="col-md-12">
												<div class="form-group">
													<label for="methodName">@lang('Method Name')</label>
													<input type="text" name="methodName" value="{{ old('methodName') }}"
														   placeholder="@lang('Payment method name')"
														   class="form-control @error('methodName') is-invalid @enderror">
													<div class="invalid-feedback">
														@error('methodName') @lang($message) @enderror
													</div>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label for="min_limit">@lang('Min limit')</label>
													<div class="input-group">
														<input type="text" name="min_limit"
															   value="{{ old('min_limit') }}"
															   placeholder="@lang('Min limit')"
															   class="form-control @error('min_limit') is-invalid @enderror">
														<div class="input-group-append">
															<span
																class="form-control">{{config('basic.base_currency')}}</span>
														</div>
													</div>
													<div class="invalid-feedback">
														@error('min_limit') @lang($message) @enderror
													</div>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label for="max_limit">@lang('Max limit')</label>
													<div class="input-group">
														<input type="text" name="max_limit"
															   value="{{ old('max_limit') }}"
															   placeholder="@lang('Max limit')"
															   class="form-control @error('max_limit') is-invalid @enderror">
														<div class="input-group-append">
															<span
																class="form-control">{{config('basic.base_currency')}}</span>
														</div>
													</div>
													<div class="invalid-feedback">
														@error('max_limit') @lang($message) @enderror
													</div>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label for="percentage_charge">@lang('Percentage charge')</label>
													<div class="input-group">
														<input type="text" name="percentage_charge"
															   value="{{ old('percentage_charge') }}"
															   placeholder="@lang('Percentage charge')"
															   class="form-control @error('percentage_charge') is-invalid @enderror">
														<div class="input-group-append">
															<span
																class="form-control">{{config('basic.base_currency')}}</span>
														</div>
													</div>
													<div class="invalid-feedback">
														@error('percentage_charge') @lang($message) @enderror
													</div>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label for="fixed_charge">@lang('Fixed charge')</label>
													<div class="input-group">
														<input type="text" name="fixed_charge"
															   value="{{ old('fixed_charge') }}"
															   placeholder="@lang('Fixed charge')"
															   class="form-control @error('fixed_charge') is-invalid @enderror">
														<div class="input-group-append">
															<span
																class="form-control">{{config('basic.base_currency')}}</span>
														</div>
													</div>
													<div class="invalid-feedback">
														@error('fixed_charge') @lang($message) @enderror
													</div>
												</div>
											</div>
										</div>
										<div class="row align-items-center">
											<div class="col-md-12">
												<div class="form-group mb-4">
													<label class="col-form-label">@lang('Choose logo')</label>
													<div id="image-preview" class="image-preview">
														<label for="image-upload"
															   id="image-label">@lang('Choose File')</label>
														<input type="file" name="logo"
															   class="@error('logo') is-invalid @enderror"
															   id="image-upload"/>
													</div>
													<div class="invalid-feedback">
														@error('logo') @lang($message) @enderror
													</div>
												</div>
											</div>
											<div class="col-md-12">
												<div class="form-group">
													<label for="description">@lang('Description')</label>
													<textarea
														class="form-control @error('description') is-invalid @enderror"
														name="description" rows="5">{{ old('description') }}</textarea>
													<div
														class="invalid-feedback">@error('description') @lang($message)@enderror
													</div>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label>@lang('Active Method')</label>
													<div class="selectgroup w-100">
														<label class="selectgroup-item">
															<input type="radio" name="is_active" value="0"
																   class="selectgroup-input" {{ old('is_active') == 0 ? 'checked' : ''}}>
															<span class="selectgroup-button">@lang('OFF')</span>
														</label>
														<label class="selectgroup-item">
															<input type="radio" name="is_active" value="1"
																   class="selectgroup-input" {{ old('is_active') == 1 ? 'checked' : ''}}>
															<span class="selectgroup-button">@lang('ON')</span>
														</label>
													</div>
													@error('is_active')
													<span class="text-danger" role="alert">
														<strong>{{ __($message) }}</strong>
													</span>
													@enderror
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<a href="javascript:void(0);"
													   class="btn btn-primary btn-sm float-right addFieldData"><i
															class="fas fa-plus"></i> @lang('Add field')</a>
												</div>
											</div>
										</div>
										<hr>
										<div class="fieldDataWrapper">
											@if(old())
												@for($i = 0; $i<count($fieldType); $i++)
													<div class="row">
														<div class="col-md-4">
															<div class="form-group">
																<input type="text" name="fieldName[]"
																	   value="{{ $fieldName[$i] }}"
																	   placeholder="@lang('Field Name')"
																	   class="form-control @error('fieldName.'.$i) is-invalid @enderror">
																<div class="invalid-feedback">
																	@error("fieldName.".$i) @lang($message) @enderror
																</div>
															</div>
														</div>
														<div class="col-md-3">
															<div class="form-group">
																<select name="fieldType[]"
																		class="form-control @error('fieldType.'.$i) is-invalid @enderror">
																	<option
																		value="text" {{ ($fieldType[$i] == 'text') ? 'selected' : '' }}>@lang('Input Text')</option>
																	<option
																		value="textarea" {{ ($fieldType[$i] == 'textarea') ? 'selected' : '' }}>@lang('Textarea')</option>
																	<option
																		value="file" {{ ($fieldType[$i] == 'file') ? 'selected' : '' }}>@lang('File upload')</option>
																</select>
																<div class="invalid-feedback">
																	@error("fieldType.".$i) @lang($message) @enderror
																</div>
															</div>
														</div>
														<div class="col-md-3">
															<div class="form-group">
																<select name="fieldValidation[]"
																		class="form-control @error('fieldValidation.'.$i) is-invalid @enderror">
																	<option
																		value="required" {{ ($fieldValidation[$i] == 'required') ? 'selected' : '' }}>@lang('Required')</option>
																	<option
																		value="nullable" {{ ($fieldValidation[$i] == 'nullable') ? 'selected' : '' }}>@lang('Optional')</option>
																</select>
																<div class="invalid-feedback">
																	@error("fieldValidation.".$i) @lang($message) @enderror
																</div>
															</div>
														</div>
														<div class="col-md-1">
															<div class="form-group">
																<a href="javascript:void(0);"
																   class="btn btn-danger btn-sm removeDiv form-control form-control-sm"><i
																		class="fas fa-minus"></i></a>
															</div>
														</div>
													</div>
												@endfor
											@endif
										</div>
										<div class="row">
											<div class="col-md-12">
												<button type="submit"
														class="btn btn-primary btn-sm btn-block">@lang('Save Changes')</button>
											</div>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="fieldDataHtml d-none">
					<div class="row pt-3 pl-2">
						<div class="col-md-4">
							<div class="form-group">
								<input type="text" name="fieldName[]" value="" placeholder="@lang('Field Name')"
									   class="form-control form-control-sm">
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<select name="fieldType[]" class="form-control form-control-sm">
									<option value="text">@lang('Input Text')</option>
									<option value="textarea">@lang('Textarea')</option>
									<option value="file">@lang('File upload')</option>
								</select>
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<select name="fieldValidation[]" class="form-control form-control-sm">
									<option value="required">@lang('Required')</option>
									<option value="nullable">@lang('Optional')</option>
								</select>
							</div>
						</div>
						<div class="col-md-1">
							<div class="form-group">
								<a href="javascript:void(0);"
								   class="btn btn-danger btn-sm removeDiv form-control form-control-sm"><i
										class="fas fa-minus"></i></a>
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
	<script>
		'use strict'
		$(document).ready(function () {
			$(document).on('click', '.addFieldData', function (e) {
				e.preventDefault();
				let fieldDataHtml = $('.fieldDataHtml').html();
				$('.fieldDataWrapper').append(fieldDataHtml);
			});

			$(document).on('click', '.removeDiv', function (e) {
				e.preventDefault();
				$(this).closest('.row').remove();
			});

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
