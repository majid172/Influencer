@extends($theme.'layouts.user')
@section('title',__('Hire Freelencer'))
@section('content')

<div class="col-xl-9 col-lg-8 col-md-12 change-password">
	<div class="form-box">
		<form action="{{route('user.job.hire.store')}}" method="POST">
			@csrf
			<input type="hidden" name="proposser_id" class="form-control" value="{{$proposerId}}">
			<input type="hidden" class="form-control" name="client_id" value="{{auth()->user()->id}}">
			<input type="hidden" class="form-control" name="job_id" value="{{$jobId}}">
			<input type="hidden" class="form-control" name="proposal_id" value="{{$proposalId}}">

			<div class="row justify-content-between g-3 mb-3 mt-3">
				<div class="col-lg-4 col-6">
					<div>
						<p class="mb-0"><b>@lang('Select project type')</b></p>
						<small>@lang('How would you want to get paid as a freelancer?')</small>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-lg-6">
					<div class="card">
						<div class="card-box text-center">
							<i class="fa-light fa-clock"></i>
							<div class="form-check">
								<input class="form-check-input" type="radio" name="pay_type" id="hourly" value="1" checked>
								<label class="form-check-label" for="hourly" >
									<h6>@lang('Pay by the hour')</h6>
								</label>

							</div>
							<p class="justify-content-center">@lang('Pay hourly to increase and decrease scaleability')</p>
						</div>

					</div>
				</div>

				<div class="col-lg-6">
					<div class="card">
						<div class="card-box text-center">
							<i class="fa-regular fa-tags"></i>
							<div class="form-check">
								<input class="form-check-input" type="radio" name="pay_type" id="fixed" value="2">
								<label class="form-check-label" for="fixed">
									<h6>@lang('Pay a fixed price')</h6>
								</label>
							</div>
							<p class="justify-content-center">@lang(' Only pay after the service is completed.')</p>
						</div>

					</div>
				</div>

			</div>


			<div class="row g-3 mb-3 mt-3" id="fixed_rate">
			  	<div class="col-lg-6">
				  <div>
					  <p class="mb-0"><b>@lang('Pay price for your project')</b></p>
					  <small>@lang('Total amount the client will see on your proposal')</small>
				  </div>
			  	</div>

			  	<div class="col-lg-6 input-box">
					<div class="input-group mb-3">
						<input type="number" name="rate"  class="form-control"  value="{{getAmount($proposal->bid_amount)}}" readonly/>
						<span class="input-group-text" id="basic-addon2">{{__($basic->base_currency)}}</span>
					</div>

			  	</div>

			</div>

			<div class="row  g-3 mb-3 mt-3" id="fixed_rate">
				  <div class="col-lg-6">
					  <div>
						  <p class="mb-0"><b>@lang('Submission Date')</b></p>
						  <small>@lang('Project submission deadline')</small>
					  </div>
				  </div>
				  <div class="col-lg-6 input-box">
					  <input class="form-control flatpickr_date" type="text" id="date" value="{{@request()->from_date}}" name="submit_date" placeholder="@lang('From Date')" autocomplete="off"/>
				  </div>
			  </div>

			  <div class="row justify-content-between g-3 mb-3">
				  <div class="col-lg-12 col-sm-12 input-box">
					  <div>
					  <p class="mb-0"><b>@lang('Deposit funds into Escrow') </b></p>
					  <small>@lang('Escrow is a neutral holding place that protects your deposit until work is approved.')</small>
					  </div>
				  </div>

			  </div>

			<div class="row mb-3">
				<div class="col-lg-6">
					<div class="card-box">
						<div class="form-check deposit">
							<input class="form-check-input" type="radio" name="deposit_type" id="fixed_rate" value="1" >
							<label class="form-check-label" for="fixed_rate"><b>@lang('Deposit for the whole project')</b>
							</label>
						</div>
					</div>
				</div>

				<div class="col-lg-6">
					<div class="card-box">
						<div class="form-check milestone">
							<input class="form-check-input" type="radio" name="deposit_type" id="milestone" value="2" >
							<label class="form-check-label" for="milestone">
								<b>@lang('Deposit a smaller amount to cover a first milestone.')</b>
							</label>
						</div>
					</div>
				</div>

			</div>

			<div class="createMilestone mt-3 mb-3">
				<hr>
				<div class="title mb-2">
					<p class="fw-bold mb-0">@lang('Project Milestone')</p>
					<span>@lang('Add project milestone and pay in installment as each milestone is completed to your satisfaction')</span>
				</div>

				<div class="row addMilestone">
					<div class="col-lg-4">
						<div class="milestone_desc input-box">
							<p class="mb-0"><b>@lang('Milestone Description')</b></p>
							<input type="text" id="desc" name="milestone_desc[]" class="form-control" placeholder="@lang('Description')">
						</div>
					</div>

					<div class="col-lg-3">
						<div class="input-box amount">
							<p class="mb-0"><b>@lang('Deposit Amount')</b></p>
							<input type="number" id="amount" name="deposit_amount[]" class="form-control" placeholder="@lang('$5.00')">
						</div>
					</div>

					<div class="col-lg-3">
						<div class="input-box due_date">
							<p class="mb-0"><b>@lang('Payment Date')</b></p>
							<input type="text" id="due_date" name="payment_date[]" class="form-control flatpickr_date">
						</div>
					</div>
				</div>

				<div id="milestoneContainer">
					<!-- Milestone columns will be dynamically added here -->
				</div>
				<a id="addMilestoneBtn" class="btn btn-custom m-2">@lang('Add Milestone')</a>

				<hr>
			</div>

			<div class="row">
				<div class="col-lg-12 input-box mb-2">
					<p class="mb-0"><b>@lang('Description') </b></p>
					<textarea cols="30" rows="10" class="form-control" name="description" ></textarea>
				</div>
			</div>

			  <button type="submit" class="btn btn-primary">@lang('Hire')</button>
		</form>
	</div>
