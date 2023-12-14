@extends($theme.'layouts.user')
@section('page_title',__('Confirm Listing Transfer'))

@section('content')
	<div class="col-xl-9 col-lg-8 col-md-12">
		<div class="row mb-3">
			<div class="container-fluid" id="container-wrapper">
				<div class="row justify-content-md-center">
					<div class="col-lg-12">
						<div class="card mb-4 shadow card-primary">
							<div class="card-header py-3 d-flex flex-row align-items-center justify-content-center">
								<h6 class="m-0 font-weight-bold text-primary">@lang('Confirm Listing Transfer')</h6>
							</div>
							<div class="card-body">

								<form action="{{ route('transfer.confirm.listing',$utr) }}" method="post">
									@csrf
									<ul class="list-group">
										<li class="list-group-item list-group-item-action d-flex justify-content-between">
											<span>@lang('Receiver name')</span>
											<span> {{__($transfer->receiver->name)}} </span>
										</li>

										<li class="list-group-item list-group-item-action d-flex justify-content-between">
											<span>@lang('Percentage charge') ({{ (getAmount($transfer->percentage)) }}@lang('%'))</span>
											<span>{{ (getAmount($transfer->charge_percentage)) }}</span>
										</li>

										<li class="list-group-item list-group-item-action d-flex justify-content-between">
											<span>@lang('Total charge')</span>
											<span>{{ (getAmount($transfer->charge)) }}</span>
										</li>
										<li class="list-group-item list-group-item-action d-flex justify-content-between">
											<span>@lang('Payable amount')</span>
											<span>{{ (getAmount($transfer->transfer_amount)) }}</span>
										</li>
										<li class="list-group-item list-group-item-action d-flex justify-content-between">
											<span>@lang('Receiver will received')</span>
											<span>{{ (getAmount($transfer->received_amount)) }}</span>
										</li>

										<li class="list-group-item list-group-item-action d-flex justify-content-between">
											<span>@lang('Note')</span>
											<span> {{ __($transfer->note) }} </span>
										</li>
									</ul>

									<button type="submit" id="submit" class="btn btn-primary btn-sm btn-block btn-security mt-3">@lang('Confirm')</button>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

	</div>
@endsection
