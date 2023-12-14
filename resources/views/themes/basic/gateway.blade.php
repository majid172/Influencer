@extends($theme.'layouts.app')
@section('title',__('Payment Gateway'))
@section('content')
	<section class="checkout-section">
		<div class="overlay">
			<div class="container">
				<div class="row g-4 g-lg-5">
					<div class="col-lg-8">
						<div class="form-box">
							<div>
								<h4>@lang('Payment Method')</h4>
								<form action="">
									<div class="row g-3">
										<div class="input-box col-md-12">
											<div class="payment-box">
												<div class="payment-options">
													<div class="row g-2">
														@foreach($gateways as $key=>$gateway)
															<div class="col-3 col-md-2 col-lg-1">
																<input type="radio" class="btn-check gatewayId" name="gatewayId" id="{{$key}}" value="{{$gateway->id}}" {{ old('gatewayId') == $gateway->id || $key == 0 ? ' checked' : ''}} autocomplete="off" data-name="{{__($gateway->name)}}"/>

																<label class="btn btn-primary" for="{{$key}}">
																	<img class="img-fluid" src="{{ getFile($gateway->driver, $gateway->image ) }}" alt="gateway_img" />
																	<i class="fa-regular fa-check"></i>
																</label>
															</div>
														@endforeach

													</div>
												</div>
											</div>
										</div>

									</div>
								</form>
							</div>
						</div>
					</div>
					<!-- side bar start -->
					<div class="col-lg-4">
						<div class="side-bar">
							<div class="side-box">
								<div class="item-box">
									<a href="#" class="title">{{__(@$escrow->hire->job->title)}}</a>
								</div>
								<ul class="list-unstyled">
									<li>
										<span>@lang('Delivery Date')</span>
										<span>{{__($escrow->hire->submit_date)}}</span>
									</li>

									<li>
										<span>@lang('Payment Method')</span>
										<span class="method_name">

										</span>
									</li>

								</ul>

								<div>
									<ul class="list-unstyled">
										<li>
											<span>@lang('Amount')</span>
											<span>
											{{$amount}} {{basicControl()->base_currency}}
										</span>
										</li>

										<li>
                                    <span>
                                       @lang('Service fee')
                                       <button type="button" data-bs-toggle="tooltip" data-bs-placement="top" title="Give details, but don’t include your personal contact info.">
                                          <i class="fad fa-info-circle"></i>
                                       </button>
                                    </span>
											<span>{{$service_fee->percentage}} % = {{$charge}} {{basicControl()->base_currency}}</span>
										</li>
										<li>
											<b>@lang('Receive amount')</b> <span><b class="receive_amount">{{$total}}</b>{{basicControl()->base_currency}}</span>
										</li>

									</ul>
								</div>
	
								<button type="button" class="btn-custom w-100 pay" data-bs-toggle="modal" data-amount="{{$total}}" data-bs-target="#staticBackdrop" data-gateway-id="" data-gateway-name="">
									@lang('Confirm & Pay')
								</button>

							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>


	<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h1 class="modal-title fs-5" id="staticBackdropLabel">@lang('Payment by') <span class="method_name"></span></h1>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<form action="{{route('deposit.checkAmount')}}" method="post">
					@csrf
					<div class="modal-body">
						<input type="hidden" name="sender_id" value="{{auth()->user()->id}}">
						<input type="hidden" name="receiver_id" value="">
						<input type="hidden" name="currency_code" value="">
						<input type="hidden" name="gateway_id">
						<input type="text" class="form-control" name="amount" value="" readonly>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">@lang('Close')</button>
						<button type="submit" class="btn btn-primary">@lang('Pay')</button>
					</div>
				</form>
			</div>
		</div>
	</div>
