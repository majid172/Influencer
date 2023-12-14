@foreach($jobs as $item)
	<div class="job-box" id="data_temp_{{$item->id}}" data-jobId="{{$item->id}}">
		<div class="d-flex ">
			<a href="{{route('user.jobs.details',[slug($item->title),$item->id])}}"
			   class="job-title">{{$item->title}}</a>
		</div>

		<div class="alert-body">
			@if($item->is_active == 0)
				<p class="text-danger">@lang('Job is closed')</p>
			@endif
		</div>

		<div class="reasonText" id="reasonText_{{$item->id}}">
			<p></p>
		</div>

		<div class="collapse show" id="collapseExample_{{$item->id}}">
			<p>@lang('Experience'):
				@if ($item->experience == 1)
					@lang('Entry level')
				@elseif ($item->experience == 2)
					@lang('Intermidiate')
				@elseif ($item->experience == 3)
					@lang('Expert')
				@endif - @lang('Est'). @lang('Budget'):

				@if ($item->start_rate != 0 && $item->end_rate !=0)
					{{$basicControl->currency_symbol}}{{$item->start_rate}} @lang('to')
					{{$basicControl->currency_symbol}}{{$item->end_rate}}
				@else
					{{$basicControl->currency_symbol}}{{$item->fixed_rate}}
				@endif - @lang('Posted') {{diffForHumans($item->created_at)}}</p>

			<p>{{Str::limit($item->description,300)}}
				<a href="{{route('user.jobs.details',[slug($item->title),$item->id])}}">@lang('more')</a>
			</p>
			<div>
				@foreach (explode(',',$item->skill) as $skill)
					<a href="{{route('job.skill.search',$skill)}}" class="tag">{{$skill}}</a>
				@endforeach
			</div>

			<div class="bottom-area mt-3">
				<p>@lang('Proposals'): {{$item->total_proposal}}</p>
				<span><i class="fa-solid fa-certificate"></i> @lang('Payment Verified')</span>
				<span>
			<i class="fa-solid fa-location-dot"></i>
			{{$item->user->profile->getCountry->name}}
			</span>
			</div>
		</div>

		<div class="feedback">
			<div class="dropdown" id="thumbDropdown_{{$item->id}}">
				<a class="dropdown-toggle thumbs{{ $item->id }}" href="#" role="button"
				   id="dropdownMenuLink_{{ $item->id }}" data-bs-toggle="dropdown" aria-expanded="false">
					<i class="fa-light fa-thumbs-down"></i>
				</a>
				<ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuLink_{{ $item->id }}">
					@foreach ($dislike_reasons as $reason)
						<li>
							<a class="dropdown-item reason" data-bs-toggle="collapse"
							   data-reasons="{{__($reason->reasons)}}" data-id="{{$item->id}}"
							   href="#collapseExample_{{$item->id}}" role="button" aria-expanded="true"
							   aria-controls="collapseExample_{{$item->id}}" id="collapsReasonText_{{$item->id}}">
								{{ __($reason->reasons) }}
							</a>
						</li>
					@endforeach
				</ul>
			</div>

			<a class="mt-2 d-none collapse-button" data-bs-toggle="collapse" href="#collapseExample_{{$item->id}}"
			   data-id="{{ $item->id }}" id="collapse-button_{{$item->id}}" role="button" aria-expanded="true"
			   aria-controls="collapseExample_{{$item->id}}"> @lang('Collapse')
			</a>

		</div>
	</div>

@endforeach

@push('script')
	<script>

		$(document).ready(function () {

			var jobBoxes = $(".job-box");
			jobBoxes.each(function () {
				var jobId = $(this).data("jobid");
				checkExpand(jobId)
			});
		});

		var reasonValue = '';

		$(document).on('click', '.reason', function () {
			var reason = $(this).data('reasons');
			var jobId = $(this).data('id');
			var collapseButton = $('#collapse-button_' + jobId);

			$('#reasonText_' + jobId).find('p').text(reason);

			// Save reason in sessionStorage
			reasonValue = reason;

			let existingData = getFromLocalStorage('expandedJob') ?? [];
			existingData.push({jobId: jobId, reason: reason});
			addToLocalStorage('expandedJob', existingData);


			if (collapseButton.html() == 'Expand') {
				collapseButton.html('Collapse');
				collapseButton.addClass('d-none');
				$('.thumbs' + jobId).addClass('d-none');
				return 0;
			} else {
				collapseButton.html('Expand');
				collapseButton.removeClass('d-none');
				$('.thumbs' + jobId).addClass('d-none');
				return 0;
			}
		});

		$(document).on('click', '.collapse-button', function () {
			var jobId = $(this).data('id');

			var collapseButton = $('#collapse-button_' + jobId);
			var collapseId = $(`#collapseId_${jobId}`);
			var reasonText = $(`#reasonText_${jobId} p`);

			var feedbackDropdown = collapseId.siblings('.feedback').find('.dropdown');

			if (collapseButton.html() == 'Expand') {
				collapseButton.html('Collapse');
				// Clear all text
				reasonText.text('');
				feedbackDropdown.removeClass('d-none');
				collapseId.collapse('show');
			} else {
				collapseButton.html('Expand');
				var reason_Value = reasonValue;
				reasonText.text(reason_Value);
				feedbackDropdown.addClass('d-none');
				collapseId.collapse('hide');
				checkExpand(jobId)

			}
		});

		function checkExpand(id) {
			var collapseButton = $('#collapse-button_' + id);
			let existingData = getFromLocalStorage('expandedJob') ?? [];
			const findJob = existingData.find(item => item.jobId == id);
			if(findJob){
				collapseButton.removeClass('d-none');
				collapseButton.html('Expand');
				$('.thumbs' + id).addClass('d-none');
				$('#collapseExample_'+id).removeClass('show')
				$('#reasonText_'+id).removeClass('d-none')
				$('#reasonText_'+id).html(`<p>${findJob.reason}</p>`)
			}
		}

		function addToLocalStorage(key, value) {
		const findData = getFromLocalStorage(key)
			if (findData){
			}
			const data = JSON.stringify(value);
			localStorage.setItem(key, data);
		}

		function getFromLocalStorage(key) {
			$data = localStorage.getItem(key)
			return JSON.parse($data);
		}


	</script>
@endpush


