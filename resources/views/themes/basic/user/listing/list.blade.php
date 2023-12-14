@extends($theme.'layouts.user')
@section('title',__('Listing Lists'))

@section('content')
	<div class="col-xl-9 col-lg-8 col-md-12">
		<div class="d-flex flex-row justify-content-between">
			<h4>@lang('Listing Lists')</h4>
			<a href="{{route('user.listing.create')}}" class="btn-action text-white">
				<i class="fal fa-plus-circle"></i> @lang('Create Listing')
			</a>
		</div>
		<!-- table -->
		<div class="table-parent table-responsive">
			<table class="table table-striped">
				<thead>
					<tr>
						<th>@lang('Title')</th>
						<th>@lang('Category')</th>
						<th>@lang('Sub Category')</th>
						<th>@lang('Total Sell')</th>
						<th>@lang('Status')</th>
						<th class="text-center">@lang('Action')</th>
					</tr>
				</thead>

				<tbody>
					@forelse($listings as $key => $listing)
						<tr>
							<td data-label="@lang('Title')">
								<a href="{{route('user.listing.details',['slug'=>$listing->title,'id'=>$listing->id])}}">@lang(\Illuminate\Support\Str::limit($listing->title,30))</a>
							</td>
							<td data-label="@lang('Category')">
								@lang(optional(optional($listing->category)->details)->name)
							</td>
							<td data-label="@lang('Sub Category')">
								@lang(optional(optional($listing->subCategory)->details)->name ?? 'N/A')
							</td>

							<td data-label="@lang('Total Sell')">{{$listing->total_sell}}</td>


							<td data-label="@lang('Status')">
								@if($listing->status == 0)
									<span class="badge badge-warning">@lang('Pending')</span>
								@elseif($listing->status == 1)
									<span class="badge badge-primary">@lang('Approved')</span>
								@elseif($listing->status == 2)
									<span class="badge badge-danger">@lang('Canceled')</span>
								@endif
							</td>
							<td data-label="@lang('Action')" class="actionButtonsCenter">
								<a href="{{ route('user.listing.edit', $listing->id) }}" class="btn-action-icon bg-success me-2">
									<i class="fal fa-edit"></i>
								</a>

								<button class="btn-action-icon bg-danger deleteItem "
									data-bs-toggle="modal"
									data-bs-target="#delete-modal"
									data-route="{{route('user.listing.delete', $listing->id)}}">
									<i class="fal fa-trash"></i>
								</button>
							</td>
						</tr>
					@empty
						<tr>

							<th colspan="100%" class="text-center">
								<img src="{{asset($themeTrue.'images/no-data.png')}}" alt="@lang('no-data')" class="no-data-img"> <br>
								@lang('No Data Found')</th>
						</tr>
					@endforelse
				</tbody>
			</table>
		</div>
		<div class="">
			{{ $listings->links() }}
		</div>
	</div>

	<!--- Delete Modal ---->
	<div id="delete-modal" class="modal fade" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog modal-md">
			<div class="modal-content form-block">
				<div class="modal-header">
					<h5 class="modal-title">@lang('Delete Confirmation')</h5>
					<button type="button" class="close-btn" data-bs-dismiss="modal" aria-label="Close">
						<i class="fal fa-times"></i>
					</button>
				</div>
				<div class="modal-body">
					<p>@lang('Are you sure to delete this?')</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn-action btn-danger" data-bs-dismiss="modal">@lang('Close')</button>
					<form action="" method="post" class="deleteRoute">
						@csrf
						@method('delete')
						<button type="submit" class="btn-action">@lang('Yes')</button>
					</form>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->

@endsection


@push('scripts')
	<script>
		"use strict";
			$(document).on('click', '.editCettification-button', function () {
				$('#editCertificationForm').attr('action', $(this).data('route'))
				$('.name').val($(this).data('name'))
				$('.institution').val($(this).data('institution'))
				$('.start').val($(this).data('start'))
				$('.end').val($(this).data('end'))
			})

			$('.deleteItem').on('click', function () {
				var route = $(this).data('route');
				$('.deleteRoute').attr('action', route)
			})
	</script>
@endpush


