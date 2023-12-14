@extends($theme.'layouts.app')
@section('title', trans('Job Proposal'))
@section('content')

	<section class="job-proposal">
		<div class="overlay">
			<div class="container">
				<div class="row g-4 g-lg-5">
					<div class="col-lg-8">
						<div class="form-box">
							<div>
								<h4>@lang('Apply on job')</h4>
								<p>
									@lang('Lorem ipsum dolor sit amet consectetur adipisicing elit. Numquam itaque ab illum
									voluptates mollitia explicabo quod totam assumenda temporibus porro sunt')
								</p>
								<form action="{{route('user.job.proposal.store',[slug($proposal->title),$proposal->id])}}" method="POST" enctype="multipart/form-data">
									@csrf
									<input type="hidden" name="job_id" value="{{$proposal->id}}">
									<div class="row g-lg-5 gy-5">
										<div class="col-12 input-box">
											<label for="">@lang('Cover Letter')</label>
											<textarea cols="30" rows="10" class="form-control" name="cover_letter" ></textarea>
										</div>
										<div class="col-12 input-box">
											<label for="">@lang('Describe your recent experience with similar projects')</label>
											<textarea cols="30" rows="10" class="form-control" name="describe_experience" ></textarea>
										</div>
										<div class="input-box col-12">
											<label for="">@lang('Attachment')</label>
											<ul class="attachment-list list-unstyled" id="file-list">
												<li id="file-preview" class="file-item d-flex">
													<i class="fa-light fa-paperclip "></i>
													<span class="filename">@lang('ex. attachment.file')</span>
													<button class="btn-action-icon remove"><i class="fa-light fa-trash-can"></i></button>
												</li>
											</ul>

											<div class="upload-file mb-2">
												<div class="text-center">
													<i class="fa-light fa-cloud-arrow-up"></i>
													<p class="mb-0">@lang('Drag or upload project files')</p>
												</div>
												<input class="form-control"  name="file" accept="image/*" type="file" id="file" multiple
												/>
											</div>
											<small
											>@lang('You may attach up to files under the size of 25 MB each. Include work samples or
								  other documents to support your application. Do not attach your résumé — your
								  Upwork profile is automatically forwarded to the client with your
								  proposal.')</small
											>
										</div>

										<div class="input-box col-lg-6 col-md-6">
											<label for="">@lang('How long will this project take?')</label>
											<select class="js-example-basic-single form-control" name="duration">
												@foreach ($durations as $item)
													@php
														$duration = ($item->duration)/($item->frequency);
													@endphp

													<option value="{{$item->id}}">
														@if ($item->frequency < 30)
															@lang('Less than 1 month')
														@elseif($item->frequency == 30)
															@if($duration > floor($duration))
																@lang('More than') {{floor($duration)}} @lang('Month\'s')
															@elseif($duration == floor($duration))
																{{floor($duration)}} @lang('Month\'s')
															@endif
														@elseif($item->frequency == 365)
															{{$duration}} @lang('Year')
														@endif
													</option>
												@endforeach

											</select>
										</div>

										<div class="input-box col-lg-6 col-md-6">
											<label>@lang('Daily Limit')</label>
											<input type="text" name="limitation" class="form-control" value="{{auth()->user()->profile->daily_limit}}" readonly>
										</div>

										<div class="input-box col-12">
											<label class="mb-4">@lang('What is the full amount you\'d like to bid for this job?')</label>
											<div class="row justify-content-between g-3 mb-3">
												<div class="col-lg-4 col-6">
													<div>
														<p class="mb-0"><b>@lang('Bid')</b></p>
														<small>@lang('Total amount the client will see on your proposal')</small>
													</div>
												</div>

												<div class="col-lg-4 col-6">
													<div class="input-group mb-3">
														<input type="text" class="form-control" name="bid_amount" id="bid_amount" placeholder="@lang('$5.00')">
														<span class="input-group-text" id="basic-addon2">{{__($basic->base_currency)}}</span>
													</div>
												</div>
											</div>

											<div class="row justify-content-between g-3 mb-3">

												<div class="col-lg-4 col-6">
													<div>
														<p class="mb-0"><b>@lang('Service Fee') (%)</b></p>

													</div>
												</div>
												<div class="col-lg-4 col-6">
													<div class="input-group mb-3">
														<input type="text" class="form-control" name="service_fee" id="service_fee" placeholder="@lang('1.00%')" readonly>
														<span class="input-group-text" id="basic-addon2">@lang('%')</span>
													</div>

												</div>
											</div>
											<div class="row justify-content-between g-3">
												<div class="col-lg-4 col-6">
													<div>
														<p class="mb-0"><b>@lang('You’ll Receive')</b></p>
														<small>@lang('The estimated amount you\'ll receive after service fees')</small>
													</div>
												</div>
												<div class="col-lg-4 col-6">
													<div class="input-group mb-3">
														<input type="text" class="form-control" name="receive_amount" id="receive_amount" placeholder="@lang('$5.00')">
														<span class="input-group-text" id="basic-addon2">{{__($basic->base_currency)}}</span>
													</div>

												</div>
											</div>
										</div>

										@if (auth()->user()->profile->daily_limit > 0)
											<div class="col-12 text-end">
												<button type="submit" class="btn-custom">@lang('Send Proposal')</button>
											</div>
										@endif

									</div>
								</form>
							</div>
						</div>
					</div>

					<!-- side bar start -->
					<div class="col-lg-4">
						<div class="side-bar">
							<div class="side-box">
								<div class="job-short-info">
									<a href="{{route('user.jobs.details',[slug($proposal->title),$proposal->id])}}" class="job-title"
									>{{$proposal->title}}</a
									>
									<p>
										@if ($proposal->experience == 1)
											@lang('Entry level')
										@elseif ($proposal->experience == 2)
											@lang('Intermidiate level')
										@elseif ($proposal->experience == 3)
											@lang('Expert level')
										@endif
										- @lang('Est. Budget'):
										@if ($proposal->job_type == 1)
											{{basicControl()->currency_symbol}} {{$proposal->start_rate}} @lang('to') {{basicControl()->currency_symbol}} {{$proposal->end_rate}}
										@elseif($proposal->job_type == 2)
											{{basicControl()->currency_symbol}} {{$proposal->fixed_rate}}
										@endif - @lang('Posted') {{diffForHumans($proposal->created_at)}}</p>

									<div class="author-info">
										<h5>@lang('About the client')</h5>
										<ul>
											<b><i class="fa-sharp fa-regular fa-location-dot"></i> {{$creator_location->profile->getCountry->name}} </b>

											<li><i class="fa-light fa-money-check-dollar"></i> <b> {{__($totalPost)}} @lang('Jobs posted')</b> - {{__($running)}} @lang('running project') @if ($completed > 0) ,
												{{__($completed)}} @lang('completed project')
												@endif

											</li>
											<li><i class="fa-light fa-envelope"></i>
												@if (auth()->user()->email_verification)
													@lang('Email Verified')
												@else @lang('Email Unverified')
												@endif
											</li>
											<li><i class="fa-light fa-user-check"></i> @lang('Profile Completed')</li>
										</ul>
									</div>
									<div><small>@lang('Member since') {{dateTime($proposal->user->created_at)}}</small></div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

	</section>
@endsection

@push('script')
	<script>
		"use strict";

		$('input[name="bid_amount"]').on('input', function() {
			var bid_amount = $(this).val();
			if (bid_amount === "") {
				$('input[name="service_fee"]').val('');
				return;
			}

			$.ajax({
				url: '{{ route("user.job.service.fee") }}',
				type: "GET",
				data: {
					bid_amount: bid_amount,
				},
				success: function(response) {
					$('input[name="service_fee"]').val(response.percentage);
					calculateReceiveAmount();

				},
				error: function(xhr, status, error) {
				}
			});
		});

		function calculateReceiveAmount() {
			var bid_amount = $('input[name="bid_amount"]').val();
			var service_fee = $('input[name="service_fee"]').val();

			if (bid_amount === "" || bid_amount <= 0) {
				$('input[name="receive_amount"]').val(0);
			} else {
				var receive_amount = (bid_amount) - ((bid_amount) * (service_fee/ 100) );
				// var receive_amount = parseFloat(bid_amount) - (parseFloat(bid_amount) * parseFloat(service_fee) / 100);
				if (!isNaN(receive_amount)) {
					$('input[name="receive_amount"]').val(receive_amount.toFixed(2));
				}
			}
		}

		$('#file').change(function() {

			var files = $(this)[0].files;
			$('#file-list').empty();

			for (var i = 0; i < files.length; i++) {
				var file = files[i];
				var listItem = $('<li class="file-item"></li>');
				listItem.text(file.name);
				var removeButton = $('<button class="btn-action-icon remove"><i class="fa-light fa-trash-can"></i></button>');
				removeButton.click(function() {

					$(this).parent().remove();
				});
				listItem.append(removeButton);

				$('#file-list').append(listItem);
			}
		});
	</script>

@endpush


