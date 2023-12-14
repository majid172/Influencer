@extends($theme.'layouts.app')
@section('title',__('Payment'))
@section('content')

	<section class="checkout-section">
		<div class="overlay">
			<div class="container">
				<input type="hidden" name="listing_id" value="{{$escrow_id}}">
				<div class="row g-4 g-lg-5">
					<div class="col-lg-8">
						<div class="form-box">
							<h5>@lang('Select Payment Method')</h5>
							<div class="payment-section">
								<ul class="payment-container-list">
									@forelse($methods as $key => $gateway)
										<input type="hidden" name="gateway" value="">

										<li class="item paymentCheck" id="{{$key}}" data-gateway="{{$gateway->id}}">
											<input class="form-check-input methodId" type="radio" name="methodId" value="{{$gateway->id}}" id="{{$gateway}}">

											<label class="form-check-label" for="{{$gateway}}">
												<div class="image-area">
													<img src="{{getFile($gateway->driver,$gateway->image)}}"
														 alt="method_img">
												</div>
												<div class="content-area">
													<h5>{{$gateway->name}}</h5>
												</div>
											</label>
										</li>

									@empty
									@endforelse
								</ul>
							</div>

						</div>
					</div>

					<!-- side bar start -->
					<div class="col-lg-4">
						<div class="side-bar">
							<div class="side-box">
								<div class="transfer-details-section">
									<ul class="transfer-list">
										<li class="item title">
											<h4>@lang('Payment Summery')</h4>
										</li>
										<li class="item">
											<h6>@lang('Total Amount')</h6>
											<h6>
												<span class="total_order_amount amount">

													@if($escrow->escrow_amount != 0)
														{{$escrow->escrow_amount}} @else
														{{$escrow->budget}} @endif
												</span>
												<span>{{ config('basic.base_currency') }}</span>
											</h6>
										</li>
										<li class="item">
											<span>@lang('Percentage Rate')</span>
											<span class="percentage_charge">@lang('0.00 %')</span>
										</li>


										<li class="item">
											<span>@lang('Fixed Charge')</span>
											<span class="fixed_charge">@lang('$0.00')</span>
										</li>
										<hr>
										<li class="item title">
											<h6>@lang('Pay Amount')</h6>
											<h6 class="total_amount">@lang('$0.00')</h6>
										</li>
									</ul>

									<input type="hidden" name="amount" value="" id="amountInput">
									<button type="button" class="btn btn-custom w-100" id="confirmButton" data-bs-toggle="modal" data-bs-target="#staticBackdrop"  data-escrowId="{{$escrow_id}}" >@lang('confirm and continue')</button>
								</div>
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
					<h5 class="modal-title gatewayName" id="staticBackdropLabel"></h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<form action="{{ route('fund.initialize.job',["escrow_id"=>$escrow_id]) }}" method="post">
					@csrf
					<div class="modal-body">
						<input type="hidden" id="escrowId" name="escrow_id">
						<input type="hidden" id="amount" name="amount" value="">
						<input type="hidden" id="methodId" name="methodId" value="">
						<h6>@lang('You need to pay') <span class="totalAmount"></span> @lang('for order')</h6>

					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-custom w-100">@lang('Payment')</button>
					</div>
				</form>

			</div>
		</div>
	</div>
@endsection

@push('script')
	<script>
		'use strict'
		var amount = $('.amount').text();

		$('.paymentCheck').on('click', function () {
			var id = this.id;
			let gatewayId = $(this).data('gateway');
			let amount = $('.amount').text();

			// $("input[name='gateway']").val($(this).data('gateway'));

			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});

			$.ajax({
				url: "{{ route('makePaymentDetails') }}",
				data: {
					gatewayId: gatewayId,
				},
				datatType: 'json',
				type: "POST",
				success: function (data) {
					let conventionRate = parseFloat(data.data.paymentGatewayInfo.convention_rate).toFixed(2);
					let percentageCharge = parseFloat(data.data.paymentGatewayInfo.percentage_charge).toFixed(2);
					// let planPrice = parseFloat(data.data.packageInfo.price).toFixed(2);
					let fixedCharge = parseFloat(data.data.paymentGatewayInfo.fixed_charge).toFixed(2);
					let finalPercentageCharge = (amount * percentageCharge / 100);
					let tempTotalAmount = parseFloat(amount)  + parseFloat(finalPercentageCharge) + parseFloat(fixedCharge);
					let totalAmount = parseFloat(tempTotalAmount) * conventionRate;
					totalAmount = parseFloat(totalAmount).toFixed(2);

					let symbol = "{{trans($basic->currency_symbol)}}";
					$('.percentage_charge').text(`${percentageCharge}%`);
					$('.fixed_charge').text(`${symbol} ${fixedCharge}`);
					$('.total_amount').text(`${symbol} ${totalAmount}`);
					$('#amountInput').val(totalAmount);
				}
			});
		});

		$("#confirmButton").click(function() {
			// Get the value of the selected gateway
			var methodId = $("input[name='methodId']:checked").val();
			let escrowId = $(this).attr('data-escrowId');

			$.ajax({
				url:"{{route('job.gateway')}}",
				type:"GET",
				data:{
					methodId:methodId,

				},
				success:function(response)
				{

					$('.gatewayName').text(response.name);

					let methodId = response.id;
					let conventionRate = parseFloat(response.convention_rate).toFixed(2);
					let percentageCharge = parseFloat(response.percentage_charge).toFixed(2);
					let fixedCharge = parseFloat(response.fixed_charge).toFixed(2);
					let finalPercentageCharge = (amount * percentageCharge / 100);
					let tempTotalAmount = parseFloat(amount)  + parseFloat(finalPercentageCharge) + parseFloat(fixedCharge);
					let totalAmount = parseFloat(tempTotalAmount) * conventionRate;
					totalAmount = parseFloat(totalAmount).toFixed(2);

					let symbol = "{{trans($basic->base_currency)}}";
					$('.totalAmount').text(totalAmount + " " + symbol);
					$('#methodId').val(methodId);
					$('#amount').val(amount);
					$('#escrowId').val(escrowId);

				}
			});

		});


	</script>
@endpush


