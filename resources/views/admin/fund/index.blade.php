@extends('admin.layouts.master')
@section('page_title', __('Add Fund List'))

@push('extra_styles')
	<link href="{{ asset('assets/dashboard/css/select2.min.css') }}" rel="stylesheet" type="text/css">
@endpush

@section('content')
<div class="main-content">
	<section class="section">
		<div class="section-header">
			<h1>@lang('Add Fund List')</h1>
			<div class="section-header-breadcrumb">
				<div class="breadcrumb-item active">
					<a href="{{ route('admin.home') }}">@lang('Dashboard')</a>
				</div>
				<div class="breadcrumb-item">@lang('Add Fund List')</div>
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
								@if(isset($userId))
									<form action="{{ route('admin.user.fund.add.search',$userId) }}" method="get">
										@include('admin.fund.searchForm')
									</form>
								@else
									<form action="{{ route('admin.fund.add.search') }}" method="get">
										@include('admin.fund.searchForm')
									</form>
								@endif
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<div class="card mb-4 card-primary shadow">
							<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
								<h6 class="m-0 font-weight-bold text-primary">@lang('Add Fund List')</h6>
							</div>
							<div class="card-body">
								<div class="table-responsive">
									<table class="table table-striped table-hover align-items-center table-borderless">
										<thead class="thead-light">
										<tr>
											<th>@lang('SL')</th>
											<th>@lang('Receiver')</th>
											<th>@lang('Method')</th>
											<th>@lang('Amount')</th>
											<th>@lang('Transaction ID')</th>
											<th>@lang('Status')</th>
											<th>@lang('Transaction At')</th>
										</tr>
										</thead>
										<tbody>
										@forelse($funds as $key => $value)
											<tr>
												<td data-label="@lang('SL')">
													{{loopIndex($funds) + $key}}
												</td>
												<td data-label="@lang('Receiver')">
													<a href="{{ route('user.edit', $value->user_id)}}" class="text-decoration-none">
														<div class="d-lg-flex d-block align-items-center ">
															<div class="d-inline-flex d-lg-block align-items-center">
																<p class="text-dark mb-0 font-16 font-weight-medium">{{Str::limit(optional($value->receiver)->name?? __('N/A'),20)}}</p>
																<span class="text-muted font-14 ml-1">{{ '@'.optional($value->receiver)->username}}</span>
															</div>
														</div>
													</a>
												</td>

												<td data-label="@lang('Method')">{{ __(optional(optional($value->depositable)->gateway)->name ?? __('N/A')) }}</td>
												<td data-label="@lang('Amount')">{{ (getAmount($value->amount)).' '.__(optional($value->currency)->code) }}</td>
												<td data-label="@lang('Transaction ID')">{{ __($value->utr) }}</td>
												<td data-label="@lang('Status')">
													@if($value->status)
														<span class="badge badge-success">@lang('Success')</span>
													@else
														<span class="badge badge-warning">@lang('Pending')</span>
													@endif
												</td>
												<td data-label="@lang('Transaction At')"> {{ dateTime($value->created_at) }} </td>
											</tr>
										@empty
											<tr>
												<th colspan="100%" class="text-center">@lang('No Data Found')</th>
											</tr>
										@endforelse
										</tbody>
									</table>
								</div>
								<div class="card-footer">
									{{ $funds->links() }}
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

@push('extra_scripts')
	<script src="{{ asset('assets/dashboard/js/select2.min.js') }}"></script>
@endpush
