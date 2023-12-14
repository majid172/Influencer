@extends('admin.layouts.master')
@section('page_title',__('User List'))

@section('content')
<div class="main-content">
	<section class="section">
		<div class="section-header">
			<h1>@lang('User List')</h1>
			<div class="section-header-breadcrumb">
				<div class="breadcrumb-item active">
					<a href="{{ route('admin.home') }}">@lang('Dashboard')</a>
				</div>
				<div class="breadcrumb-item">@lang('User List')</div>
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
								<form action="{{ route('user.search') }}" method="get">
									@include('admin.user.searchForm')
								</form>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<div class="card mb-4 card-primary shadow">
							<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
								<h6 class="m-0 font-weight-bold text-primary">@lang('User List')</h6>
								<a href="{{ route('send.mail.user') }}" class="btn btn-sm btn-outline-primary"><i
											class="fas fa-envelope"></i> @lang('Send Mail to All')</a>
							</div>
							<div class="card-body">
								<div class="table-responsive">
									<table class="table table-striped table-hover align-items-center table-borderless">
										<thead class="thead-light">
										<tr>
											<th>@lang('SL')</th>
											<th>@lang('Name')</th>
											<th>@lang('Email')</th>
											<th>@lang('Profile Complete')</th>
											<th>@lang('Profile Status')</th>
											<th>@lang('Last login')</th>
											<th>@lang('User Status')</th>
											<th>@lang('Action')</th>
										</tr>
										</thead>
										<tbody>
										@forelse($users as $key => $value)
											<tr>
												<td data-label="SL">
													{{loopIndex($users) + $key}}
												</td>
												<td data-label="@lang('Name')">
													<a href="{{route('user.edit',$value)}}" target="_blank">
														<div class="d-lg-flex d-block align-items-center ">
															<div class="rounded-circle mr-2 w-40px" data-original-title="{{$value->name}}">
																{!! $value->profilePicture() !!}
															</div>
															<div class="d-inline-flex d-lg-block align-items-center">
																<p class="text-dark mb-0 font-16 font-weight-medium">{{$value->name}}</p>
																<span class="text-muted font-14">{{ '@'.$value->username}}</span>
															</div>
														</div>
													</a>
												</td>
												<td data-label="@lang('Email')">{{ __($value->email) }}</td>
												<td data-label="@lang('Profile Complete')">
													<div class="progress">
														<div class="progress-bar progress-bar-striped progress-bar-animated bg-info" role="progressbar" aria-valuenow="{{getProfileCompletedPercentage($value->id)}}" aria-valuemin="0" aria-valuemax="100" style="width: {{getProfileCompletedPercentage($value->id)}}%">{{getProfileCompletedPercentage($value->id)}}%</div>
													</div>
												</td>
												<td data-label="@lang('Profile Status')">
													@if(optional($value->profileInfo)->status == 0)
														<span class="badge badge-danger">@lang('Inactive')</span>
													@else
														<span class="badge badge-success">@lang('Active')</span>
													@endif
												</td>
												<td data-label="@lang('Last login')">{{ (optional($value->profile)->last_login_at) ? __(date('d/m/Y - H:i',strtotime($value->profile->last_login_at))) : __('N/A') }}</td>
												<td data-label="@lang('Status')">
													@if($value->status)
														<span class="badge badge-success">@lang('Active')</span>
													@else
														<span class="badge badge-danger">@lang('Inactive')</span>
													@endif
												</td>

												<td data-label="@lang('Action')">
													<div class="dropdown d-inline">
														<button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
														@lang('More Actions')
														</button>
														<div class="dropdown-menu shadow">
															<a href="{{ route('user.edit',$value) }}" class="dropdown-item">
																<i class="far fa-edit text-primary mr-1"></i> @lang('Edit')
															</a>
															<a href="{{ route('send.mail.user',$value) }}" class="dropdown-item">
																<i class="far fa-envelope text-primary mr-1"></i> @lang('Send mail')
															</a>
															@if(optional($value->profileInfo)->status == 0)
																<a href="javascript:void(0)"
																data-route="{{ route('admin.profile-approve',$value->id) }}"
																data-toggle="modal"
																data-target="#approve-modal"
																class="dropdown-item approve-confirm">
																	<i class="far fa-user text-primary mr-1" aria-hidden="true"></i> @lang('Approve Profile')
																</a>
															@else
																<a href="javascript:void(0)"
																data-route="{{ route('admin.profile-pending',$value->id) }}"
																data-toggle="modal"
																data-target="#pending-modal"
																class="dropdown-item pending-confirm">
																	<i class="far fa-user text-danger mr-1" aria-hidden="true"></i> @lang('Make Profile Pending')
																</a>
															@endif

															<a href="{{ route('user.asLogin',$value) }}" class="dropdown-item">
																<i class="fa fa-sign-in-alt text-primary mr-1"></i> @lang('Login As User')
															</a>
														</div>
													</div>
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
								<div class="card-footer">{{ $users->links() }}</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

	</section>
</div>


    <!-- User Profile Approve Modal -->
    <div id="approve-modal" class="modal fade" tabindex="-1" role="dialog"
         aria-labelledby="primary-header-modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="primary-header-modalLabel">@lang('Approve User\'s Profile Confirmation')
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <p>@lang('Are you sure to approve this profile?')</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark" data-dismiss="modal">@lang('Close')</button>
                    <form action="" method="post" class="approveRoute">
                        @csrf
                        @method('put')
                        <button type="submit" class="btn btn-primary">@lang('Yes')</button>
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->


    <!-- User Profile Pending Modal -->
    <div id="pending-modal" class="modal fade" tabindex="-1" role="dialog"
         aria-labelledby="primary-header-modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="primary-header-modalLabel">@lang('Pending User\'s Profile Confirmation')
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <p>@lang('Are you sure to make this profile pending?')</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark" data-dismiss="modal">@lang('Close')</button>
                    <form action="" method="post" class="pendingRoute">
                        @csrf
                        @method('put')
                        <button type="submit" class="btn btn-primary">@lang('Yes')</button>
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

@endsection


@section('scripts')
	<script>
		'use strict'
		// for user profile active/pending
		$(document).ready(function () {
			$('.approve-confirm').on('click', function () {
				var route = $(this).data('route');
				$('.approveRoute').attr('action', route)
			})
			$('.pending-confirm').on('click', function () {
				var route = $(this).data('route');
				$('.pendingRoute').attr('action', route)
			})
		});
	</script>
@endsection
