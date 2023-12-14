@extends('admin.layouts.master')
@section('page_title')
	{{ trans($page_title) }}
@endsection
@section('content')
	<div class="main-content">
		<section class="section">
			@if ($errors->any())
				<div class="alert alert-danger">
					<ul>
						@foreach ($errors->all() as $error)
							<li>{{ trans($error) }}</li>
						@endforeach
					</ul>
				</div>
			@endif
			<div class="section-header">
				<h1>@lang("Add Method")</h1>
				<div class="section-header-breadcrumb">
					<div class="breadcrumb-item active">
						<a href="{{ route('admin.home') }}">@lang('Dashboard')</a>
					</div>
					<div class="breadcrumb-item">@lang("Add Method")</div>
				</div>
			</div>
			<div class="row mb-3">
				<div class="container-fluid" id="container-wrapper">
					<div class="row">
						<div class="col-lg-12">
							<div class="card mb-4 card-primary shadow">
								<div
									class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
									<h6 class="m-0 font-weight-bold text-primary">@lang("Add Method")</h6>
									<a href="{{ route('admin.deposit.manual.index') }}"
									   class="btn btn-sm btn-outline-primary"> <i
											class="fas fa-arrow-left"></i> @lang('Back')</a>
								</div>
								<div class="card-body">
									<form method="post" action="" class="needs-validation base-form" novalidate=""
										  enctype="multipart/form-data">
										@csrf
										<div class="row">
											<div class="form-group col-md-4">
												<label>{{ trans('Name') }}</label>
												<input type="text"
													   class="form-control @error('name') is-invalid @enderror"
													   name="name"
													   value="{{ old('name') }}"
													   required="">
												<div class="invalid-feedback">
													@error('name') @lang($message) @enderror
												</div>
											</div>

											<div class="form-group col-md-4">
												<label>{{ trans('Currency') }}</label>
												<input type="text" class="form-control " name="currency"
													   value="{{ old('currency') }}" required="required">

												<div class="invalid-feedback">
													@error('currency') @lang($message) @enderror
												</div>
											</div>
											<div class="form-group col-md-4">
												<label>{{ trans('Convention Rate') }}</label>
												<div class="input-group ">
													<div class="input-group-prepend">
														<div class="form-control">
															1 {{ config('basic.base_currency') ?: 'USD' }} =
														</div>
													</div>
													<input type="text" class="form-control" name="convention_rate"
														   value="{{ old('convention_rate') }}" required>
													<div class="input-group-append">
														<div class="form-control set-currency">

														</div>
													</div>
												</div>
												<div class="invalid-feedback">
													@error('convention_rate') @lang($message) @enderror
												</div>
											</div>
										</div>
										<div class="row">
											<div class="form-group col-md-6 col-6">
												<label>{{ trans('Minimum Deposit Amount') }}</label>
												<div class="input-group ">
													<input type="text" class="form-control "
														   name="minimum_deposit_amount"
														   value="{{ old('minimum_deposit_amount') }}" required="">
													<div class="input-group-append">
														<div class="form-control">
															{{ config('basic.base_currency') ?? trans('USD') }}
														</div>
													</div>
												</div>
												<div class="invalid-feedback">
													@error('minimum_deposit_amount') @lang($message) @enderror
												</div>
											</div>
											<div class="form-group col-md-6 col-6">
												<label>{{ trans('Maximum Deposit Amount') }}</label>
												<div class="input-group ">
													<input type="text" class="form-control "
														   name="maximum_deposit_amount"
														   value="{{ old('maximum_deposit_amount') }}" required="">
													<div class="input-group-append">
														<div class="form-control">
															{{ config('basic.base_currency') ?? trans('USD') }}
														</div>
													</div>
												</div>
												<div class="invalid-feedback">
													@error('maximum_deposit_amount') @lang($message) @enderror
												</div>
											</div>
										</div>
										<div class="row">
											<div class="form-group col-md-6 col-6">
												<label>{{ trans('Percentage Charge') }}</label>
												<div class="input-group ">
													<input type="text" class="form-control " name="percentage_charge"
														   value="{{ old('percentage_charge') }}" required="">
													<div class="input-group-append">
														<div class="form-control">
															{{ trans('%') }}
														</div>
													</div>
												</div>
												<div class="invalid-feedback">
													@error('percentage_charge') @lang($message) @enderror
												</div>
											</div>
											<div class="form-group col-md-6 col-6">
												<label>@lang('Fixed Charge')</label>
												<div class="input-group ">
													<input type="text" class="form-control " name="fixed_charge"
														   value="{{ old('fixed_charge') }}" required="">
													<div class="input-group-append">
														<div class="form-control">
															{{ config('basic.base_currency') ?? trans('USD') }}
														</div>
													</div>
												</div>
												<div class="invalid-feedback">
													@error('fixed_charge') @lang($message) @enderror
												</div>
											</div>
										</div>

										<div class="row justify-content-between">
											<div class="col-md-6">
												<div class="form-group mb-4">
													<label class="col-form-label">@lang('Gateway Logo')</label>
													<div id="image-preview" class="image-preview">
														<label for="image-upload"
															   id="image-label">@lang('Choose File')</label>
														<input type="file" name="image"
															   class="@error('image') is-invalid @enderror"
															   id="image-upload"/>
													</div>
													<div class="invalid-feedback">
														@error('image') @lang($message) @enderror
													</div>
												</div>
											</div>
										</div>
										<div class="col-sm-12 col-md-12">
											<div class="form-group ">
												<label>@lang('Note')</label>
												<textarea class="form-control summernote" name="note"
														  id="summernote"
														  rows="15">{{ old('note') }}</textarea>
												@error('note')
												<span class="text-danger">{{ trans($message) }}</span>
												@enderror
											</div>
										</div>
										<div class="row mt-3 justify-content-between">
											<div class="col-lg-3 col-md-6">
												<div class="form-group">
													<label>@lang('Status')</label>
													<div class="selectgroup w-100">
														<label class="selectgroup-item">
															<input type="radio" name="status" value="0"
																   class="selectgroup-input">
															<span class="selectgroup-button">@lang('OFF')</span>
														</label>
														<label class="selectgroup-item">
															<input type="radio" name="status" value="1"
																   class="selectgroup-input" checked>
															<span class="selectgroup-button">@lang('ON')</span>
														</label>
													</div>
													@error('status')
													<span class="text-danger" role="alert">
														<strong>{{ __($message) }}</strong>
													</span>
													@enderror
												</div>
											</div>
											<div class="col-lg-3 col-md-6">
												<div class="form-group">
													<a href="javascript:void(0)"
													   class="btn btn-success float-right mt-3"
													   id="generate"><i class="fa fa-plus-circle"></i>
														{{ trans('Add Field') }}</a>
												</div>
											</div>
										</div>

										<div class="row addedField">

										</div>

										<button type="submit"
												class="btn btn-rounded btn-primary btn-block mt-3">@lang('Save Changes')</button>
									</form>
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
	<script>
		"use strict";
		setCurrency();
		$(document).on('change', 'input[name="currency"]', function () {
			setCurrency();
		});

		function setCurrency() {
			let currency = $('input[name="currency"]').val();
			$('.set-currency').text(currency);
		}

		$(document).on('click', '.copy-btn', function () {
			var _this = $(this)[0];
			var copyText = $(this).parents('.input-group-append').siblings('input');
			$(copyText).prop('disabled', false);
			copyText.select();
			document.execCommand("copy");
			$(copyText).prop('disabled', true);
			$(this).text('Coppied');
			setTimeout(function () {
				$(_this).text('');
				$(_this).html('<i class="fas fa-copy"></i>');
			}, 500)
		});


		$(document).on('click', '#generate', function () {
			var form = `<div class="col-md-12">
                                <div class="form-group">
                                    <div class="input-group">
                                        <input name="field_name[]" class="form-control " type="text" value="" required placeholder="{{ trans('Field Name') }}">

                                        <select name="type[]"  class="form-control  ">
                                            <option value="text">{{ trans('Input Text') }}</option>
                                            <option value="textarea">{{ trans('Textarea') }}</option>
                                            <option value="file">{{ trans('File upload') }}</option>
                                        </select>

                                        <select name="validation[]"  class="form-control  ">
                                            <option value="required">{{ trans('Required') }}</option>
                                            <option value="nullable">{{ trans('Optional') }}</option>
                                        </select>

                                        <span class="input-group-btn">
                                            <button class="btn btn-danger delete_desc" type="button">
                                                <i class="fa fa-times"></i>
                                            </button>
                                        </span>
                                    </div>
                                </div>
                            </div> `;

			$('.addedField').append(form)
		});


		$(document).on('click', '.delete_desc', function () {
			$(this).closest('.input-group').parent().remove();
		});

		$('.summernote').summernote({
			height: 250,
			callbacks: {
				onBlurCodeview: function () {
					let codeviewHtml = $(this).siblings('div.note-editor').find('.note-codable')
						.val();
					$(this).val(codeviewHtml);
				}
			}
		});
	</script>
	<script>
		$(document).ready(function (e) {
			"use strict";
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
