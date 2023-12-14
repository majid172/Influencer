@extends('admin.layouts.master')
@section('page_title',__('Job Post'))
@section('content')

	<div class="main-content">
		<section class="section">
			<div class="section-header">
				<h1>@lang('Job List')</h1>
				<div class="section-header-breadcrumb">
					<div class="breadcrumb-item active">
						<a href="{{route('admin.home')}}">@lang('Dashboard')</a>
					</div>
					<div class="breadcrumb-item">@lang('Job List')</div>
				</div>
			</div>

			<div class="row">
				<div class="col-lg-12">
					<div class="card mb-4 card-primary shadow-sm">
						<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
							<h6 class="m-0 font-weight-bold text-primary">@lang('Search')</h6>
						</div>
						<div class="card-body">
							<form action="{{route('admin.jobs.search')}}" method="get">
								@include('admin.job.search')
							</form>
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-12">
					<div class="card card-primary shadow">
						<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
							<h6 class="m-0 font-weight-bold text-primary">@lang('Job List')</h6>

						</div>

						<div class="card-body">
							<div class="table-responsive">
								<table class="table table-striped table-hover align-items-center ">
									<thead>
									<tr>
										<th>@lang('SL')</th>
										<th>@lang('Title')</th>
										<th>@lang('Client name')</th>
										<th>@lang('Category')</th>
										<th>@lang('Scope')</th>
										<th>@lang('Job type')</th>
										<th>@lang('Total Proposal')</th>
										<th>@lang('Status')</th>
										<th>@lang('Action')</th>
									</tr>
									</thead>
									<tbody>
									@forelse($jobs as $key => $job)
										<tr>
											<td data-label="SL">
												{{loopIndex($jobs) + $key}}
											</td>

											<td data-label="TITLE"> {{Str::limit($job->title,20)}} </td>
											<td data-label="CLIENT">
												<a href="{{ route('user.edit', $job->creator_id)}}"
												   class="text-decoration-none">
													<div class="d-lg-flex d-block align-items-center ">
														<div class="rounded-circle mr-2 w-40px" >
															{!! optional($job->user)->profilePicture() !!}
														</div>
														<div class="d-inline-flex d-lg-block align-items-center">
															<p class="text-dark mb-0 font-16 font-weight-medium">{{Str::limit(optional($job->user)->name?? __('N/A'),20)}}</p>
															<span
																class="text-muted font-14 ml-1">{{ '@'.optional($job->user)->username?? __('N/A')}}</span>
														</div>
													</div>
												</a>
											</td>
											<td data-label="CATEGORY">{{__(optional(optional($job->category)->details)->name)??'N/A'}}</td>
											<td data-label="SCOPE">
												@if ($job->scope == 1)
													@lang('Small')
												@elseif($job->scope == 2)
													@lang('Medium')
												@elseif($job->scope == 3)
													@lang('Large')
												@endif
											</td>
											<td data-label="JOB TYPE">
												@if ($job->job_type == 1)
													@lang('Hourly')
												@elseif($job->job_type == 2)
													@lang('Project wise')
												@endif
											</td>
											<td data-label="TOTAL PROPOSAL">{{$job->total_proposal}}</td>

											<td data-label="STATUS">
												@if ($job->status == 1)
													<span class="badge badge-info">@lang('Approve')</span>
												@elseif($job->status == 2)
													<span class="badge badge-success">@lang('Completed')</span>
												@else
													<span class="badge badge-secondary">@lang('Pending')</span>
												@endif


											</td>
											<td data-label="Action">
												@if($job->status == 0)
												<button type="button"  class="btn btn-sm btn-outline-warning approve" data-toggle="modal" data-target="#exampleModal" data-id="{{$job->id}}" data-route="{{route('admin.jobs.approve',$job->id)}}">
													<i class="fas fa-check pr-1"></i>@lang('Approve')
												</button>
												@endif
												<a class="btn btn-sm btn-outline-primary" href="{{route('admin.jobs.details',$job->id)}}" > <i class="fas fa-eye pr-1"></i> @lang('Proposal')</a>
											</td>


										</tr>
									@empty
										<tr>
											<th colspan="100%" class="text-center">
												<img src="{{asset('assets/global/no-data.png')}}" alt="@lang('no-data')" class="no-data-img">
												<br>
												@lang('No Data Found')</th>
										</tr>

									@endforelse
									</tbody>
								</table>
							</div>

							<div class="card-footer">
								{{ $jobs->links() }}
							</div>
						</div>

					</div>
				</div>
			</div>

		</section>
	</div>


	<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">@lang('Approval ')</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					@lang('Are you sure approve Job Post?')
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('Close')</button>
					<form action="" method="POST" class="approveRoute">
						@csrf
						<button type="submit" class="btn btn-primary">@lang('Approve')</button>
					</form>

				</div>
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

				$('.approveRoute').attr('action',url);

			});
		});
	</script>
@endsection

