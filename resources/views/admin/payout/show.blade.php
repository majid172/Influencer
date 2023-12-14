@extends('admin.layouts.master')
@section('page_title', __('Payout Details'))

@section('content')
	<div class="main-content">
		<section class="section">
			<div class="section-header">
				<h1>@lang('Payout Details')</h1>
				<div class="section-header-breadcrumb">
					<div class="breadcrumb-item active">
						<a href="{{ route('admin.home') }}">@lang('Dashboard')</a>
					</div>
					<div class="breadcrumb-item">@lang('Payout Details')</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					@if($payout->last_error)
						<div class="card">
							<div class="card-body shadow">
								<div class="media align-items-center d-flex justify-content-between text-danger">
									<div>
										<i class="fas fa-exclamation-triangle"></i> @lang('Last Api error message:-') {{$payout->last_error}}
									</div>
								</div>
							</div>
						</div>
					@endif
					<div class="card">
						<div class="card-body shadow">
							<div class="d-flex justify-content-between align-items-center">
								<h4 class="card-title">@lang('Payout Details')</h4>
								<div>
									<a href="{{route('admin.payout.index')}}"
									   class="btn btn-sm  btn-primary mr-2">
										<span><i class="fas fa-arrow-left"></i> @lang('Back')</span>
									</a>
									@if($payout->status == 1)
										<a href="{{ route('admin.user.payout.confirm',$payout->utr) }}"
										   data-target="#confirmModal" data-toggle="modal"
										   class="btn btn-success btn-sm confirmButton">@lang('Confirm')</a>
										<a href="{{ route('admin.user.payout.cancel',$payout->utr) }}"
										   data-toggle="modal" data-target="#confirmModal"
										   class="btn btn-danger btn-sm confirmButton">@lang('Reject')</a>
									@endif
								</div>
							</div>
							<hr>
							<div class="p-4 border shadow-sm rounded">
								<div class="row">
									<div class="col-md-6 border-right">
										<ul class="list-style-none">
											<li class="my-2 border-bottom pb-3">
                                              <span class="font-weight-medium text-dark"><i
													  class="fas fa-info-circle mr-2 text-primary"></i> @lang('Transaction:') <small
													  class="float-right">{{dateTime($payout->created_at,'d/M/Y H:i')}} </small></span>
											</li>
											<li class="my-3 d-flex justify-content-between">
												<span><i class="fas fa-check-circle mr-2 text-primary"></i> @lang('Sender')</span>
												<a href="{{route('user.edit',$payout->user_id)}}"
												   class="text-decoration-none">
													<div class="d-lg-flex d-block align-items-center ">
														<div class="rounded-circle mr-2 w-40px" >
															{!! optional($payout->user)->profilePicture() !!}
														</div>
														<div class="">
															<h5 class="text-dark mb-0 font-16 font-weight-medium">
																{{ __(optional($payout->user)->name ?? __('N/A')) }}
															</h5>
															<p class="text-muted mb-0 font-12 font-weight-medium">
																{{ __(optional($payout->user)->email ?? __('N/A')) }}
															</p>
														</div>
													</div>
												</a>
											</li>
											<li class="my-3">
											   <span class="font-weight-bold text-dark"><i
													   class="fas fa-check-circle mr-2 text-primary"></i> @lang('Payment method :') <span
													   class="font-weight-medium text-info">{{ __(optional($payout->payoutMethod)->methodName) }}</span>
											   </span>
											</li>
											<li class="my-3">
											   <span class=""><i
													   class="fas fa-check-circle mr-2 text-primary"></i> @lang('Type :') <span
													   class="font-weight-medium text-info">{{optional($payout->payoutMethod)->is_automatic == 1?'Automatic':'Manual'}}</span>
											   </span>
											</li>
											<li class="my-3">
											   <span class="font-weight-medium text-dark"><i
													   class="fas fa-check-circle mr-2 text-primary"></i> @lang('Transaction Id :') <span
													   class="font-weight-medium text-success">{{ __($payout->utr) }}</span>
											   </span>
											</li>
											<li class="my-3">
											   <span><i class="fas fa-check-circle mr-2 text-primary"></i> @lang('Status :')
												   @if($payout->status == 0)
													   <span class="text-warning">@lang('Pending')</span>
												   @elseif($payout->status == 1)
													   <span class="text-info">@lang('Generated')</span>
												   @elseif($payout->status == 2)
													   <span class="text-success">@lang('Payment Done')</span>
												   @elseif($payout->status == 5)
													   <span class="text-danger">@lang('Canceled')</span>
												@endif
											</li>
											<li class="my-3">
											   <span><i
													   class="fas fa-check-circle mr-2 text-primary"></i> @lang('Charge :') <span
													   class="font-weight-bold text-dark">{{ (getAmount($payout->charge,2)).' '.__(config('basic.base_currency')) }}</span>
											   </span>
											</li>
											<li class="my-3">
											   <span><i class="fas fa-check-circle mr-2 text-primary"></i> @lang('Deduct amount from user :') <span
													   class="font-weight-bold text-danger">{{ (getAmount($payout->transfer_amount,2)).' '.__(config('basic.base_currency')) }}</span>
											   </span>
											</li>
											<li class="my-3">
											   <span><i class="fas fa-check-circle mr-2 text-primary"></i> @lang('Payable Amount :') <span
													   class="font-weight-bold text-dark">
											   {{ (getAmount($payout->received_amount)).' '.__(config('basic.base_currency')) }}</span>
											   </span>
											</li>
										</ul>
									</div>
									<div class="col-md-6 ">
										<ul class="list-style-none border-bottom">
											<li class="my-2 border-bottom pb-3">
											   <span class="font-weight-medium text-dark"><i
													   class="fas fa-user mr-2 text-primary"></i> @lang('Withdraw Information')
											   </span>
											</li>
											@if(isset($payout->withdraw_information))
												@foreach(json_decode($payout->withdraw_information) as $key => $value)
													<li class="my-3">
														   <span><i class="fas fa-check-circle mr-2 text-primary"></i> {{ __(snake2Title($key)) }} :<span
																   class="font-weight-bold text-dark">
																   @if($value->type == 'file')
																	   <img class="img-profile rounded-circle"
																			src="{{asset('assets/upload/payoutFile').'/'.$value->fieldValue }}">
																   @else
																	   {{ __($value->fieldValue) }}
																   @endif
															   </span>
														   </span>
													</li>
												@endforeach
											@endif
											@if($payout->meta_field)
												@foreach($payout->meta_field as $key => $value)
													<li class="my-3">
														   <span><i class="fas fa-check-circle mr-2 text-primary"></i> {{ __(snake2Title($key)) }} :<span
																   class="font-weight-bold text-dark">
																   @if($value->type == 'file')
																	   <img class="img-profile rounded-circle"
																			src="{{asset('assets/upload/payoutFile').'/'.$value->fieldValue }}">
																   @else
																	   {{ __($value->fieldValue) }}
																   @endif
															   </span>
														   </span>
													</li>
												@endforeach
											@endif
										</ul>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			@if($payout->note)
				<div class="row mx-1">
					<div class="card">
						<div class="card-body shadow">
							@lang('Note :') {{ __($payout->note) }}
						</div>
					</div>
				</div>
			@endif
		</section>
	</div>
	@if($payout->status == 1)
		<div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
			 aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header text-danger">
						<h5 class="modal-title" id="exampleModalLabel"><i
								class="fas fa-info-circle"></i> @lang('Confirmation !')</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<form action="" method="post" id="confirmForm">
						<div class="modal-body text-center">
							<p>@lang('Are you sure you want to confirm this action?')</p>
							@csrf
							<div class="form-group">
								<label for="note">@lang('Note')</label>
								<textarea name="note" rows="5" class="form-control form-control-sm"></textarea>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-outline-primary"
									data-dismiss="modal">@lang('Close')</button>
							<input type="submit" class="btn btn-primary" value="@lang('Confirm')">
						</div>
					</form>
				</div>
			</div>
		</div>
	@endif
@endsection

@section('scripts')
	<script>
		'use strict';
		$(document).ready(function () {
			$(document).on('click', '.confirmButton', function (e) {
				e.preventDefault();
				let submitUrl = $(this).attr('href');
				$('#confirmForm').attr('action', submitUrl)
			})
		})
	</script>
@endsection
