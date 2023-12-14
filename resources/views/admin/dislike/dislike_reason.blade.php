@extends('admin.layouts.master')
@section('page_title',__('Dislike Reason'))

@section('content')
<div class="main-content">
	<section class="section">
		<div class="section-header">
			<h1>@lang('Dislike Reason')</h1>
			<div class="section-header-breadcrumb">
				<div class="breadcrumb-item active">
					<a href="{{route('admin.home')}}">@lang('Dashboard')</a>
				</div>
				<div class="breadcrumb-item">@lang('Dislike Reason')</div>
			</div>
		</div>

		<div class="row">
			<div class="col-12">
				<div class="card card-primary shadow">
					<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
						<h6 class="m-0 font-weight-bold text-primary">@lang('Dislike Reason')</h6>
						<div class="media mb-4 float-right">

							<button type="button" class="btn btn-sm btn-outline-primary mr-2" data-toggle="modal" data-target="#exampleModalCenter"><span><i class="fa fa-plus-circle"></i>@lang('Add New')</span>
							</button>
						</div>
					</div>

					<div class="card-body">
						<div class="table-responsive">
							<table class="table table-striped table-hover align-items-center table-borderless" id="category-table">
								<thead>
									<tr>
										<th data-label="@lang('SL')">@lang('SL')</th>
										<th data-label="@lang('Reasons')">@lang('Reasons')</th>
										<th data-label="@lang('Action')">@lang('Action')</th>
									</tr>
								</thead>
								<tbody>

									@forelse($reasons as $item)
									<tr>
										<td data-label="@lang('SL No.')">{{$loop->index+1}}</td>
										<td data-lable="@lang('Reasons')">{{__($item->reasons)}}</td>

										<td data-label="@lang('Edit')">
											<a href="{{route('admin.jobs.dislike.edit',$item->id)}}" class="btn btn-outline-primary btn-rounded btn-sm" ><span><i class="fa fa-pen pr-1"></i>@lang('Edit')</span>
											</a>

											<a href="{{route('admin.jobs.dislike.reason.remove',$item->id)}}" class="btn btn-outline-danger btn-rounded btn-sm"><i class="fa fa-trash pr-1"></i>@lang('Delete')</a>
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

	</section>
</div>



{{-- add modal --}}
  <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
	  <div class="modal-content">
		<div class="modal-header">
		  <h5 class="modal-title" id="exampleModalLongTitle">@lang('Reason Store')</h5>
		  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		  </button>
		</div>
		<form action="{{route('admin.jobs.dislike.reason.store')}}" method="POST">
			@csrf
			<div class="modal-body">
				<label for="reason">@lang('Reason')</label>
				<input type="text" name="reason" id="reason" class="form-control">
			  </div>
			  <div class="modal-footer">

				<button type="submit" class="btn btn-primary">@lang('Save')</button>
			  </div>
		</form>
	  </div>
	</div>
  </div>
@endsection

@section('scripts')

@endsection
