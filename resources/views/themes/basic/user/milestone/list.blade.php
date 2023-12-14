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
					<th>@lang('File')</th>
					<th>@lang('Budget')</th>
					@if ($hasEscrowAmount)
						<th>@lang('Escrow amount')</th>
					@endif
					<th>@lang('Paid')</th>
					<th>@lang('Status')</th>
					<th>@lang('Action')</th>
				</tr>
				</thead>

				<tbody>
				@forelse($escrows as $key => $item)
					<tr>
						<td class="p-3" data-label="@lang('File')">
							@if($item->project_file)
								{{$item->file_name}}
							@else
								@lang('No File')
							@endif
						</td>

						<td data-label="@lang('Rate')"> {{__($item->budget)}} {{basicControl()->base_currency}}</td>
						@if ($hasEscrowAmount)
							<td data-label="@lang('Escrow amount')">{{ $item->escrow_amount }} {{ basicControl()->base_currency }}</td>
						@endif
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
								@if(optional($item->hire)->client_id == auth()->user()->id )
									@if(($item->payment_status == 1) && ($item->project_file == true ))
										<a href="{{route('user.completed',optional($item->hire)->job_id)}}" class="btn-action upload mx-2`" type="button" data-bs-toggle="tooltip"  data-bs-placement="top" data-bs-original-title="@lang('All processes are complete. Now the job is closed by clicking this button.')"><i class="fas fa-check-circle"></i> @lang('Complete') </a>

										<a href="{{getFile($item->driver,$item->project_file)}}" download class="btn-action text-light mx-2"  type="button" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="@lang('Download your project')" id="icon"><i class="fa-light fa-cloud-arrow-down me-2"></i>@lang('Download')</a>

									@elseif($item->payment_status == 0)
										<a href="javascript:void(0)" class="btn-action text-light pay" data-bs-toggle="modal" data-bs-target="#payModal" data-client_id ="{{optional($item->hire)->client_id}}" data-id="{{$item->id}}" @if($hasEscrowAmount) data-amount="{{$item->escrow_amount}}" @else  data-amount="{{$item->budget}}" @endif data-proposser = "{{__(optional($item->hire)->proposser->id)}}" data-proposal_id="{{optional($item->hire)->proposal->id}}" data-bs-placement="top" data-bs-original-title="@lang('Payment process complete by clicking button')">
											<i class="fa-solid fa-wallet me-2"></i>@lang('Pay')
										</a>

									@elseif(empty($item->project_file))
										<a href="javascript:void(0)" class="btn-action text-light"  type="button" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="@lang('Influencer is not a complete project file yet.')" data-bs-toggle="modal" data-bs-target="#emptyModal"><i class="fa-solid fa-empty-set me-2" id="icon"></i>@lang('Empty File')</a>
									@endif

								@elseif(optional($item->hire)->proposser_id == auth()->user()->id)
									@if($item->payment_date > $cur_date)
										@dd('69')
										<a href="javascript:void(0)" class="btn-action fileUpload " data-bs-toggle="modal"  data-bs-target="#fileModal" data-route="{{route('user.escrow.file.submit',$item->id)}}" data-id="{{$item->id}}" data-job_title="{{__(optional(optional($item->hire)->job)->title)}}"  data-job_description="{{__(optional(optional($item->hire)->job)->description)}}">
											<i class="fa-thin fa-folder-arrow-up"></i>
										</a>
									@else
										@if(($item->paid > 0) && ($item->project_file))
											@if(optional(optional($item->hire)->job)->status == 2)

												<a href="javascript:void(0)" class="btn-action text-light completed"  type="button" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="@lang('Job is successfully completed')"><i class="fa-thin fa-circle-check bg-success me-2" id="icon"></i>@lang('Completed')</a>
											@else
												<a href="{{ route('user.job.completed',optional($item->hire)->job_id) }}" class="btn-action text-light dispatch"  type="button" data-bs-toggle="tooltip" data-job_id="{{optional($item->hire)->job_id}}" data-bs-placement="top"><i class="fa-thin fa-ballot-check me-2 bg-success" id="icon"></i> @lang('Complete')</a>
											@endif

										@elseif(($item->project_file) && ($item->paid == 0))
											<a href="javascript:void(0)" class="btn-action text-light"  type="button" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="@lang('If you have not gotten your payment, your balance will be updated within 5 days.')"><i class="fa-sharp fa-solid fa-money-check-dollar me-2" id="icon"></i> @lang('Due Payment')</a>

										@elseif(empty($item->project_file))
											<a href="javascript:void(0)" class="btn-action text-light"  type="button" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="@lang('The project has not been submitted yet.')"><i class="fa-solid fa-clock me-2" id="icon"></i>@lang('Expired')</a>

										@endif
									@endif
								@endif
							</div>
						</td>
					</tr>
				@empty
					<tr>
						<th colspan="100%" class="text-center">
							<img src="{{asset($themeTrue.'images/no-data.png')}}" alt="@lang('no-data')" class="no-data-img"> <br>@lang('No data found')</th>
					</tr>
				@endforelse
				</tbody>

			</table>
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
					<input type="hidden" name="escrow_id">
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



	<div class="modal fade" id="payModal" tabindex="-1" aria-labelledby="payModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="payModalLabel">@lang('Payment')</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<form action="{{route('user.job.payment')}}" method="get" class="payAction">
					@csrf
					<div class="modal-body">
						<input type="hidden" name="proposser_id">
						<input type="hidden" name="client_id">
						<input type="hidden" name="proposal_id">
						<input type="hidden" name="id">
						<input type="hidden" name="amount">
						<label for="payment">@lang('Select payment method')</label>
						<select name="payment_method" id="payment_method" class="form-select js-example-basic-multiple-limit">
							<option value="">@lang('Choose your option')</option>
							<option value="1" > @lang('Wallet')</option>
							<option value="2"> @lang('Checkout')</option>
						</select>
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-primary ">@lang('Submit')</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<div class="modal fade" id="emptyModal" tabindex="-1" aria-labelledby="emptyModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="emptyModalLabel">Modal title</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					...
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
					<button type="button" class="btn btn-primary">Save changes</button>
				</div>
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

		$('.pay').on('click',function (){
			let modal = $('#payModal');
			let proposser_id = $(this).attr('data-proposser');
			let id = $(this).data('id');
			let client_id = $(this).attr('data-client_id');
			let amount = $(this).attr('data-amount');
			let proposal_id = $(this).attr('data-proposal_id');

			$('#payment_method').on('change',function (){
				let choose_method = $(this).val();
				if(choose_method == 1)
				{
					modal.find('input[name="id"]').val(id);
					modal.find('input[name="client_id"]').val(client_id);
					modal.find('input[name="proposser_id"]').val(proposser_id);
					modal.find('input[name="proposal_id"]').val(proposal_id);
					modal.find('input[name="amount"]').val(amount);
				}
				if(choose_method == 2)
				{
					modal.find('input[name="id"]').val(id);
					modal.find('input[name="client_id"]').val(client_id);
					modal.find('input[name="proposser_id"]').val(proposser_id);
					modal.find('input[name="proposal_id"]').val(proposal_id);
					modal.find('input[name="amount"]').val(amount);
				}
			});
			modal.show();
		});
	</script>
@endpush
