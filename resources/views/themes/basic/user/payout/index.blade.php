@extends($theme.'layouts.user')
@section('title',__('Payout List'))

@section('content')
	<div class="main col-xl-9 col-lg-8 col-md-12 change-passwordontent">
		<section class="section">

			<div class="row mb-3">
				<div class="container-fluid" id="container-wrapper">
					<div class="row">
						<div class="col-lg-12">
							<div class="card-box mb-3">
								<div class="search-box">
									<h6>@lang('Search')</h6>
									<form action="{{ route('payout.search') }}" method="get">
										@include($theme.'user.payout.searchForm')
									</form>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-12">
							<div class="table-responsive">
								<table class="table table-striped table-hover align-items-center table-borderless">
									<thead class="thead-light">
									<tr>
										<th>@lang('SL')</th>
										<th>@lang('Amount')</th>
										<th>@lang('Transaction ID')</th>
										<th>@lang('Status')</th>
										<th>@lang('Created time')</th>
										<th>@lang('Action')</th>
									</tr>
									</thead>
									<tbody>
									@forelse($payouts as $key => $value)
										<tr>
											<td data-label="@lang('SL')">{{loopIndex($payouts) + $key}}</td>
											<td data-label="@lang('Amount')">{{ (getAmount($value->amount)).' '.__(config('basic.base_currency')) }}</td>
											<td data-label="@lang('Transaction ID')">{{ __($value->utr) }}</td>
											<td data-label="@lang('Status')">
												@if($value->status == 0)
													<span class="badge bg-warning">@lang('Pending')</span>
												@elseif($value->status == 1)
													<span class="badge bg-info">@lang('Generated')</span>
												@elseif($value->status == 2)
													<span class="badge bg-success">@lang('Payment Done')</span>
												@elseif($value->status == 5)
													<span class="badge bg-danger">@lang('Canceled')</span>
												@endif
											</td>
											<td data-label="@lang('Created time')"> {{ dateTime($value->created_at)}} </td>
											<td data-label="@lang('Action')">
												@if($value->status == 0)
													<a href="{{ route('payout.confirm',$value->utr) }}" target="_blank"
													   class="btn-action btn-sm btn-primary">@lang('Confirm')</a>
												@endif
											</td>
										</tr>
									@empty
										<tr>
											<th colspan="100%" class="text-center">@lang('No data found')</th>
										</tr>
									@endforelse
									</tbody>
								</table>
							</div>
							{{ $payouts->links() }}
						</div>
					</div>
				</div>
			</div>

		</section>
	</div>

@endsection


