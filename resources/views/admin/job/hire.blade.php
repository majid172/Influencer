@extends('admin.layouts.master')
@section('page_title',__('Job Hiring Lists'))
@section('content')

	<div class="main-content">
		<section class="section">
			<div class="section-header">
				<h1>@lang('Hiring List')</h1>
				<div class="section-header-breadcrumb">
					<div class="breadcrumb-item active">
						<a href="{{route('admin.home')}}">@lang('Dashboard')</a>
					</div>
					<div class="breadcrumb-item">@lang('Hiring List')</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<div class="card mb-4 card-primary shadow-sm">
						<div
							class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
							<h6 class="m-0 font-weight-bold text-primary">@lang('Search')</h6>
						</div>
						<div class="card-body">
							<form action="{{route('admin.jobs.hire.search')}}" method="get">
								@include('admin.job.hireSearchForm')
							</form>
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-12">
					<div class="card card-primary shadow">
						<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
							<h6 class="m-0 font-weight-bold text-primary">@lang('Hiring List')</h6>

						</div>

						<div class="card-body">
							<div class="table-responsive">
								<table class="table table-striped table-hover align-items-center ">
									<thead>
									<tr>
										<th>@lang('SL')</th>
										<th>@lang('Title')</th>
										<th>@lang('Client name')</th>
										<th>@lang('Proposer name')</th>
										<th>@lang('Amount')</th>
										<th>@lang('Payment Type')</th>
										<th>@lang('Type')</th>
										<th>@lang('Submit Date')</th>
										<th>@lang('Status')</th>
										<th>@lang('Action')</th>
									</tr>
									</thead>
									<tbody>
									@forelse($hires as $key => $list)
										<tr>

										<td data-label="SL">
												{{ ++$key}}
											</td>
											<td data-label="Title"> {{Str::limit(optional($list->job)->title,30)}} </td>
											<td data-label="Client">
												<a href="{{ route('user.edit', $list->client_id)}}"
												   class="text-decoration-none">
													<div class="d-lg-flex d-block align-items-center ">
														<div class="rounded-circle mr-2 w-40px" >
															{!! optional($list->client)->profilePicture() !!}
														</div>
														<div class="d-inline-flex d-lg-block align-items-center">
															<p class="text-dark mb-0 font-16 font-weight-medium">{{Str::limit(optional($list->client)->name?? __('N/A'),20)}}</p>
															<span
																class="text-muted font-14 ml-1">{{ '@'.optional($list->client)->username?? __('N/A')}}</span>
														</div>
													</div>
												</a>
											</td>
											<td data-label="Proposer">
												<a href="{{ route('user.edit', $list->proposser_id)}}"
												   class="text-decoration-none">
													<div class="d-lg-flex d-block align-items-center ">
														<div class="rounded-circle mr-2 w-40px" >
															{!! optional($list->proposser)->profilePicture() !!}
														</div>
														<div class="d-inline-flex d-lg-block align-items-center">
															<p class="text-dark mb-0 font-16 font-weight-medium">{{Str::limit(optional($list->proposser)->name?? __('N/A'),20)}}</p>
															<span
																class="text-muted font-14 ml-1">{{ '@'.optional($list->proposser)->username?? __('N/A')}}</span>
														</div>
													</div>
												</a>

											</td>

											<td data-label="Amount" class="text-{{ $list->is_hired == 1 ? 'success' : 'danger' }}"> {{$basic->currency_symbol}}{{getAmount($list->rate)}} </td>
											<td data-label="Payment Type">
												@if($list->pay_type == 1)
													<span>@lang('Hourly')</span>
												@else
													<span>@lang('Fixed')</span>
												@endif

											</td>
											<td data-label="Type">
												@if($list->deposit_type == 1)
													<span>@lang('Project Wise')</span>
												@else
													<span>@lang('Milestone')</span>
												@endif

											</td>
											<td data-label="Submit Date"> {{dateTime($list->submit_date,'d M, Y ')}} </td>
											<td data-label="Status">
												@if($list->is_hired == 1)
													<span class="badge badge-success">@lang('Hired')</span>
												@else
													<span class="badge badge-danger">@lang('Dismissed')</span>
												@endif
											</td>

											<td data-label="Action">
												<a href="{{route('admin.jobs.escrow',['hire_id' => $list->id])}}"  class="btn btn-sm btn-outline-primary approve">
													<i class="fas fa-handshake pr-1"></i>@lang('Escrow')
												</a>

											</td>
										</tr>
									@empty
										<tr>
											<th colspan="100%" class="text-center">
												<img src="{{asset('assets/global/no-data.png')}}" alt="@lang('no-data')" class="no-data-img">
												<br>
												@lang('No data found')</th>
										</tr>

									@endforelse
									</tbody>
								</table>
							</div>

							<div class="card-footer">
								{{ $hires->links() }}
							</div>
						</div>

					</div>
				</div>
			</div>

		</section>
	</div>

@endsection