@endsection
@push('script')
	<script>
	
			'use strict'
		$(document).ready(function () {
			$('[data-toggle="tooltip"]').tooltip()
			let amountField = $('.receive_amount');

			let amountStatus = false;

			function clearMessage(fieldId) {
				$(fieldId).removeClass('is-valid')
				$(fieldId).removeClass('is-invalid')
				$(fieldId).closest('div').find(".invalid-feedback").html('');
				$(fieldId).closest('div').find(".is-valid").html('');
			}

			$(document).on('change, input', ".receive_amount, #charge_from, .methodId", function (e) {

				let amount = $('.receive_amount').text();
				let currency_code = "{{config('basic.base_currency')}}";
				let methodId = $("input[type='radio'][name='methodId']:checked").val();
				let modal = $('#staticBackdrop');
				modal.find("input[name='amount']").val(pay_amount);
				if (!isNaN(amount) && amount > 0) {
					let fraction = amount.split('.')[1];
					let limit = "{{config('basic.fraction_number')}}";
					if (fraction && fraction.length > limit) {
						amount = (Math.floor(amount * Math.pow(10, limit)) / Math.pow(10, limit)).toFixed(limit);
						amountField.val(amount);
					}
					checkAmount(amount, methodId, currency_code)
				} else {
					clearMessage(amountField)
					$('.showCharge').html('')
				}
		});

		function checkAmount(amount, methodId, currency_code) {
			$.ajax({
				method: "GET",
				url: "{{ route('deposit.checkAmount') }}",
				dataType: "json",
				data: {
					'amount': amount,
					'methodId': methodId,
				}
			})
				.done(function (response) {
					let amountField = $('#amount');
					if (response.status) {
						clearMessage(amountField);
						$(amountField).addClass('is-valid');
						$(amountField).closest('div').find(".valid-feedback").html(response.message);
						amountStatus = true;
						submitButton();
						showCharge(response, currency_code);
					} else {
						amountStatus = false;
						submitButton();
						$('.showCharge').html('');
						clearMessage(amountField);
						$(amountField).addClass('is-invalid');
						$(amountField).closest('div').find(".invalid-feedback").html(response.message);
					}
				});
		}

		function submitButton() {
			if (amountStatus) {
				$("#submit").removeAttr("disabled");
			} else {
				$("#submit").attr("disabled", true);
			}
		}

		function showCharge(response, currency_code) {
			let txnDetails = `
				<ul class="list-group">
					<li class="list-group-item d-flex justify-content-between">
						<span>{{ __('Available Balance') }}</span>
						<span class="text-success"> ${response.balance} ${currency_code}</span>
					</li>
					<li class="list-group-item d-flex justify-content-between">
						<span>{{ __('Transfer Charge') }}</span>
						<span class="text-danger"> ${response.percentage_charge} + ${response.fixed_charge} = ${response.charge} ${currency_code}</span>
					</li>
					<li class="list-group-item d-flex justify-content-between">
						<span>{{ __('Payable Amount') }}</span>
						<span class="text-info"> ${response.payable_amount} ${currency_code}</span>
					</li>
					<li class="list-group-item d-flex justify-content-between">
						<span>{{ __('Received') }}</span>
						<span class="text-info"> ${response.amount} ${currency_code}</span>
					</li>
					<li class="list-group-item d-flex justify-content-between">
						<span>{{ __('New Balance') }}</span>
						<span class="text-primary"> ${response.new_balance} ${currency_code}</span>
					</li>
					<li class="list-group-item d-flex justify-content-between">
						<span>{{ __('Min Deposit Limit') }}</span>
						<span>${parseFloat(response.min_limit).toFixed(response.currency_limit)} ${currency_code}</span>
					</li>
					<li class="list-group-item d-flex justify-content-between">
						<span>{{ __('Max Deposit Limit') }}</span>
						<span>${parseFloat(response.max_limit).toFixed(response.currency_limit)} ${currency_code}</span>
					</li>
				</ul>
				`;
			$('.showCharge').html(txnDetails)
		}
	});
</script>
@endpush
