@extends($theme.'layouts.user')
@section('title',trans('Payout Confirm'))
@section('content')
	<div class="main col-xl-9 col-lg-8 col-md-6 change-passwordontent">
		<div class="col-12">
				<div class="row mb-3">
					<section class="profile-setting">
						<div class="row justify-content-md-center">
							<div class="col-md-6 mb-3">
								<div class="sidebar-wrapper">
									<form action="{{ route('payout.paystack',$payout->utr) }}"
										  method="post"
										  enctype="multipart/form-data">
										@csrf
										<input type="hidden" class="type" name="type" value="">
										<input type="hidden" class="currency" name="currency" value="">
										@if($payoutMethod->supported_currency)
											<div class="row">
												<div class="col-md-12">
													<div class="form-group input-box search-currency-dropdown">
														<label for="from_wallet">@lang('Select Bank Currency')</label>
														<select id="from_wallet" name="currency_code"
																class="form-control form-control-sm transfer-currency">
															<option value="" disabled=""
																	selected="">@lang('Select Currency')</option>
															@foreach($payoutMethod->supported_currency as $singleCurrency)
																<option
																	value="{{$singleCurrency}}"
																	@foreach($payoutMethod->convert_rate as $key => $rate)
																		@if($singleCurrency == $key) data-rate="{{$rate}}" @endif
																	@endforeach {{old('currency_code') == $singleCurrency ?'selected':''}}>{{$singleCurrency}}</option>
															@endforeach
														</select>
														@error('currency_code')
														<span class="text-danger">{{$message}}</span>
														@enderror
													</div>
												</div>
											</div>
										@endif
										<div class="row dynamic-bank mx-1  d-none mt-3 input-box">
											<label>@lang('Select Bank')</label>
											<select id="dynamic-bank" name="bank"
													class="form-control form-control-sm">
											</select>
											@error('bank')
											<span class="text-danger">{{$message}}</span>
											@enderror
										</div>
										@if(isset($payoutMethod->inputForm))
											@foreach(json_decode($payoutMethod->inputForm) as $key => $value)
												@if($value->type == 'text')
													<div class="form-group input-box mt-3">
														<label for="{{ $value->name }}">@lang($value->label)</label>
														<input type="text" name="{{ $value->name }}"
															   placeholder="{{ __($value->label) }}"
															   autocomplete="off"
															   value="{{ old($value->name) }}"
															   class="form-control @error($value->name) is-invalid @enderror">
														<div
															class="invalid-feedback">@error($value->name) @lang($message) @enderror</div>
													</div>
												@elseif($value->type == 'textarea')
													<div class="form-group input-box mt-3">
														<label for="{{ $value->name }}">@lang($value->label)</label>
														<textarea
															class="form-control @error($value->name) is-invalid @enderror"
															name="{{$value->name}}"
															rows="5">{{ old($value->name) }}</textarea>
														<div
															class="invalid-feedback">@error($value->name) @lang($message) @enderror</div>
													</div>
												@elseif($value->type == 'file')
													<div class="form-group mb-4 input-box mt-3">
														<label class="col-form-label">@lang('Choose File')</label>
														<div id="image-preview" class="image-preview">
															<label for="image-upload"
																   id="image-label">@lang('Choose File')</label>
															<input type="file" name="{{ $value->name }}"
																   class="@error($value->name) is-invalid @enderror"
																   id="image-upload"/>
														</div>
														<div class="invalid-feedback">
															@error($value->name) @lang($message) @enderror
														</div>
													</div>
												@endif
											@endforeach
										@endif
										<button type="submit" id="submit"
												class="btn-custom mt-3">@lang('Send Request')</button>
									</form>
								</div>
							</div>
							<div class="col-md-6">
								<div class="sidebar-wrapper">
									<h6 class="mb-3 font-weight-bold text-dark">@lang('Details')</h6>
									<ul class="list-group">
										<li class="list-group-item d-flex justify-content-between align-items-center">
											<span>@lang('Payout Method')</span>
											<span class="text-info">{{ __($payoutMethod->methodName) }} </span>
										</li>
										<li class="list-group-item d-flex justify-content-between align-items-center">
											<span>@lang('Request Amount')</span>
											<span
												class="text-success">{{ (getAmount($payout->amount)) }} {{ config('basic.base_currency') }}</span>
										</li>
										<li class="list-group-item d-flex justify-content-between align-items-center">
											<span>@lang('Charge Amount')</span>
											<span
												class="text-danger">{{ (getAmount($payout->charge)) }} {{ config('basic.base_currency') }}</span>
										</li>
										<li class="list-group-item d-flex justify-content-between align-items-center">
											<span>@lang('Total Payable')</span>
											<span
												class="text-danger">{{ (getAmount($payout->transfer_amount)) }} {{ config('basic.base_currency') }}</span>
										</li>
										<li class="list-group-item d-flex justify-content-between align-items-center">
											<span>@lang('Available Balance')</span>
											<span
												class="text-success">{{ (getAmount(auth()->user()->balance - $payout->transfer_amount)) }} {{ config('basic.base_currency') }}</span>
										</li>
										<div class="dynamic">

										</div>
									</ul>
								</div>
							</div>
						</div>
					</section>
				</div>
			</div>
		</div>
	</div>
