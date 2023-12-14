@extends('admin.layouts.master')
@section('title')
	@lang('Skill List')
@endsection

@push('extra_styles')
    <link rel="stylesheet" href="{{ asset('assets/dashboard/css/jquery-ui.min.css') }}"  type="text/css">
    <link rel="stylesheet" href="{{ asset('assets/dashboard/css/dataTables.bootstrap4.min.css') }}" type="text/css">
@endpush

@section('content')
	<div class="main-content">
		<section class="section">
			<div class="section-header">
				<h1>@lang('Skill List')</h1>
				<div class="section-header-breadcrumb">
					<div class="breadcrumb-item active">
						<a href="{{route('admin.home')}}">@lang('Dashboard')</a>
					</div>
					<div class="breadcrumb-item">@lang('Skill List')</div>
				</div>
			</div>

			<div class="row">
				<div class="col-12">
					<div class="card card-primary shadow">
						<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
							<h6 class="m-0 font-weight-bold text-primary">@lang('Skill List')</h6>
							<div class="media mb-4 float-right">
								<button type="button" class="btn btn-sm btn-outline-primary mr-2" data-toggle="modal" data-target="#exampleModalCenter">
									<i class="fas fa-edit"></i> @lang('Add New')
								</button>

							</div>
						</div>

						<div class="card-body">
							<div class="table-responsive">
								<table class="table table-striped table-hover align-items-center table-borderless" id="category-table">
									<thead>
										<tr>
											<th data-label="@lang('SL')">@lang('SL')</th>
											<th data-label="@lang('Skill')">@lang('Skill')</th>
											<th data-label="@lang('Status')">@lang('Status')</th>
											<th data-label="@lang('Action')">@lang('Action')</th>
										</tr>
									</thead>
									<tbody>
										@forelse($skills as $item)
										<tr>
											<td data-label="@lang('SL No.')">{{$loop->index+1}}</td>
											<td data-label="@lang('Skill')">
												{{__($item->skill)}}
											</td>
											<td data-label="@lang('Status')" class="badges">
												@if($item->status == 1)
													<span class="badge badge-success">@lang('Active')</span>
												@else
													<span class="badge badge-danger">@lang('Inactive')</span>
												@endif
											</td>


											<td data-label="@lang('Action')">

												<a href="{{ route('admin.skill.edit',$item->id) }}"
													class="btn btn-outline-primary btn-rounded btn-sm editBtn">
													<i class="fas fa-edit"></i> @lang('Edit')
												</a>

												<a href="javascript:void(0)"
													data-route="{{ route('admin.skill.delete', $item->id) }}"
													data-toggle="modal" data-target="#delete-modal"
													class="btn btn-outline-danger btn-rounded btn-sm deleteItem"><i
														class="fas fa-trash-alt"></i> @lang('Delete')
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
						</div>

					</div>
				</div>
			</div>

		</section>
	</div>

	{{-- add or edit modal --}}

<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
	  <div class="modal-content">
		<div class="modal-header">
		  <h5 class="modal-title" id="exampleModalLongTitle">@lang('Add Skill')</h5>
		  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		  </button>
		</div>
		<form action="{{route('admin.skill.store')}}" method="POST">
			@csrf
			<div class="modal-body">
				<div class="form-group">
					<label for="skill">@lang('Skill Name')</label>
					<input type="text" name="skill" id="skill" class="form-control">
				</div>

				<div class="form-group">
					<label>@lang('Status')</label>
					<div class="selectgroup w-100">
						<label class="selectgroup-item">
							<input type="radio" name="status" value="1"
								class="selectgroup-input" checked >
							<span class="selectgroup-button">@lang('ON')</span>
						</label>
						<label class="selectgroup-item">
							<input type="radio" name="status" value="0" class="selectgroup-input">
							<span class="selectgroup-button">@lang('OFF')</span>
						</label>
					</div>
					@error('status')
						<span class="text-danger" role="alert">
							<strong>{{ __($message) }}</strong>
						</span>
					@enderror
				</div>

			</div>
			<div class="modal-footer">

			  <button type="submit" class="btn btn-primary">@lang('Save')</button>
			</div>
		</form>
	  </div>
	</div>
</div>


	<!-- Delete Modal -->
	<div id="delete-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="primary-header-modalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="primary-header-modalLabel">@lang('Delete Confirmation')</h5>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				</div>
				<div class="modal-body">
					<p>@lang('Are you sure to delete this?')</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-dark" data-dismiss="modal">@lang('Close')</button>
					<form action="" method="post" class="deleteRoute">
						@csrf

						<button type="submit" class="btn btn-primary">@lang('Yes')</button>
					</form>
				</div>
			</div>
		</div>
	</div>

@endsection


@push('extra_scripts')
	<script src="{{ asset('assets/dashboard/js/jquery-ui.min.js') }}"></script>
	<script src="{{ asset('assets/dashboard/js/jquery.dataTables.min.js') }}"></script>
	<script src="{{ asset('assets/dashboard/js/dataTables.bootstrap4.min.js') }}"></script>
@endpush

@section('scripts')
	<script>
		'use strict'
		$(document).on('click', '.deleteItem', function () {
			let url = $(this).data('route');
			$('.deleteRoute').attr('action', url);
		})

		$('#category-table').dataTable({
			"paging": true,
			"ordering": true
		});
	</script>
@endsection
