@extends($theme.'layouts.user')
@section('title',trans('Payout Confirm'))
@section('content')
	<div class="main col-xl-9 col-lg-8 col-md-12 change-passwordontent">
		<div class=" row">
			<div class="col-12">
				<div class="row mb-3">
					<section class="profile-setting">
						<div class="row justify-content-md-center">
							<div class="col-md-6 mb-3">
								<div class="sidebar-wrapper p-3">
									<form action="{{ route('payout.confirm',$payout->utr) }}" method="post"
										  enctype="multipart/form-data">
										@csrf
										@if($payoutMethod->supported_currency)
											<div class="row mb-3">
												<div class="col-md-12">
														<div class="input-box search-currency-dropdown">
															<label for="from_wallet">@lang('Select Bank Currency')</label>
															<select id="from_wallet" name="currency_code"
																	class="form-control form-control-sm transfer-currency"
																	required>
																<option value="" disabled=""
																		selected="">@lang('Select Currency')</option>
																@foreach($payoutMethod->supported_currency as $singleCurrency)
																	<option
																		value="{{$singleCurrency}}"
																		@foreach($payoutMethod->convert_rate as $key => $rate)
																			@if($singleCurrency == $key) data-rate="{{$rate}}" @endif
																		@endforeach {{old('transfer_name') == $singleCurrency ?'selected':''}}>{{$singleCurrency}}</option>
																@endforeach
															</select>
															@error('currency_code')
															<span class="text-danger">{{$message}}</span>
															@enderror
														</div>

												</div>
											</div>
										@endif
										@if($payoutMethod->code == 'paypal')
											<div class="row mb-3">
												<div class="col-md-12">
														<div class="input-box search-currency-dropdown">
															<label for="from_wallet">@lang('Select Recipient Type')</label>
															<select id="from_wallet" name="recipient_type"
																	class="form-control form-control-sm" required>
																<option value="" disabled=""
																		selected="">@lang('Select Recipient')</option>
																<option value="EMAIL">@lang('Email')</option>
																<option value="PHONE">@lang('phone')</option>
																<option value="PAYPAL_ID">@lang('Paypal Id')</option>
															</select>
															@error('recipient_type')
															<span class="text-danger">{{$message}}</span>
															@enderror
														</div>
												</div>
											</div>
										@endif
										@if(isset($payoutMethod->inputForm))
											@foreach(json_decode($payoutMethod->inputForm) as $key => $value)
												@if($value->type == 'text')
													<div class="input-box mb-3">
														<label for="{{ $value->name }}">@lang($value->label)</label>
														<input type="text" name="{{ $value->name }}"
															   placeholder="{{ __($value->label) }}"
															   autocomplete="off"
															   value="{{ old($value->name) }}"
															   class="form-control @error($value->name) is-invalid @enderror">
														<div
															class="text-danger">@error($value->name) @lang($message) @enderror</div>
													</div>
												@elseif($value->type == 'textarea')
													<div class="input-box mb-3">
														<label for="{{ $value->name }}">@lang($value->label)</label>
														<textarea
															class="form-control @error($value->name) is-invalid @enderror"
															name="{{$value->name}}"
															rows="5">{{ old($value->name) }}</textarea>
														<div
															class="text-danger">@error($value->name) @lang($message) @enderror</div>
													</div>
												@elseif($value->type == 'file')
													<div class="input-box">
														<div id="image-preview" class="image-preview">
															<label for="image-upload"
																   id="image-label">@lang('Choose File')</label>
															<input type="file" name="{{ $value->name }}"
																   class="@error($value->name) is-invalid @enderror"
																   id="image-upload"/>
														</div>
														<div class="text-danger">
															@error($value->name) @lang($message) @enderror
														</div>
													</div>
												@endif
											@endforeach
										@endif
										<button type="submit" id="submit"
												class="btn-custom mt-4">@lang('Send Request')</button>
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
												class="text-success">{{ (getAmount($payout->amount)) }} {{ __(config('basic.base_currency')) }}</span>
										</li>
										<li class="d-flex justify-content-between align-items-center mb-3">
											<span>@lang('Charge Amount')</span>
											<span
												class="text-danger">{{ (getAmount($payout->charge)) }} {{ __(config('basic.base_currency')) }}</span>
										</li>

										<li class="d-flex justify-content-between align-items-center mb-3">
											<span>@lang('Total Payable')</span>
											<span
												class="text-danger">{{ (getAmount($payout->transfer_amount)) }} {{ __(config('basic.base_currency')) }}</span>
										</li>

										<li class="d-flex justify-content-between align-items-center mb-3">
											<span>@lang('Receive Amount')</span>
											<span class="text-success">{{ (getAmount($payout->amount)) - (getAmount($payout->charge)) }} {{ __(config('basic.base_currency')) }}</span>
										</li>

										<li class="d-flex justify-content-between align-items-center mb-3">
											<span>@lang('Available Balance')</span>
											<span
												class="text-success">{{ (getAmount($user->balance - $payout->transfer_amount)) }} {{ __(config('basic.base_currency')) }}</span>
										</li>
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
		var baseCurrency = "{{config('basic.currency_code')}}"

		$(document).on("change", ".transfer-currency", function () {
			let currencyCode = $(this).val();
			let rate = $(this).find(':selected').data('rate');
			let getAmount = parseFloat(rate) * parseFloat(payAmount);
			var output = null;
			$('.dynamic').html('');
			output = `<li class="d-flex justify-content-between align-items-center">
						<span>@lang('Exchange rate')</span>
							<span class="text-primary">1 ${baseCurrency} = ${rate} ${currencyCode}</span></li>
					  <li class="d-flex justify-content-between align-items-center">
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
		});
	</script>
@endsection
