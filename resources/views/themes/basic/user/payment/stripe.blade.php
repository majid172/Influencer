@extends($theme.'layouts.user')
@section('title')
	{{ 'Pay with '.optional($deposit->gateway)->name ?? '' }}
@endsection
@push('extra_styles')
	<link href="{{ asset('assets/dashboard/css/stripe.css') }}" rel="stylesheet" type="text/css">
@endpush
@section('content')
	<div class="col-xl-9 col-lg-8 col-md-12">
		<div class="row justify-content-center">
			<div class="col-lg-6">
				<div class="card-box">
					<div class="row g-4">
						<div class="col-md-3">
							<img src="{{getFile(@$deposit->gateway->driver,@$deposit->gateway->image)}}"
								 class="card-img-top gateway-img rounded-3">
						</div>
						<div class="col-md-9">
							<h5 class="mb-3">@lang('Please Pay') {{getAmount($deposit->payable_amount)}} {{$deposit->payment_method_currency}}</h5>
							<form action="{{ $data->url }}" method="{{ $data->method }}">
								<script src="{{ $data->src }}" class="stripe-button"
										@foreach($data->val as $key=> $value)
											data-{{$key}}="{{$value}}"
									@endforeach>
								</script>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
@push('extra_scripts')
	<script src="https://js.stripe.com/v3/"></script>
@endpush


