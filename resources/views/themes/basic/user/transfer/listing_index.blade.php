@extends($theme.'layouts.user')
@section('page_title',__('Sent/Received Money List'))

@section('content')
	<div class="col-xl-9 col-lg-8 col-md-">

		<div class="row mb-3">
			<div class="container-fluid" id="container-wrapper">
				
				<div class="row">
					<div class="col-lg-12">
						<div class=" mb-4 ">
							<div class=" py-3 d-flex flex-row align-items-center justify-content-between">
								<h6 class="m-0 font-weight-bold text-primary">@lang('Transactions List')</h6>
							</div>

							<div class="table-responsive">
								<table class="table table-striped table-hover align-items-center table-borderless">
									<thead class="thead-light">
									<tr>
										<th>@lang('SL')</th>
										<th>@lang('Sender')</th>
										<th>@lang('Receiver')</th>
										<th>@lang('Receiver E-Mail')</th>
										<th>@lang('Transaction ID')</th>
										<th>@lang('Amount')</th>
										<th>@lang('Type')</th>
										<th>@lang('Status')</th>
										<th>@lang('Created time')</th>

									</tr>
									</thead>
									<tbody>
									@forelse($transfers as $key => $value)
										<tr>
											<td data-label="@lang('SL')">{{ loopIndex($transfers)  + $key}}</td>
											<td data-label="@lang('Sender')">{{ __(optional($value->sender)->name) ?? __('N/A') }}</td>
											<td data-label="@lang('Receiver')">{{ __(optional($value->receiver)->name) ?? __('N/A') }}</td>
											<td data-label="@lang('Receiver E-Mail')">{{ __($value->email) }}</td>
											<td data-label="@lang('Transaction ID')">{{ __($value->utr) }}</td>
											<td data-label="@lang('Amount')">{{ getAmount($value->amount).' '.__(optional($value->currency)->code)}} </td>
											<td data-label="@lang('Type')">
												@if($value->sender_id == Auth::id())
													<span class="badge badge-info">@lang('Sent')</span>
												@else
													<span class="badge badge-success">@lang('Received')</span>
												@endif
											</td>
											<td data-label="@lang('Status')">
												@if($value->status)
													<span class="badge badge-success">@lang('Success')</span>
												@else
													<span class="badge badge-warning">@lang('Pending')</span>
												@endif
											</td>
											<td data-label="@lang('Created time')"> {{ dateTime($value->created_at)}} </td>
									
										</tr>
									@empty
										<tr>
											<th colspan="100%" class="text-center">@lang('No data found')</th>
										</tr>
									@endforelse
									</tbody>
								</table>
							</div>
							<div class="">
								{{ $transfers->links() }}
							</div>

						</div>
					</div>
				</div>
			</div>
		</div>

	</div>
@endsection
