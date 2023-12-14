@extends($theme.'layouts.user')
@section('title',__('Escrow List'))
@section('content')
	<div class="col-xl-9 col-lg-8 col-md-12">
		<div class="d-flex flex-row justify-content-between">
			<h4>@lang('Milestone Lists')</h4>

		</div>
		<!-- table -->
		<div class="table-parent table-responsive">
			<table class="table table-striped">
				<thead>
				<tr>
					<th>@lang('SL')</th>
					<th>@lang('File')</th>
					<th>@lang('Budget')</th>
					<th>@lang('Paid')</th>
					<th>@lang('Status')</th>
					<th>@lang('Action')</th>
				</tr>
				</thead>

				<tbody>
				@forelse($escrows as $key => $item)
					<tr>
						<td data-label = "@lang('SL')">{{++$key }}</td>
						<td data-label="@lang('File')">
							@if($item->project_file)
								<a href="{{getFile($item->driver,$item->project_file)}}" target="_blank" download>{{$item->file_name}}</a>
							@else
								@lang('No file')
							@endif
						</td>

						<td data-label="@lang('Rate')"> {{__($item->budget)}} {{basicControl()->base_currency}}</td>
						<td data-label="@lang('Paid')">{{$item->paid}} {{basicControl()->base_currency}}</td>

						<td data-label="@lang('Status')">
							@if(@$item->payment_status == 1)
								<span class="badge bg-success">@lang('Paid')</span>
							@else
								<span class="badge bg-danger">@lang('Unpaid')</span>
							@endif
						</td>

						<td data-label="@lang('Action')">
							<div class="d-flex ">
								@if(optional($item->hire)->client_id == auth()->user()->id)
									<a href="javascript:void(0)" class="btn-action " data-id="{{$item->id}}" >
										<i class="fa-solid fa-wallet me-2"></i>@lang('Pay')
									</a>
								@elseif(optional($item->hire)->proposser_id == auth()->user()->id)
									@if($item->payment_date > $cur_date)
										<a href="javascript:void(0)" title="@lang('Upload File')" class="btn-action-icon bg-primary upload me-2 fileUpload " data-id="{{$item->id}}" data-bs-toggle="modal"  data-bs-target="#fileModal" data-route="{{route('user.escrow.file.submit',$item->id)}}" data-id="{{$item->id}}" data-job_title="{{__(@$item->hire->job->title)}}"  data-job_description="{{__(optional(optional($item->hire)->job)->description)}}">
											<i class="fa-thin fa-folder-arrow-up"></i>
										</a>
									@else
										@if(($item->project_file) && (empty($item->paid)))
											<a href="javascript:void(0)" class="btn-action-icon bg-primary " title="Due"><i class="fa-solid fa-wallet"></i></a>
										@elseif(empty($item->project_file))
											<a href="javascript:void(0)" class="btn-action-icon bg-primary" title="Incomplete" disabled> <i class="fa-solid fa-transporter-empty"></i></a>
										@endif
									@endif

									@if(($item->paid) && ($item->project_file))
										@if(optional(optional($item->hire)->job)->status == 2)
											<button class="btn-action completed" title='@lang('Completed')'><i class="fa-regular fa-square-check"></i> </button>
										@else
										<a href="{{ route('user.job.completed',['job_id' => optional($item->hire)->job_id]) }}" title="@lang('Complete')" class="btn-action-icon bg-success dispatch " data-job_id="{{(optional($item->hire)->job_id}}"> <i class="fa-light fa-ballot-check"></i> </a>
										@endif
									@endif

								@endif
							</div>
						</td>
					</tr>
				@empty
					<th colspan="100%" class="text-center">
						<img src="{{asset($themeTrue.'images/no-data.png')}}" alt="@lang('no-data')" class="no-data-img"> <br>
						@lang('No data found')</th>
				@endforelse
				</tbody>

			</table>
		</div>
		<div class="row">
			<div class="col-12">
				{{$escrows->links()}}
			</div>
		</div>
	</div>

	<div class="modal fade" id="fileModal" tabindex="-1" aria-labelledby="fileModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="fileModalLabel">@lang('Order submission')</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<form action="" method="POST" enctype="multipart/form-data" class="submit">
					@csrf
					<input type="hidden" name="escrow_id"></input>

					<div class="modal-body">
						<div class="title">
							<h5></h5>
						</div>

						<div class="input-box col-12">
							<label for="">@lang('Submit here')</label>
							<div class="upload-file mb-2">
								<div class="text-center">
									<i class="fa-light fa-cloud-arrow-up"></i>
									<p class="mb-0">@lang('Drag or upload project files')</p>
								</div>
								<input class="form-control"  name="file" type="file" id="file" multiple
								/>
							</div>
						</div>

						<div class="description">
							<b>@lang('Description')</b>
							<p></p>
						</div>
					</div>
					<div class="modal-footer">

						<button type="submit" class="btn btn-primary">@lang('Submit')</button>
					</div>
				</form>
			</div>
		</div>
	</div>


@endsection

@push('scripts')
	<script>
		$('.fileUpload').on('click',function (){
			let modal = $('#fileModal');
			let escrow_id = $(this).data('id')
			let title = $(this).attr('data-job_title');
			let description= $(this).attr('data-job_description');
			var url = $(this).data('route');

			modal.find('input[name="escrow_id"]').val(escrow_id);
			modal.find('.title h5').html(title);
			modal.find('.description p').html(description);
			modal.show();
			$('.submit').attr("action",url);

		});




	</script>
@endpush
