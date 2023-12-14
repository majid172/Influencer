@extends('admin.layouts.master')
@section('page_title',__('Payout Method List'))
@section('content')
	<div class="main-content">
		<section class="section">
			<div class="section-header">
				<h1>@lang('Payout Method List')</h1>
				<div class="section-header-breadcrumb">
					<div class="breadcrumb-item active">
						<a href="{{ route('admin.home') }}">@lang('Dashboard')</a>
					</div>
					<div class="breadcrumb-item">@lang('Payout Method List')</div>
				</div>
			</div>

			<div class="row mb-3">
				<div class="container-fluid" id="container-wrapper">
					<div class="row justify-content-md-center">
						<div class="col-lg-12">
							<div class="card mb-4 card-primary shadow">
								<div
									class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
									<h6 class="m-0 font-weight-bold text-primary">@lang('Payout Method List')</h6>
									<a href="{{ route('payout.method.add') }}"
									   class="btn btn-sm btn-outline-primary"><i class="fas fa-plus-circle"></i> @lang('Add New')</a>
								</div>

								<div class="card-body">
									<div class="table-responsive">
										<table class="table table-striped table-hover align-items-center table-flush">
											<thead class="thead-light">
											<tr>
												<th>@lang('Name')</th>
												<th>@lang('Min limit')</th>
												<th>@lang('Max limit')</th>
												<th>@lang('Status')</th>
												<th>@lang('Action')</th>
											</tr>
											</thead>
											<tbody>
											@foreach($payoutMethods as $key => $value)
												<tr>
													<td data-label="@lang('Name')">
														<a href="javascript:void(0)"
														   class="text-decoration-none">
															<div class="d-lg-flex d-block align-items-center ">
																<div class="mr-3"><img
																		src="{{getFile($value->driver,$value->logo) }}"
																		alt="user" class="rounded-circle"
																		width="40" data-toggle="tooltip"
																		title=""
																		data-original-title="{{ __($value->methodName) }}">
																</div>
																<div
																	class="d-inline-flex d-lg-block align-items-center ms-2">
																	<p class="text-dark mb-0 font-16 font-weight-medium">
																		{{ __($value->methodName) }}</p>
																	<span
																		class="text-dark font-weight-bold font-14 ml-1">{{$value->is_automatic == 1?'Automatic':'Manual'}}</span>
																</div>
															</div>
														</a>
													</td>
													<td data-label="@lang('Min limit')">{{config('basic.currency_symbol')}}{{ (getAmount($value->min_limit)) }}</td>
													<td data-label="@lang('Max limit')">{{config('basic.currency_symbol')}}{{ (getAmount($value->max_limit)) }}</td>
													<td data-label="@lang('Status')">
														@if($value->is_default)
															<span class="badge badge-success">@lang('Default')</span>
														@elseif($value->is_active)
															<span class="badge badge-info">@lang('Active')</span>
														@else
															<span class="badge badge-warning">@lang('Inactive')</span>
														@endif
													</td>
													<td data-label="@lang('Action')">
														<a href="{{ route('payout.method.edit',$value) }}"
														   class="btn btn-sm btn-outline-primary"><i
																class="fas fa-edit"></i> @lang('Edit')
														</a>
													</td>
												</tr>
											@endforeach
											</tbody>
										</table>
									</div>
									<div class="card-footer">
										{{ $payoutMethods->links() }}
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

