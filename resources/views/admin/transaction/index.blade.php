@extends('admin.layouts.master')
@section('page_title',__('Transactions'))

@section('content')
<div class="main-content">
	<section class="section">
		<div class="section-header">
			<h1>@lang('Transactions')</h1>
			<div class="section-header-breadcrumb">
				<div class="breadcrumb-item active">
					<a href="{{ route('admin.home') }}">@lang('Dashboard')</a>
				</div>
				<div class="breadcrumb-item">@lang('Transactions')</div>
			</div>
		</div>

		<div class="row mb-3">
			<div class="container-fluid" id="container-wrapper">
				<div class="row">
					<div class="col-lg-12">
						<div class="card mb-4 card-primary shadow-sm">
							<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
								<h6 class="m-0 font-weight-bold text-primary">@lang('Search')</h6>
							</div>
							<div class="card-body">
								<form action="{{ route('admin.transaction.search') }}" method="get">
									@include('admin.transaction.searchForm')
								</form>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<div class="card mb-4 card-primary shadow">
							<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
								<h6 class="m-0 font-weight-bold text-primary">@lang('Transactions')</h6>
							</div>
							<div class="card-body">
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
											<th>@lang('Transaction At')</th>
										</tr>
										</thead>
										<tbody>
										@forelse($transactions as $key => $value)
											<tr>
												<td data-label="@lang('SL')">
													{{loopIndex($transactions) + $key}}
												</td>
												<td data-label="@lang('Sender')">

													{{ __(optional(optional($value->transactional)->sender)->name ?? __('N/A')) }}
												</td>
												<td data-label="@lang('Receiver')">
													
													{{ __(optional(optional($value->transactional)->receiver)->name ?? __('N/A')) }}
												</td>
												<td data-label="@lang('Receiver E-Mail')">{{ __($value->transactional->email) }}</td>
												<td data-label="@lang('Transaction ID')">{{ __($value->transactional->utr) }}</td>
												<td data-label="@lang('Amount')" class="text-success">{{ (getAmount(optional($value->transactional)->amount)).' '.config('basic.base_currency') }}</td>
												<td data-label="@lang('Type')">
													{{ __(str_replace('App\Models\\', '', $value->transactional_type)) }}
												</td>
												<td data-label="@lang('Status')">
													@if($value->transactional->status)
														<span class="badge badge-success">@lang('Success')</span>
													@else
														<span class="badge badge-warning">@lang('Pending')</span>
													@endif
												</td>
												<td data-label="@lang('Transaction At')"> {{ dateTime($value->created_at)}} </td>
											</tr>
										@empty
											<tr>
												<th colspan="100%" class="text-center">@lang('No data found')</th>
											</tr>
										@endforelse
										</tbody>
									</table>
								</div>
								<div class="card-footer">
									{{ $transactions->links() }}
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

	</section>
</div>
@endsection
