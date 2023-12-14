@extends('admin.layouts.master')
@section('title')
    @lang('Country List')
@endsection

@push('extra_styles')
    <link rel="stylesheet" href="{{ asset('assets/dashboard/css/jquery-ui.min.css') }}"  type="text/css">
    <link rel="stylesheet" href="{{ asset('assets/dashboard/css/dataTables.bootstrap4.min.css') }}" type="text/css">
@endpush


@section('content')
	<div class="main-content">
		<section class="section">
			<div class="section-header">
				<h1>@lang('Country List')</h1>
				<div class="section-header-breadcrumb">
					<div class="breadcrumb-item active">
						<a href="{{route('admin.home')}}">@lang('Dashboard')</a>
					</div>
					<div class="breadcrumb-item">@lang('Country List')</div>
				</div>
			</div>

			<div class="row mb-3">
				<div class="container-fluid" id="container-wrapper">
					<div class="row">
						<div class="col-lg-12">
							<div class="card mb-4 card-primary shadow">
								<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
									<h6 class="m-0 font-weight-bold text-primary">@lang('Country List')</h6>
									<div class="media mb-4 float-right">
										<a href="{{route('admin.countryCreate')}}" class="btn btn-sm btn-primary mr-2">
											<span><i class="fa fa-plus-circle"></i> @lang('Add New')</span>
										</a>
									</div>
								</div>
								<div class="card-body">
									<div class="table-responsive">
										<table class="table table-striped table-hover align-items-center table-borderless" id="country-table">
											<thead class="thead-light">
											<tr>
												<th scope="col">@lang('SL No.')</th>
												<th scope="col">@lang('Country Name')</th>
												<th scope="col" class="text-center">@lang('Action')</th>
											</tr>
											</thead>
											<tbody>
											@forelse($countryList as $item)
												<tr>
													<td data-label="@lang('SL No.')">{{$loop->index+1}}</td>
													<td data-label="@lang('Country Name')">
														@lang($item->name)
													</td>

													<td data-label="@lang('Action')" class="text-center">
														<a href="{{ route('admin.countryEdit',$item->id) }}"
														   class="btn btn-outline-primary btn-rounded btn-sm editBtn"
														>
															<i class="fas fa-edit"></i>@lang('Edit')
														</a>
														<a href="javascript:void(0)"
														   data-route="{{ route('admin.countryDelete',$item->id) }}"
														   data-toggle="modal"
														   data-target="#delete-modal"
														   class="btn btn-outline-danger btn-rounded btn-sm deleteItem">
														   <i class="fas fa-trash-alt"></i>@lang('Delete')
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
									<div class="card-footer">

									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
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
						@method('delete')
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

		$('#country-table').dataTable({
			"paging": true,
			"ordering": true
		});
	</script>

	@if ($errors->any())
		@php
			$collection = collect($errors->all());
			$errors = $collection->unique();
		@endphp
		<script>
			"use strict";
			@foreach ($errors as $error)
			Notiflix.Notify.Failure("{{trans($error)}}");
			@endforeach
		</script>
	@endif
@endsection