@endsection

@push('extra_scripts')
	<script src="{{ asset('assets/dashboard/js/jquery.uploadPreview.min.js') }}"></script>
@endpush
@section('scripts')
	<script type="text/javascript">
		var bankName = null;
		var payAmount = '{{$payout->amount}}'
		var baseCurrency = "{{config('basic.base_currency')}}"
		var currency_code = "{{old('currency_code')}}";
		if (currency_code) {
			getBankForm(currency_code);
		}

		$(document).on("change", "#dynamic-bank", function () {
			let type = $(this).find(':selected').data('type');
			let currency = $(this).find(':selected').data('currency');

			$('.type').val(type);
			$('.currency').val(currency);
		})

		$(document).on("change", ".transfer-currency", function () {
			let currencyCode = $(this).val();
			let rate = $(this).find(':selected').data('rate');
			let getAmount = parseFloat(rate) * parseFloat(payAmount);
			var output = null;
			$('.dynamic').html('');
			output = `<li class="list-group-item d-flex justify-content-between align-items-center">
						<span>@lang('Exchange rate')</span>
							<span class="text-primary">1 ${baseCurrency} = ${rate} ${currencyCode}</span></li>
					  <li class="list-group-item d-flex justify-content-between align-items-center">
					    <span>@lang('You will get')</span>
					      <span class="text-success">${getAmount} ${currencyCode}</span></li>`

			$('.dynamic').html(output);
		})

		$(document).ready(function () {
			$.uploadPreview({
				input_field: "#image-upload",
				preview_box: "#image-preview",
				label_field: "#image-label",
				label_default: "Choose File",
				label_selected: "Change File",
				no_label: false
			});

			$(document).on("change", ".transfer-currency", function () {
				currencyCode = $(this).val();
				$('.dynamic-bank').addClass('d-none');
				getBankForm(currencyCode);
			})
		});

		function getBankForm(currencyCode) {
			$.ajax({
				url: "{{route('payout.getBankList')}}",
				type: "post",
				data: {
					currencyCode,
				},
				success: function (response) {
					if (response.data != null) {
						showBank(response.data)
					}
				}
			});
		}

		function showBank(bankLists) {
			$('#dynamic-bank').html(``);
			var options = `<option disabled selected>@lang("Select Bank")</option>`;
			for (let i = 0; i < bankLists.length; i++) {
				options += `<option value="${bankLists[i].code}" data-type="${bankLists[i].type}" data-currency="${bankLists[i].currency}">${bankLists[i].name}</option>`;
			}

			$('.dynamic-bank').removeClass('d-none');
			$('#dynamic-bank').html(options);
		}
	</script>
	@if ($errors->any())
		@php
			$collection = collect($errors->all());
			$errors = $collection->unique();
		@endphp
		<script>
			"use strict";
			@foreach ($errors as $error)
			Notiflix.Notify.Failure("{{ trans($error) }}");
			@endforeach
		</script>
	@endif
@endsection
