@extends('admin.layouts.master')
@section('page_title', __('Edit Method'))
@push('extra_styles')
	<link href="{{ asset('assets/dashboard/css/select2.min.css') }}" rel="stylesheet" type="text/css">
	<link rel="stylesheet" href="{{ asset('assets/dashboard/css/bootstrap-select.min.css') }}">
@endpush
@section('content')
	<div class="main-content">
		<section class="section">
			<div class="section-header">
				<h1>@lang('Edit Method')</h1>
				<div class="section-header-breadcrumb">
					<div class="breadcrumb-item active">
						<a href="{{ route('admin.home') }}">@lang('Dashboard')</a>
					</div>
					<div class="breadcrumb-item"><a
							href="{{ route('payout.method.list') }}">@lang('Available methods')</a></div>
					<div class="breadcrumb-item">@lang('Edit Method')</div>
				</div>
			</div>

			<div class="row mb-3">
				<div class="container-fluid" id="container-wrapper">
					@php
						if (old()) {
							$fieldName = is_null(old('fieldName')) ? [] : old('fieldName');
							$fieldType = is_null(old('fieldType')) ? [] : old('fieldType');
							$fieldValidation = is_null(old('fieldValidation')) ? [] : old('fieldValidation');
						} else {
							if (isset($payoutMethod->inputForm))
							{
								$inputForm = json_decode($payoutMethod->inputForm,true);
								$fieldName = array_column($inputForm,'label');
								$fieldType = array_column($inputForm,'type');
								$fieldValidation = array_column($inputForm,'validation');
							} else {
								$fieldName = [];
								$fieldType = [];
								$fieldValidation = [];
							}
						}
					@endphp
					<div class="row justify-content-md-center">
						<div class="col-lg-12">
							<div class="card mb-4 card-primary shadow">
								<div
									class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
									<h6 class="m-0 font-weight-bold text-primary">@lang('Edit Method')</h6>
									<a href="{{ route('payout.method.list') }}" class="btn btn-sm btn-outline-primary">
										<i
											class="fas fa-arrow-left"></i> @lang('Back')</a>
								</div>
								<div class="card-body">
									<form action="{{ route('payout.method.edit',$payoutMethod) }}" method="post"
										  enctype="multipart/form-data">
										@csrf
										@method('put')
										<div class="row">
											<div
												class="{{$payoutMethod->is_automatic == 0 ? 'col-md-12' : ($payoutMethod->code == 'flutterwave'?'col-md-4':'col-md-6')}}">
												<div class="form-group">
													<label for="methodName">@lang('Method Name')</label>
													<input type="text" name="methodName"
														   value="{{ old('methodName',$payoutMethod->methodName) }}"
														   placeholder="@lang('Payment method name')"
														   class="form-control @error('methodName') is-invalid @enderror">
													<div class="invalid-feedback">
														@error('methodName') @lang($message) @enderror
													</div>
												</div>
											</div>
											@if($payoutMethod->is_automatic == 1)
												@if($payoutMethod->bank_name)
													<div class="col-md-4">
														<div class="form-group">
															<label for="currency">@lang('Bank')</label>
															<select
																class="form-select form-control @error('banks') is-invalid @enderror"
																name="banks[]" multiple="multiple" id="selectCurrency"
																required>
																@foreach($payoutMethod->bank_name as $key => $bank)
																	@foreach($bank as $curKey => $singleBank)
																		<option value="{{ $curKey }}"
																				{{ in_array($curKey,$payoutMethod->banks) == true ? 'selected' : '' }} data-fiat="{{ $key }}"
																				required>{{ trans($curKey) }}</option>
																	@endforeach
																@endforeach
															</select>
															<div class="invalid-feedback">
																@error('banks') @lang($message) @enderror
															</div>
														</div>
													</div>
												@endif
											@endif
											@if($payoutMethod->is_automatic == 1)
												@if($payoutMethod->currency_lists)
													<div
														class="{{$payoutMethod->code == 'flutterwave'?'col-md-4':'col-md-6'}}">
														<div class="form-group">
															<label for="currency">@lang('Supported Currency')</label>
															<select
																class="form-select form-control @error('supported_currency') is-invalid @enderror"
																name="supported_currency[]" multiple="multiple"
																id="selectSupportedCurrency"
																required>
																@foreach($payoutMethod->currency_lists as $key => $currency)
																	<option
																		value="{{$key}}"
																		@foreach($payoutMethod->supported_currency as $sup)
																			@if($sup == $currency)
																				selected
																		@endif
																		@endforeach>{{$currency}}</option>
																@endforeach
															</select>
															<div class="invalid-feedback">
																@error('currency_lists') @lang($message) @enderror
															</div>
														</div>
													</div>
												@endif
											@endif
											<div class="col-md-6">
												<div class="form-group">
													<label for="min_limit">@lang('Min limit')</label>
													<div class="input-group">
														<input type="text" name="min_limit"
															   value="{{ old('min_limit', getAmount($payoutMethod->min_limit)) }}"
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
															   value="{{ old('max_limit', getAmount($payoutMethod->max_limit)) }}"
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
															   value="{{ old('percentage_charge', getAmount($payoutMethod->percentage_charge)) }}"
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
															   value="{{ old('fixed_charge', getAmount($payoutMethod->fixed_charge)) }}"
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
										@if($payoutMethod->is_automatic == 1)
											@if($payoutMethod->supported_currency)
												<div class="row mt-3">
													<div class="col-md-12">
														<div class="card card-primary shadow params-color">
															<div
																class="card-header text-dark font-weight-bold"> @lang('Conversion Rate')</div>
															<div class="card-body">
																<div class="row">
																	@foreach($payoutMethod->supported_currency as $key => $currency)
																		<div class="col-md-3">
																			<div class="form-group">
																				<div class="input-group">
																					<div class="input-group-append">
																			<span
																				class="form-control">@lang('1 '){{config('basic.base_currency')}} =</span>
																					</div>
																					<input type="text"
																						   name="rate[{{$key}}]"
																						   step="0.001"
																						   class="form-control"
																						   @foreach ($payoutMethod->convert_rate as $key1 => $rate )
																							   @php
																								   if($key == $key1){
																									   $rate = $rate;
																									   break;
																								   }else{
                                                                                                       $rate =1;
																								   }
																							   @endphp
																						   @endforeach
																						   value="{{$rate}}">
																					<div class="input-group-prepend">
																				<span
																					class="form-control">{{$currency}}</span>
																					</div>
																				</div>
																			</div>
																		</div>
																	@endforeach
																</div>
															</div>
														</div>
													</div>
												</div>
											@endif
										@endif
										@if($payoutMethod->is_automatic == 1)
											@if($payoutMethod->parameters)
												<div class="row mt-4">
													@foreach ($payoutMethod->parameters as $key => $parameter)
														<div class="col-md-4">
															<div class="form-group">
																<label
																	for="{{ $key }}">{{ __(strtoupper(str_replace('_',' ', $key))) }}</label>
																<input type="text" name="{{ $key }}"
																	   value="{{ old($key, $parameter) }}"
																	   id="{{ $key }}"
																	   class="form-control @error($key) is-invalid @enderror">
																<div class="invalid-feedback">
																	@error($key) @lang($message) @enderror
																</div>
															</div>
														</div>
													@endforeach
												</div>
											@endif
											@if($payoutMethod->extra_parameters)
												<div class="row">
													@foreach($payoutMethod->extra_parameters as $key => $param)
														<div class="col-md-6">
															<div class="form-group">
																<label
																	for="{{ $key }}">{{ __(strtoupper(str_replace('_',' ', $key))) }}</label>
																<div class="input-group">
																	<input type="text" name="{{ $key }}"
																		   class="form-control @error($key) is-invalid @enderror"
																		   value="{{ old($key, route($param, $payoutMethod->code )) }}"
																		   disabled>
																	<div class="input-group-append">
																		<button type="button"
																				class="btn btn-info copy-btn btn-sm">
																			<i class="fas fa-copy"></i>
																		</button>
																	</div>
																</div>
																<div class="invalid-feedback">
																	@error($key) @lang($message) @enderror
																</div>
															</div>
														</div>
													@endforeach
												</div>
											@endif
										@endif
										<div class="row align-items-center">
											<div class="col-md-6">
												<div class="form-group mb-4">
													<label class="col-form-label">@lang('Choose logo')</label>
													<div id="image-preview" class="image-preview"
														 style="background-image: url({{ getFile($payoutMethod->driver,$payoutMethod->logo) }});">
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
											@if($payoutMethod->is_sandbox == 1 && $payoutMethod->is_automatic == 1)
												<div class="col-md-6">
													<div class="form-group">
														<label>@lang('Enable test environment')</label>
														<div class="selectgroup w-100">
															<label class="selectgroup-item">
																<input type="radio" name="environment" value="live"
																	   class="selectgroup-input" {{ old('environment', $payoutMethod->environment) == 'live' ? 'checked' : ''}}>
																<span class="selectgroup-button">@lang('OFF')</span>
															</label>
															<label class="selectgroup-item">
																<input type="radio" name="environment" value="test"
																	   class="selectgroup-input" {{ old('environment', $payoutMethod->environment) == 'test' ? 'checked' : ''}}>
																<span class="selectgroup-button">@lang('ON')</span>
															</label>
														</div>
														@error('environment')
														<span class="text-danger" role="alert">
															<strong>{{ __($message) }}</strong>
														</span>
														@enderror
													</div>
												</div>
											@endif
											<div class="col-md-12">
												<div class="form-group">
													<label for="description">@lang('Description')</label>
													<textarea
														class="form-control @error('description') is-invalid @enderror"
														name="description"
														rows="5">{{ old('description', $payoutMethod->description) }}</textarea>
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
																   class="selectgroup-input" {{ old('is_active', $payoutMethod->is_active) == 0 ? 'checked' : ''}}>
															<span class="selectgroup-button">@lang('OFF')</span>
														</label>
														<label class="selectgroup-item">
															<input type="radio" name="is_active" value="1"
																   class="selectgroup-input" {{ old('is_active', $payoutMethod->is_active) == 1 ? 'checked' : ''}}>
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
											@if($payoutMethod->is_automatic == 0)
												<div class="col-md-6">
													<div class="form-group">
														<a href="javascript:void(0);"
														   class="btn btn-primary btn-sm float-right addFieldData"><i
																class="fas fa-plus"></i> @lang('Add field')</a>
													</div>
												</div>
											@else
												<div class="col-md-6">
													<div class="form-group">
														<label>@lang('Auto Update Currency Rate')</label>
														<div class="selectgroup w-100">
															<label class="selectgroup-item">
																<input type="radio" name="is_auto_update" value="0"
																	   class="selectgroup-input" {{ old('is_auto_update', $payoutMethod->is_auto_update) == 0 ? 'checked' : ''}}>
																<span class="selectgroup-button">@lang('OFF')</span>
															</label>
															<label class="selectgroup-item">
																<input type="radio" name="is_auto_update" value="1"
																	   class="selectgroup-input" {{ old('is_auto_update', $payoutMethod->is_auto_update) == 1 ? 'checked' : ''}}>
																<span class="selectgroup-button">@lang('ON')</span>
															</label>
														</div>
														@error('is_auto_update')
														<span class="text-danger" role="alert">
														<strong>{{ __($message) }}</strong>
													     </span>
														@enderror
													</div>
												</div>
											@endif
										</div>
										@if($payoutMethod->is_automatic == 0)
											<hr>
											<div class="fieldDataWrapper my-2 p-3">
												@if(!empty($fieldType))
													@for($i = 0; $i<count($fieldType); $i++)
														<div class="row">
															<div class="col-md-4">
																<div class="form-group">
																	<input type="text" name="fieldName[]"
																		   value="{{ $fieldName[$i] }}"
																		   placeholder="@lang('Field Name')"
																		   class="form-control @error('fieldName.'.$i)
															is-invalid @enderror">
																	<div class="invalid-feedback">
																		@error("fieldName.".$i) @lang($message)  @enderror
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
										@endif
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
					<div class="row">
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
	<script src="{{ asset('assets/dashboard/js/bootstrap-select.min.js') }}"></script>
	<script src="{{ asset('assets/dashboard/js/jquery.uploadPreview.min.js') }}"></script>
@endpush
@section('scripts')
	<script>
		'use strict'
		$(document).ready(function () {
			$(function () {
				$('#selectCurrency').selectpicker();
				$('#selectSupportedCurrency').selectpicker();
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

		$(document).on('click', '.addFieldData', function (e) {
			e.preventDefault();
			let fieldDataHtml = $('.fieldDataHtml').html();
			$('.fieldDataWrapper').append(fieldDataHtml);
		});

		$(document).on('click', '.removeDiv', function (e) {
			e.preventDefault();
			$(this).closest('.row').remove();
		});


		$(document).on('click', '.removeDiv', function (e) {
			e.preventDefault();
			$(this).closest('.row').remove();
		});

		$(document).on('click', '.copy-btn', function () {
			let _this = $(this)[0];
			let copyText = $(this).parents('.input-group-append').siblings('input');
			$(copyText).prop('disabled', false);
			copyText.select();
			document.execCommand("copy");
			$(copyText).prop('disabled', true);
			$(this).text('Coppied');
			setTimeout(function () {
				$(_this).text('');
				$(_this).html('<i class="fas fa-copy"></i>');
			}, 500);
		});
	</script>
@endsection
