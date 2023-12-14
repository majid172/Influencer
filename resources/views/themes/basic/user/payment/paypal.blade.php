@extends($theme.'layouts.user')
@section('title')
	{{ 'Pay with '.optional($deposit->gateway)->name ?? '' }}
@endsection
@section('content')
	<div class="col-xl-9 col-lg-8 col-md-12">
		<div class="row justify-content-center">
			<div class="col-lg-6">
				<div class="card-box">
					<div class="row g-4">
						<div class="col-md-3">
							<img
								src="{{getFile(@$deposit->gateway->driver,@$deposit->gateway->image)}}"
								class="card-img-top gateway-img">
						</div>
						<div class="col-md-9">
							<h5 class="mb-3">@lang('Please Pay') {{getAmount($deposit->payable_amount)}} {{$deposit->payment_method_currency}}</h5>
							<div id="paypal-button-container"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
@section('scripts')
	<script src="https://www.paypal.com/sdk/js?client-id={{ $data->cleint_id }}&currency={{$data->currency}}"></script>
	<script>
		paypal.Buttons({
			createOrder: function (data, actions) {
				return actions.order.create({
					purchase_units: [
						{
							description: "{{ $data->description }}",
							custom_id: "{{ $data->custom_id }}",
							amount: {
								currency_code: "{{ $data->currency }}",
								value: "{{ $data->amount }}",
								breakdown: {
									item_total: {
										currency_code: "{{ $data->currency }}",
										value: "{{ $data->amount }}"
									}
								}
							}
						}
					]
				});
			},
			onApprove: function (data, actions) {
				return actions.order.capture().then(function (details) {
					var trx = "{{ $data->custom_id }}";
					window.location = '{{ url('payment/paypal') }}/' + trx + '/' + details.id
				});
			}
		}).render('#paypal-button-container');
	</script>
@endsection
