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
							<img src="{{getFile(@$deposit->gateway->driver,@$deposit->gateway->image)}}"
								 class="card-img-top gateway-img">
						</div>
						<div class="col-md-9">
							<h5 class="mb-3">@lang('Please Pay') {{getAmount($deposit->payable_amount)}} {{$deposit->payment_method_currency}}</h5>
							<button type="button" class="btn btn-primary" id="btn-confirm"
									onClick="payWithRave()">@lang('Pay Now')</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
@section('scripts')
	<script src="https://api.ravepay.co/flwv3-pug/getpaidx/api/flwpbf-inline.js"></script>
	<script>
		'use strict';
            let btn = document.querySelector("#btn-confirm");
            btn.setAttribute("type", "button");
            const API_publicKey = "{{$data->API_publicKey }}";

            function payWithRave() {
                let x = getpaidSetup({
                    PBFPubKey: API_publicKey,
                    customer_email: "{{ $data->customer_email }}",
                    amount: "{{ $data->amount }}",
                    customer_phone: "{{ $data->customer_phone }}",
                    currency: "{{ $data->currency }}",
                    txref: "{{ $data->txref }}",
                    onclose: function () {
                    },
                    callback: function (response) {
                        let txref = response.tx.txRef;
                        let status = response.tx.status;
                        window.location = '{{ url('payment/flutterwave') }}/' + txref + '/' + status;
                    }
                });
            }
	</script>
@endsection
