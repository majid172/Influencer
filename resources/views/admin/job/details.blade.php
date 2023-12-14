@extends('admin.layouts.master')
@section('page_title',__('Job Details'))
@section('content')
	<div class="main-content">
		<section class="section">
			<div class="section-header">
				<h1>@lang('Job Proposal List')</h1>
				<div class="section-header-breadcrumb">
					<div class="breadcrumb-item active">
						<a href="{{route('admin.home')}}">@lang('Dashboard')</a>
					</div>
					<div class="breadcrumb-item">@lang('Job Proposal List')</div>
				</div>
			</div>

			<div class="row">
				<div class="col-12">
					<div class="card card-primary shadow">
						<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
							<h6 class="m-0 font-weight-bold text-primary">@lang('Job Proposal List')</h6>

						</div>

						<div class="card-body">
							<div class="table-responsive">
								<table class="table table-striped table-hover align-items-center ">
									<thead>
									<tr>
										<th>@lang('SL')</th>
										<th>@lang('Proposer')</th>
										<th>@lang('Bid Amount')</th>
										<th>@lang('Receive Amount')</th>

									</tr>
									</thead>
									<tbody>
									@forelse($details as $key => $item)
										<tr>
											<td data-label="SL">
												{{loopIndex($details)+$key }}
											</td>
											<td data-label="PROPOSER">
												<a href="{{ route('user.edit', $item->proposer_id)}}"
												   class="text-decoration-none">
													<div class="d-lg-flex d-block align-items-center ">
														<div class="rounded-circle mr-2 w-40px" >
															{!! optional($item->proposer)->profilePicture() !!}
														</div>
														<div class="d-inline-flex d-lg-block align-items-center">
															<p class="text-dark mb-0 font-16 font-weight-medium">{{Str::limit(optional($item->proposer)->name?? __('N/A'),20)}}</p>
															<span class="text-muted font-14 ml-1">{{ '@'.optional($item->proposer)->username?? __('N/A')}}</span>
														</div>
													</div>
												</a>

											<td data-label="BID AMOUNT" class="text-primary">{{$basic->currency_symbol}}{{$item->bid_amount}}</td>
											<td data-label="RECEIVE AMOUNT" class="text-success">{{$basic->currency_symbol}}{{$item->receive_amount}}</td>
										</tr>
									@empty
										<tr>
											<th colspan="100%" class="text-center">
												<img src="{{asset('assets/global/no-data.png')}}" alt="@lang('no-data')" class="no-data-img">
												<br>
												@lang('No Data Found')
											</th>
										</tr>
									@endforelse
									</tbody>
								</table>
							</div>

							<div class="card-footer">
								{{ $details->links() }}
							</div>
						</div>

					</div>
				</div>
			</div>

		</section>
	</div>

@endsection
