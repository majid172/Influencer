@extends($theme.'layouts.user')
@section('title')
	{{ 'Pay with '.optional($deposit->gateway)->name ?? '' }}
@endsection
@section('content')

	<script src="https://js.stripe.com/v3/"></script>
	<style>
		.StripeElement {
			box-sizing: border-box;
			height: 40px;
			padding: 10px 12px;
			border: 1px solid transparent;
			border-radius: 4px;
			background-color: white;
			box-shadow: 0 1px 3px 0 #e6ebf1;
			-webkit-transition: box-shadow 150ms ease;
			transition: box-shadow 150ms ease;
		}

		.StripeElement--focus {
			box-shadow: 0 1px 3px 0 #cfd7df;
		}

		.StripeElement--invalid {
			border-color: #fa755a;
		}

		.StripeElement--webkit-autofill {
			background-color: #fefde5 !important;
		}
	</style>

	<div class="col-xl-9 col-lg-8 col-md-12">
		<div class="row justify-content-center">
			<div class="col-lg-6">
				<div class="card-box">
					<div class="row g-4">
						<div class="col-md-3">
							<img src="{{getFile(@$deposit->gateway->driver,@$deposit->gateway->image)}}"
								 class="card-img-top gateway-img">
						</div>
						<div class="col-md-9">
							<h5 class="mb-3">@lang('Please Pay') {{getAmount($deposit->payable_amount)}} {{$deposit->payment_method_currency}}</h5>
							<button type="button"
									class="btn btn-success mt-3"
									id="payment-button">@lang('Pay with Khalti')
							</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('scripts')
	<script
		src="https://khalti.s3.ap-south-1.amazonaws.com/KPG/dist/2020.12.17.0.0.0/khalti-checkout.iffe.js"></script>
	<script>

		$(document).ready(function () {
			$('body').addClass('antialiased')
		});

		var config = {
			// replace the publicKey with yours
			"publicKey": "{{$data->publicKey}}",
			"productIdentity": "{{$data->productIdentity}}",
			"productName": "Payment",
			"productUrl": "{{url('/')}}",
			"paymentPreference": [
				"KHALTI",
				"EBANKING",
				"MOBILE_BANKING",
				"CONNECT_IPS",
				"SCT",
			],
			"eventHandler": {
				onSuccess(payload) {
					// hit merchant api for initiating verfication
					$.ajax({
						type: 'POST',
						url: "{{ route('khalti.verifyPayment',[$deposit->utr]) }}",
						data: {
							token: payload.token,
							amount: payload.amount,
							"_token": "{{ csrf_token() }}"
						},
						success: function (res) {
							$.ajax({
								type: "POST",
								url: "{{ route('khalti.storePayment') }}",
								data: {
									response: res,
									"_token": "{{ csrf_token() }}"
								},
								success: function (res) {
									window.location.href = "{{route('success')}}"
								}
							});
						}
					});
				},
				onError(error) {
				},
				onClose() {
				}
			}
		};
		var checkout = new KhaltiCheckout(config);
		var btn = document.getElementById("payment-button");
		btn.onclick = function () {
			// minimum transaction amount must be 10, i.e 1000 in paisa.
			checkout.show({amount: "{{$data->amount *100}}"});
		}
	</script>
@endsection
