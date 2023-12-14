@extends('admin.layouts.master')
@section('title')
	@lang('Duration List')
@endsection

@push('extra_styles')
    <link rel="stylesheet" href="{{ asset('assets/dashboard/css/jquery-ui.min.css') }}"  type="text/css">
    <link rel="stylesheet" href="{{ asset('assets/dashboard/css/dataTables.bootstrap4.min.css') }}" type="text/css">
@endpush

@section('content')
	<div class="main-content">
		<section class="section">
			<div class="section-header">
				<h1>@lang('Deadline List')</h1>
				<div class="section-header-breadcrumb">
					<div class="breadcrumb-item active">
						<a href="{{route('admin.home')}}">@lang('Dashboard')</a>
					</div>
					<div class="breadcrumb-item">@lang('Duration List')</div>
				</div>
			</div>

			<div class="row">
				<div class="col-12">
					<div class="card card-primary shadow">
						<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
							<h6 class="m-0 font-weight-bold text-primary">@lang('Deadline List')</h6>
							<div class="media mb-4 float-right">
								<button type="button" class="btn btn-sm btn-outline-primary store mr-2" data-toggle="modal" data-target="#exampleModalCenter">
									<i class="fas fa-plus"></i> @lang('Add New')
								</button>

							</div>
						</div>

						<div class="card-body">
							<div class="table-responsive">
								<table class="table table-striped table-hover align-items-center table-borderless" id="category-table">
									<thead>
										<tr>
											<th data-label="@lang('SL')">@lang('SL')</th>
											<th data-label="@lang('Duration')">@lang('Duration')</th>
											<th data-label="@lang('Frequency')">@lang('Frequency')</th>
											<th data-label="@lang('Action')">@lang('Action')</th>
										</tr>
									</thead>
									<tbody>
										@forelse($durations as $item)
										<tr>
											<td data-label="@lang('SL No.')">{{$loop->index+1}}</td>
											<td data-label="@lang('Duration')">
												{{__($item->duration)}}
											</td>
											<td data-label="@lang('Frequency')" >
												{{__($item->frequency)}}
											</td>


											<td data-label="@lang('Action')">

												<button type="button" class="btn btn-sm btn-outline-primary store mr-2" data-toggle="modal" data-target="#exampleModalCenter" data-id="{{$item->id}}" data-duration="{{$item->duration}}" data-frequency="{{$item->frequency}}">
													<i class="fas fa-edit"></i> @lang('Edit')
												</button>


												<a href="javascript:void(0)"
													data-route="{{ route('admin.deadline.delete', $item->id) }}"
													data-toggle="modal" data-target="#delete-modal"
													class="btn btn-outline-danger btn-rounded btn-sm deleteItem"><i
														class="fas fa-trash-alt"></i> @lang('Delete')
												</a>

											</td>
										</tr>
										@empty
										<tr>
											<td colspan="100%" class="text-center">@lang('No Data Found')</td>
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
		  <h5 class="modal-title" id="exampleModalLongTitle">@lang('Duration settings')</h5>
		  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		  </button>
		</div>
		<form action="{{route('admin.deadline.store')}}" method="POST">
			@csrf
			<div class="modal-body">
				<input type="hidden" name="id" id="id">
				<div class="form-group">
					<label for="duration">@lang('Duration ')</label>
					<input type="text" name="duration" id="duration" class="form-control">
				</div>

				<div class="form-group">
					<label for="frequency">@lang('Frequency (Day wise)')</label>
					<input type="text" name="frequency" id="frequency" class="form-control">
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

		$(function(){
			$('.store').on('click',function(){
				var duration = $(this).data('duration');
				var frequency = $(this).data('frequency');
				var modal = $('#exampleModalCenter');
				modal.find('input[name="id"]').val($(this).data('id'));
				modal.find('input[name="duration"]').val(duration);
				modal.find('input[name="frequency"]').val(frequency);
				modal.modal('show');
			});
		});

		$(function(){
			$('.deleteItem').on('click',function(){
				var url = $(this).data('route')
				$('.deleteRoute').attr('action',url);

			});
		});

	</script>
@endsection
