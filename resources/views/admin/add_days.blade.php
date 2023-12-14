@extends('admin.layouts.master')
@section('page_title',__('Add Days'))

@section('content')
	<div class="main-content">
		<section class="section">
			<div class="section-header">
				<h1>@lang('Manage Days')</h1>
				<div class="section-header-breadcrumb">
					<div class="breadcrumb-item active">
						<a href="{{route('admin.home')}}">@lang('Dashboard')</a>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-12">
					<div class="card card-primary shadow">
						<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
							<h6 class="m-0 font-weight-bold text-primary">@lang('Add days for update balance')</h6>
							<div class="media mb-4 float-right">


							</div>
						</div>

						<div class="card-body">
							<div class="table-responsive">
								<table class="table table-striped table-hover align-items-center table-borderless" id="category-table">
									<thead>
									<tr>
										<th data-label="@lang('SL')">@lang('SL')</th>
										<th data-label="@lang('Days')">@lang('Days')</th>
										<th data-label="@lang('Action')">@lang('Action')</th>
									</tr>
									</thead>
									<tbody>

									<tr>
										<td data-label = "@lang('SL')">@lang('1')</td>
										<td data-label = "@lang('Days')">{{$day->days}}</td>
										<td data-label = "@lang('Action')">
											<button type="button" class="btn btn-sm btn-outline-primary mr-2" data-toggle="modal" data-target="#exampleModalCenter" ><span><i class="fa fa-pencil"></i>@lang('Update')</span>
											</button>
										</td>
									</tr>

									</tbody>
								</table>
							</div>
						</div>



					</div>
				</div>

		</section>
	</div>



	{{-- add modal --}}
	<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLongTitle">@lang('Update Days')</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form action="{{route('admin.addDay.update')}}" method="POST">
					@csrf
					<div class="modal-body">
						<label for="reason">@lang('Days')</label>
						<input type="text" name="days" value="{{$day->days}}" id="reason" class="form-control">
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-primary">@lang('Change')</button>
					</div>
				</form>
			</div>
		</div>
	</div>
@endsection

@section('scripts')

@endsection
