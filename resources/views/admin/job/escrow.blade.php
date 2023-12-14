@extends('admin.layouts.master')
@section('page_title',__('Hiring Job Escrows'))
@section('content')

	<div class="main-content">
		<section class="section">
			<div class="section-header">
				<h1>@lang('Escrow Lists')</h1>
				<div class="section-header-breadcrumb">
					<div class="breadcrumb-item active">
						<a href="{{route('admin.home')}}">@lang('Dashboard')</a>
					</div>
					<div class="breadcrumb-item">@lang('Escrow Lists')</div>
				</div>
			</div>

			<div class="row">
				<div class="col-12">
					<div class="card card-primary shadow">
						<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
							<h6 class="m-0 font-weight-bold text-primary">@lang('Escrow Lists')</h6>

						</div>

						<div class="card-body">
							<div class="table-responsive">
								<table class="table table-striped table-hover align-items-center ">
									<thead>
									<tr>
										<th>@lang('SL')</th>
										<th>@lang('Project File')</th>
										<th>@lang('Paid Amount')</th>
										<th>@lang('Return Amount')</th>
										<th>@lang('Payment Date')</th>
										<th>@lang('Payment Status')</th>
										<th>@lang('Submit Status')</th>

									</tr>
									</thead>
									<tbody>
									@forelse($escrows as $key => $list)
										<tr>
											<td data-label="SL">
												{{ ++$key}}
											</td>

											<td data-label="FILE"> {{__($list->file_name )}} </td>
											<td data-label="PAID AMOUNT">{{$basic->currency_symbol}} {{getAmount($list->paid)}} </td>
											<td data-label="RETURN AMOUNT">{{$basic->currency_symbol}} {{getAmount($list->return_payment)}}  </td>
											<td data-label="PAYMENT DATE"> {{dateTime($list->payment_date,'d M , Y')}} </td>
											<td data-label="PAYMENT STATUS">
												@if($list->payment_status == 1)
													<span class="badge badge-success">@lang('Paid')</span>
												@else
													<span class="badge badge-danger">@lang('Unpaid')</span>
												@endif

											</td>
											<td data-label="SUBMIT STATUS">
												@if($list->is_submitted == 1)
													<span class="badge badge-success">@lang('Submit')</span>
												@else
													<span class="badge badge-danger">@lang('Continue')</span>
												@endif

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

							<div class="card-footer"
							{{ $escrows->links() }}
							</div>
						</div>

					</div>
				</div>

		</section>
	</div>

@endsection

