@extends($theme.'layouts.user')
@section('title')
	{{ 'Pay with '.optional($deposit->gateway)->name ?? '' }}
@endsection
@section('section')
	<div class="col-xl-9 col-lg-8 col-md-12">
		<div class="row justify-content-center">
			<div class="col-lg-6">
				<div class="card-box">
					<form
						action="{{ route('ipn', [optional($deposit->gateway)->code ?? 'mercadopago', $deposit->utr]) }}"
						method="POST">
						<script src="https://www.mercadopago.com.co/integrations/v1/web-payment-checkout.js"
								data-preference-id="{{ $data->preference }}">
						</script>
					</form>
				</div>
			</div>
		</div>
	</div>
@endsection
