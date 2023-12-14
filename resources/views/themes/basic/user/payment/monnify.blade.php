@extends($theme.'layouts.user')
@section('title')
	{{ 'Pay with '.optional($deposit->gateway)->name ?? '' }}
@endsection

@section('content')

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
						<button class="btn btn-primary" onclick="payWithMonnify()">@lang('Pay Now')</button>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
@section('scripts')
	<script type="text/javascript" src="//sdk.monnify.com/plugin/monnify.js"></script>
	<script type="text/javascript">
		'use strict';
            function payWithMonnify() {
                MonnifySDK.initialize({
                    amount: {{ $data->amount }},
                    currency: "{{ $data->currency }}",
                    reference: "{{ $data->ref }}",
                    customerName: "{{$data->customer_name }}",
                    customerEmail: "{{$data->customer_email }}",
                    customerMobileNumber: "{{ $data->customer_phone }}",
                    apiKey: "{{ $data->api_key }}",
                    contractCode: "{{ $data->contract_code }}",
                    paymentDescription: "{{ $data->description }}",
                    isTestMode: true,
                    onComplete: function (response) {
                        if (response.paymentReference) {
                            window.location.href = '{{ route('ipn', ['monnify', $data->ref]) }}';
                        } else {
                            window.location.href = '{{ route('failed') }}';
                        }
                    },
                    onClose: function (data) {
                    }
                });
            }
	</script>
@endsection
