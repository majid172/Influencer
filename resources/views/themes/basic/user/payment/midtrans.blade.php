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

	<div class="col-xl-9">
		<div class="row justify-content-center">
			<div class="col-lg-6">
				<div class="row g-4">
					<div class="col-md-3">
						<img src="{{getFile(@$deposit->gateway->driver,@$deposit->gateway->image)}}"
							 class="card-img-top gateway-img">
					</div>
					<div class="col-md-9">
						<h5 class="mb-3">@lang('Please Pay') {{getAmount($deposit->payable_amount)}} {{$deposit->payment_method_currency}}</h5>
						<button type="button"
								class="btn btn-success mt-3"
								id="pay-button">@lang('Pay Now')
						</button>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('scripts')
	<script type="text/javascript"
			src="https://app.sandbox.midtrans.com/snap/snap.js"
			data-client-key="{{ $data->client_key }}"></script>

	<script defer>
		var payButton = document.getElementById('pay-button');
		payButton.addEventListener('click', function () {
			window.snap.pay("{{ $data->token }}", {
				onSuccess: function (result) {
					let route = '{{ route('ipn', ['midtrans']) }}/';
					window.location.href = route + result.order_id;
				},
				onPending: function (result) {
					let route = '{{ route('ipn', ['midtrans']) }}/';
					window.location.href = route + result.order_id;
				},
				onError: function (result) {
					window.location.href = '{{ route('failed') }}';
				},
				onClose: function () {
					window.location.href = '{{ route('failed') }}';
				}
			});
		});
	</script>

@endsection

@if($deposit->gateway->environment == 'live')
	@section('scripts')
		<script type="text/javascript"
				src="https://app.midtrans.com/snap/snap.js"
				data-client-key="{{ $data->client_key }}"></script>

		<script defer>
			var payButton = document.getElementById('pay-button');
			payButton.addEventListener('click', function () {
				window.snap.pay("{{ $data->token }}");
			});
		</script>
	@endsection
@else
	@section('scripts')
		<script type="text/javascript"
				src="https://app.sandbox.midtrans.com/snap/snap.js"
				data-client-key="{{ $data->client_key }}"></script>

		<script defer>
			var payButton = document.getElementById('pay-button');
			payButton.addEventListener('click', function () {
				window.snap.pay("{{ $data->token }}");
			});
		</script>
	@endsection
@endif
