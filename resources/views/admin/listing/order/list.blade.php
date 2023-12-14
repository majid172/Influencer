@extends('admin.layouts.master')
@section('page_title',__('Listing Order list'))

@section('content')
	<div class="main-content">
		<section class="section">
			<div class="section-header">
				<h1>@lang('Listing Order List')</h1>
				<div class="section-header-breadcrumb">
					<div class="breadcrumb-item active">
						<a href="{{route('admin.home')}}">@lang('Dashboard')</a>
					</div>
					<div class="breadcrumb-item">@lang('Listing Order List')</div>
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
									<form action="{{ route('admin.listing.order.search') }}" method="get">
										@include('admin.listing.order.searchForm')
									</form>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-12">
							<div class="card card-primary shadow">
								<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
									<h6 class="m-0 font-weight-bold text-primary">@lang('Order List')</h6>

								</div>

								<div class="card-body">
									<div class="table-responsive">
										<table class="table table-striped table-hover align-items-center ">
											<thead>
											<tr>
												<th>@lang('Order no.')</th>
												<th>@lang('Title')</th>
												<th>@lang('Package')</th>
												<th>@lang('Influencer')</th>
												<th>@lang('Client')</th>
												<th>@lang('Amount')</th>
												<th>@lang('Delivery Date')</th>
												<th>@lang('File')</th>
												<th>@lang('Status')</th>
												<th>@lang('Action')</th>
											</tr>
											</thead>
											<tbody>
											@forelse($orders as $key => $list)
												<tr>
													<td data-label="@lang('Order no.')">{{$list->order_no}}</td>
													<td data-label="@lang('Title')">{{Str::limit(optional($list->listing)->title,20)}}</td>
													<td data-label="@lang('Package')">{{__($list->package_name)}}</td>
													<td data-label="@lang('Influencer')">
														<a href="{{ route('user.edit', $list->influencer_id)}}"
															class="text-decoration-none">
															 <div class="d-lg-flex d-block align-items-center ">
																 <div class="rounded-circle mr-2 w-40px" >
																	 {!! optional($list->influencer)->profilePicture() !!}
																 </div>
																 <div class="d-inline-flex d-lg-block align-items-center">
																	 <p class="text-dark mb-0 font-16 font-weight-medium">{{Str::limit(optional($list->influencer)->name?? __('N/A'),20)}}</p>
																	 <span
																		 class="text-muted font-14 ml-1">{{ '@'.optional($list->influencer)->username?? __('N/A')}}</span>
																 </div>
															 </div>
														 </a>

													</td>
													<td data-label="@lang('Client')">
														<a href="{{ route('user.edit', $list->user_id)}}"
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

													<td data-label="@lang('Amount')" class="text-success">{{getAmount($list->amount)}} {{$basic->base_currency}}</td>
													<td data-label="@lang('Delivery Date')">{{$list->delivery_date}}</td>
													<td data-label="@lang('File')">
														@if($list->file)
															{{$list->file_name}}
														@else @lang('N/A') @endif
													 </td>

													<td data-label="@lang('Status')">
														@if($list->status == 0)
															<span class="badge badge-warning">@lang('Panding')</span>
															@elseif($list->status == 1)
															<span class="badge badge-primary">@lang('Accepted')</span>
															@elseif($list->status == 2)
															<span class="badge badge-info">@lang('Done')</span>
															@elseif($list->status == 3)
															<span class="badge badge-success">@lang('Completed')</span>

														@endif
													</td>
												
													<td data-label="@lang('Action')">
														<button type="button" class="btn btn-sm btn-outline-danger remove" data-toggle="modal" data-target="#removeModal" data-id="{{$list->id}}"> <i class="fas fa-trash pr-1"></i>@lang('Remove')</button>
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
										{{ $orders->links() }}
									</div>
								</div>

							</div>
						</div>
					</div>
				</div>
			</div>



		</section>
	</div>


	<div class="modal fade" id="removeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">@lang('Remove order from list')</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form action="{{route('admin.listing.order.remove')}}" method="post">
					@csrf
					<div class="modal-body">
						<input type="hidden" name="id">
						<p>@lang('Are you want to remove this order?')</p>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('No')</button>
						<button type="submit" class="btn btn-primary">@lang('Yes')</button>
					</div>
				</form>
			</div>
		</div>
	</div>

@endsection

@section('scripts')
	<script>
		'use strict'
		$(document).ready(function () {
			$('.approve').on('click',function(){
				let url = $(this).data('route');
				$('.route').attr('action',url);

			});
			$('.remove').on('click',function (){
				let modal = $('#removeModal');
				modal.find('input[name="id"]').val($(this).data('id'));
			});
		});
	</script>
@endsection
