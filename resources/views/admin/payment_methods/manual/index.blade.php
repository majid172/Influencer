@extends('admin.layouts.master')
@section('page_title')
	{{ trans($page_title) }}
@endsection
@section('content')
	<div class="main-content">
		<section class="section">
			<div class="section-header">
				<h1>@lang('Payment Methods')</h1>
				<div class="section-header-breadcrumb">
					<div class="breadcrumb-item active">
						<a href="{{ route('admin.home') }}">@lang('Dashboard')</a>
					</div>
					<div class="breadcrumb-item">@lang('Payment Methods')</div>
				</div>
			</div>
			<div class="row mb-3">
				<div class="container-fluid" id="container-wrapper">
					<div class="row">
						<div class="col-lg-12">
							<div class="card mb-4 card-primary shadow">
								<div
									class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
									<h6 class="m-0 font-weight-bold text-primary">@lang('Payment Methods')</h6>
									<a href="{{route('admin.deposit.manual.create')}}"
									   class="btn btn-success btn-sm float-right mb-3"><i
											class="fa fa-plus-circle"></i> {{trans('Add New')}}</a>
								</div>
								<div class="card-body">
									<table class="table ">
										<thead class="thead-dark">
										<tr>
											<th scope="col">@lang('Name')</th>
											<th scope="col">@lang('Status')</th>
											<th scope="col">@lang('Action')</th>
										</tr>

										</thead>
										<tbody id="sortable">
										@if(count($methods) > 0)
											@foreach($methods as $method)
												<tr data-code="{{ $method->code }}">
													<td data-label="@lang('Name')">{{ $method->name }} </td>
													<td data-label="@lang('Status')">

														{!!  $method->status == 1 ? '<span class="badge badge-light"><i class="fa fa-circle text-success font-12"></i> '.trans('Active').'</span>' : '<span class="badge badge-light"><i class="fa fa-circle text-danger font-12"></i> '.trans('DeActive').'</span>' !!}
													</td>

													<td data-label="@lang('Action')">
														<a href="{{ route('admin.deposit.manual.edit', $method->id) }}"
														   class="btn btn-outline-primary btn-circle"
														   data-toggle="tooltip"
														   data-placement="top"
														   data-original-title="@lang('Edit this Payment Methods info')">
															<i class="fa fa-edit"></i></a>

													</td>
												</tr>
											@endforeach
										@else
											<tr>
												<td class="text-center" colspan="8">
													@lang('No Data Found')
												</td>
											</tr>
										@endif
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>

				</div>
			</div>
		</section>
	</div>
@endsection


@push('js')
	<script>
		"use strict";
		$('.disableBtn').on('click', function () {
			var status = $(this).data('status');
			$('.messageShow').text($(this).data('message'));
			var modal = $('#disableModal');
			modal.find('input[name=code]').val($(this).data('code'));
		});
	</script>
@endpush
