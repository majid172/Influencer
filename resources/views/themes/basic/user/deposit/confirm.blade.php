@extends($theme.'layouts.user')
@section('page_title',__('Preview Add Fund'))

@section('content')
	<div class="main-ccol-xl-9 col-lg-8 col-md-12 change-passwordontent">
		<div class="row">

			<div class="container-fluid" id="container-wrapper">
				<div class="row justify-content-md-center">
					<div class="col-lg-8">
						<div class="card-box">
							<div class=" py-3 d-flex flex-row align-items-center justify-content-center">
								<h6 class="m-0 font-weight-bold text-primary">@lang('Preview Checkout')</h6>
							</div>
							<div class="">
								<form action="{{ route('deposit.confirm',$utr) }}" method="post">
									@csrf
									<div class="text-center">
										<img class="rounded mb-5"
											 src="{{ getFile($deposit->gateway->driver, $deposit->gateway->image ) }}"
											 width="109">
									</div>

									<ul class="list-unstyled">
										<li class="d-flex justify-content-between mb-3">
											<span>@lang('Gateway')</span>
											<span>{{ __(optional($deposit->gateway)->name) }} </span>
										</li>
										<li class="d-flex justify-content-between mb-3">
											<span>@lang('Name')</span>
											<span> {{ __(optional($deposit->receiver)->name) }} </span>
										</li>
										<li class="d-flex justify-content-between mb-3">
											<span>@lang('Currency')</span>
											<span>{{ __($deposit->payment_method_currency) }}</span>
										</li>
										<li class="d-flex justify-content-between mb-3">
											<span>@lang('Amount')</span>
											<span>{{ (getAmount($deposit->amount)) }} {{basicControl()->base_currency}}</span>
										</li>
										<li class="d-flex justify-content-between mb-3">
											<span>@lang('Charge')</span>
											<span>{{ (getAmount($deposit->charge)) }} {{basicControl()->base_currency}}</span>
										</li>
										<li class="d-flex justify-content-between mb-3">
											<span>@lang('Payable amount')</span>
											<span>{{ (getAmount($deposit->amount + $deposit->charge)) }} {{basicControl()->base_currency}}</span>
										</li>
									</ul>
									<button type="submit" id="submit"
											class="btn btn-primary btn-sm btn-block btn-security mt-2">@lang('Confirm')</button>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

	</div>
@endsection
