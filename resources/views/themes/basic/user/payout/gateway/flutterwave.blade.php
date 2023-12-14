@extends($theme.'layouts.user')
@section('title',trans('Payout Confirm'))
@section('content')

	<div class="main col-xl-9 col-lg-8 col-md-6 change-passwordontent">
		<div class="col-12">
			<div class="row mb-3">
				<section class="profile-setting">
					<div class="row justify-content-md-center">
						<div class="col-md-6 mb-3">
							<div class="sidebar-wrapper p-3">
								<form action="{{ route('payout.flutterwave',$payout->utr) }}"
									  method="post" enctype="multipart/form-data">
									@csrf
									<div class="row mb-3">
										<div class="col-md-12">
											<div class="input-box search-currency-dropdown">
												<label for="from_wallet">@lang('Select Transfer')</label>
												<select id="from_wallet" name="transfer_name"
														class="form-control form-control-sm bank">
													<option value="" disabled=""
															selected="">@lang('Select Transfer')</option>
													@foreach($payoutMethod->banks as $bank)
														<option
															value="{{$bank}}" {{old('transfer_name') == $bank ?'selected':''}}>{{$bank}}</option>
													@endforeach
												</select>
												@error('transfer_name')
												<span class="text-danger">{{$message}}</span>
												@enderror
											</div>
										</div>
									</div>
									@if($payoutMethod->supported_currency)
										<div class="row">
											<div class="col-md-12">
												<div class="input-box search-currency-dropdown">
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
									<div class="row dynamic-bank mx-1 mt-3 d-none input-box">
										<label>@lang('Select Bank')</label>
										<select id="dynamic-bank" name="bank"
												class="form-control form-control-sm">
										</select>
										@error('bank')
										<span class="text-danger">{{$message}}</span>
										@enderror
									</div>
									<div class="row dynamic-input mt-4">

									</div>
									<button type="submit" id="submit" class="btn-custom mt-4">@lang('Send Request')</button>
								</form>
							</div>
						</div>
						<div class="col-md-6">
							<div class="sidebar-wrapper p-3">
								<h5 class="">@lang('Details')</h5>
								<ul class="list-unstyled">
									<li class="d-flex justify-content-between align-items-center mb-3">
										<span>@lang('Payout Method')</span>
										<span class="text-info">{{ __($payoutMethod->methodName) }} </span>
									</li>
									<li class="d-flex justify-content-between align-items-center mb-3">
										<span>@lang('Request Amount')</span>
										<span
											class="text-success">{{ (getAmount($payout->amount)) }} {{ config('basic.base_currency') }}</span>
									</li>
									<li class="d-flex justify-content-between align-items-center mb-3">
										<span>@lang('Charge Amount')</span>
										<span
											class="text-danger">{{ (getAmount($payout->charge)) }} {{ config('basic.base_currency') }}</span>
									</li>
									<li class="d-flex justify-content-between align-items-center mb-3">
										<span>@lang('Total Payable')</span>
										<span
											class="text-danger">{{ (getAmount($payout->transfer_amount)) }} {{ config('basic.base_currency') }}</span>
									</li>
									<li class="d-flex justify-content-between align-items-center mb-3">
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

@endsection

@push('extra_scripts')
	<script src="{{ asset('assets/dashboard/js/jquery.uploadPreview.min.js') }}"></script>
@endpush
@section('scripts')
	<script type="text/javascript">
		var bankName = null;
		var payAmount = '{{$payout->amount}}'
		var baseCurrency = "{{config('basic.currency_code')}}"
		var transferName = "{{old('transfer_name')}}";
		if (transferName) {
			getBankForm(transferName);
		}

		$(document).on("change", ".transfer-currency", function () {
			let currencyCode = $(this).val();
			let rate = $(this).find(':selected').data('rate');
			let getAmount = (parseFloat(rate) * parseFloat(payAmount)).toFixed(2);
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

			$(document).on("change", ".bank", function () {
				bankName = $(this).val();
				$('.dynamic-bank').addClass('d-none');
				getBankForm(bankName);
			})
		});

		function getBankForm(bankName) {
			$.ajax({
				url: "{{route('payout.getBankForm')}}",
				type: "post",
				data: {
					bankName,
				},
				success: function (response) {
					if (response.bank != null) {
						showBank(response.bank.data)
					}
					showInputForm(response.input_form)
				}
			});
		}

		function showBank(bankLists) {
			$('#dynamic-bank').html(``);
			var options = `<option disabled selected>@lang("Select Bank")</option>`;
			for (let i = 0; i < bankLists.length; i++) {
				options += `<option value="${bankLists[i].code}">${bankLists[i].name}</option>`;
			}

			$('.dynamic-bank').removeClass('d-none');
			$('#dynamic-bank').html(options);
		}

		function showInputForm(form_fields) {
			$('.dynamic-input').html(``);
			var output = "";

			for (let field in form_fields) {
				let newKey = field.replace('_', ' ');
				output += `<div class="input-box col-md-6 mt-3">
                         <label>${newKey}</label>
				         <input type="text" name="${field}" value="" class="form-control" required>
			          </div>`
			}
			$('.dynamic-input').html(output);
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