</div>
@endsection


@push('style')
	<link rel="stylesheet" href="{{asset($themeTrue.'css/flatpickr.min.css')}}">
@endpush


@push('extra-js')
	<script src="{{asset($themeTrue.'js/flatpickr.js')}}"></script>
@endpush

@push('scripts')
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
    $(function(){

		$("#hourly_rate").hide();
		$('#pay_type').on('change',function(){
			var pay_type = $(this).val();

			if(pay_type == 1)
			{
				$('#fixed_rate').hide();
				$('#hourly_rate').show();
			}
			elseif(pay_type ==2)
			{
				$("#fixed_rate").show();
				$("#hourly_rate").hide();
			}
		});

		$('.createMilestone').hide();
		$('.milestone').on('click',function (){
			$('.createMilestone').show();

		});
		$('.deposit').on('click',function (){
			$('.createMilestone').hide();
		});

		$("#addMilestoneBtn").on("click", function() {
			createMilestoneColumns();
		});
		function createMilestoneColumns() {
			const newRow = $("<div>").addClass("row addMilestone mt-3");
			newRow.html(`
				<div class="col-lg-4">
				  <div class="mileston_desc input-box">
					<p class="mb-0"><b>@lang('Milestone Description')</b></p>
					<input type="text" name="milestone_desc[]" class="form-control" placeholder="@lang('Description')">
				  </div>
				</div>
				<div class="col-lg-3">
				  <div class="input-box amount">
					<p class="mb-0"><b>@lang('Deposit Amount')</b></p>
					<input type="number" name="deposit_amount[]" class="form-control" placeholder="@lang('$5.00')">
				  </div>
				</div>
				<div class="col-lg-3">
				  <div class="input-box due_date">
					<p class="mb-0"><b>@lang('Payment Date')</b></p>
					<input type="text" name="payment_date[]" class="form-control flatpickr_date">
				  </div>
				</div>

				<div class="col-lg-1">
				  <button type="button" class="btn btn-danger cancelBtn mt-3">Cancel</button>
				</div>
			  `);

			$("#milestoneContainer").append(newRow);

			newRow.find("#due_date").datepicker({
				dateFormat: "dd-mm-yy",
				minDate: new Date(),
				changeMonth: true,
				changeYear: true
			});
		}
		$("#milestoneContainer").on("click", ".cancelBtn", function() {
			$(this).closest(".addMilestone").remove();
		});

	});
	$(function(){
		var today = new Date().toISOString().split('T')[0];
		var dueDate = $("#dueDate");
		dueDate.attr('min',today);
		dueDate.on('input',function(){
			var chooseDate = $(this).val();

			if(chooseDate < new Date(today))
			{
				$(this).val(today);
			}

		});
	});

	$(document).ready(function (){
		$(".flatpickr_date").flatpickr({
			minDate: "today",
			altInput: true,
			altFormat: "d/m/y",
			dateFormat: "Y-m-d",
		});
	});
</script>

@endpush
