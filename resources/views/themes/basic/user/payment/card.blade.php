@extends($theme.'layouts.user')
@section('title')
	{{ 'Pay with '.optional($deposit->gateway)->name ?? '' }}
@endsection
@push('extra_styles')
	<link href="{{ asset('assets/dashboard/css/card-js.min.css') }}" rel="stylesheet" type="text/css"/>
@endpush
@section('content')
	<div class="col-xl-9 col-lg-8 col-md-12">
		<div class="row justify-content-center">
			<div class="col-lg-6">
				<div class="card-box">
					<div class="form-box">
						<form class="form-horizontal" id="example-form" action="{{ route('ipn', [optional($deposit->gateway)->code ?? '', $deposit->utr]) }}" method="post">
							<fieldset>
								<h5>@lang('Your Card Information')</h5>
								<div class="card-js input-box">
									<input class="card-number form-control" name="card_number" placeholder="@lang('Enter your card number')" autocomplete="off" required>
									<input class="name form-control" id="the-card-name-id" name="card_name" placeholder="@lang('Enter the name on your card')" autocomplete="off" required>
									<input class="expiry form-control" autocomplete="off" required>
									<input class="expiry-month form-control" name="expiry_month">
									<input class="expiry-year form-control" name="expiry_year">
									<input class="cvc form-control" name="card_cvc" autocomplete="off" required>
								</div>
								<button type="submit" class="btn btn-primary">@lang('Submit')</button>
							</fieldset>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>


@endsection
@push('extra_scripts')
	<script src="{{ asset('assets/dashboard/js/card-js.min.js') }}"></script>
@endpush
