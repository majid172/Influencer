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
							<button type="button" class="btn btn-primary"
									id="btn-confirm">@lang('Pay Now')</button>
							<form
								action="{{ route('ipn', [optional($deposit->gateway)->code, $deposit->utr]) }}"
								method="POST">
								@csrf
								<script src="//js.paystack.co/v1/inline.js"
										data-key="{{ $data->key }}"
										data-email="{{ $data->email }}"
										data-amount="{{$data->amount}}"
										data-currency="{{$data->currency}}"
										data-ref="{{ $data->ref }}"
										data-custom-button="btn-confirm">
								</script>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

@endsection

