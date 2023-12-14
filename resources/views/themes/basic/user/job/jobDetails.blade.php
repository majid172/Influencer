@extends($theme.'layouts.app')
@section('title',__('Job Details'))
@section('content')

<section class="job-details">
	<div class="overlay">
		<div class="container">
			<div class="row g-4 g-lg-5">
				<div class="col-lg-8">
				<div class="job-description">
					<div class="job-box">

							<a href="{{route('user.jobs.details',[slug($jobDetails->title),$jobDetails->id])}}" class="job-title">{{$jobDetails->title}}</a>

						<p>@lang('Scope') -
						@if ($jobDetails->scope == 1)
							@lang('Small')
						@elseif($jobDetails->scope == 2)
							@lang('Medium')
						@elseif($jobDetails->scope == 3)
							@lang('Large')
						@endif
						- @lang('Est'). @lang('Budget'):
						@if (($jobDetails->start_rate != 0) && ($jobDetails->end_rate != 0))
							{{basicControl()->currency_symbol}} {{$jobDetails->start_rate}} @lang('to') {{basicControl()->currency_symbol}} {{$jobDetails->end_rate}}
						@else
							{{basicControl()->currency_symbol}} {{$jobDetails->fixed_rate}}
						@endif - @lang('Posted') {{diffForHumans($jobDetails->created_at)}}</p>
					<p>
						<div class="bottom-area mt-3">
							<p>@lang('Proposals'): {{$jobDetails->total_proposal}}</p>
							<span><i class="fa-solid fa-certificate"></i> @lang('Payment Verified')</span>

							<span>
							<i class="fa-solid fa-location-dot"></i>
							{{$creator_location->profile->getCountry->name}}
							</span>
						</div>
					</div>
					<div class="mt-5">
						<h4>@lang('Job details')</h4>
						<p>
							{{$jobDetails->description}}
						</p>

					</div>
					<div class="mt-4">
						<h5>@lang('Need to know')</h5>
						<ul>
						@foreach (json_decode($jobDetails->requirements) as $requirement)
						<li>{{$requirement}}</li>
						@endforeach

						</ul>

					</div>
					<div class="mt-5">
						<div class="row g-3">
							<div class="col-md-6 col-lg-4">
							<h6><i class="fa-light fa-head-side-brain"></i>
								@if ($jobDetails->experience == 1)
									@lang('Entry')
								@elseif ($jobDetails->experience == 2)
									@lang('Intermidiate')
								@elseif ($jobDetails->experience == 3)
									@lang('Expert')
								@endif
							</h6>

							</div>
							<div class="col-md-6 col-lg-4">
							<h6> <i class="fa-light fa-clock"></i> @lang('Type') -
								<span>@if ($jobDetails->job_type == 1) @lang('Hourly')
									@elseif ($jobDetails->job_type == 2) @lang('Project wise')
									@endif</span>
							</h6>
							</div>
							<div class="col-md-6 col-lg-4">
							<h6><i class="fa-light fa-calendar-range"></i>
								@if ($jobDetails->duration > 30)
									@lang('More than') {{ floor($jobDetails->duration / 30) }}  @lang('month project')
								@else
								{{$jobDetails->duration}} @lang('day\'s project')
								@endif
								</h6>
							<p>@lang('Project Length')</p>
							</div>
							<div class="col-md-6 col-lg-4">

							@if ($jobDetails->job_type == 1)
								<h6><i class="fa-light fa-hourglass-start"></i> {{basicControl()->currency_symbol}} {{$jobDetails->start_rate}} - {{$jobDetails->end_rate}}</h6>
								<p>@lang('Hourly Rate')</p>
							@elseif ($jobDetails->job_type == 2)
								<h6><i class="fa-light fa-hourglass-start"></i> {{basicControl()->currency_symbol}} {{$jobDetails->fixed_rate}}</h6>
								<p>@lang('Project wise')</p>
							@endif

							</div>
						</div>
					</div>
					<div class="mt-4">
						<h5>@lang('Skills and Expertise')</h5>

						@foreach (explode(',',$jobDetails->skill) as $item)
						<a href="{{route('job.skill.search',$item)}}" class="tag">{{$item}}</a>
						@endforeach
					</div>

					<div class="col-md-6 form-group mt-4">
					<h5>@lang('Attachment')</h5>
					<a href="{{getFile($jobDetails->driver,$jobDetails->attachment)}}" target="_blank" download>{{$jobDetails->attachment_name}}</a>
					</div>

					<div class="mt-4">
						<h5>@lang('Activity on this job')</h5>
						<p class="mb-1 d-flex">@lang('Interviewing'): <span class="mx-2"> {{$interview}} </span></p>
						<p class="mb-1 d-flex">@lang('Invites sent'): <span class="mx-2"> {{$total_invite}} </span></p>
						<p class="mb-1 d-flex">@lang('Unanswered invites'): <span class="mx-2">{{$unanswer_invite}}</span></p>
					</div>
					<div class="mt-4">
						<h5>@lang('Note'):</h5>
						<p>
						{{$jobDetails->note}}
						</p>
					</div>
				</div>
				<div class="card-box mt-4">
					<h5>@lang('Other open jobs by this Client') ({{$relatedJobsCount}})</h5>
					@foreach ($showRelatedJobs as $item)
					<div class="open-job">
						<a href="{{route('user.jobs.details',[slug($item->title),$item->id])}}">{{$item->title}} </a>
						<span>
							@if ($item->job_type == 1)
								@lang('Hourly')
							@elseif($item->job_type == 2)
								@lang('Project')
							@endif
						</span>
					</div>
					@endforeach

				</div>
				</div>

				<!-- side bar start -->
				<div class="col-lg-4">
				<div class="side-bar">
					<div class="side-box">
					@if($jobDetails->is_active ==1 )
						@if($exists)
							<button  class="btn-custom w-100 disabled">@lang('Applied')</button>
							<a href="{{route('user.jobs.save',$jobDetails->id)}}" class="btn-custom w-100 my-3">
								<i class="fa-light fa-heart"></i> @lang('Save Job')
							</a>
						@elseif(($jobDetails->creator_id != auth()->user()->id) && ($jobDetails->is_hired == 0))
							<a href="{{route('user.job.proposal',[slug($jobDetails->title),$jobDetails->id])}}" class="btn-custom bg-success w-100">@lang('Apply Now')</a>
							<a href="{{route('user.jobs.save',$jobDetails->id)}}" class="btn-custom w-100 my-3">
								<i class="fa-light fa-heart"></i> @lang('Save Job')
							</a>

						@endif
					@else
						<button  class="btn-custom w-100 mb-2">@lang('Job Closed')</button>
					@endif

					<p>@lang('Available limitation'): {{__($user_profile->daily_limit)}}</p>

						<hr />
						<div class="author-info">
							<h5>@lang('About the client')</h5>
							<p>
							@lang('Payment method not verified')
							<button type="button" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Give details, but don’t include your personal contact info."
							>
								<i class="fad fa-info-circle"></i>
							</button>
							</p>
							<ul>
							<b><i class="fa-sharp fa-regular fa-location-dot"></i> {{$creator_location->profile->getCountry->name}} </b>
							<li><i class="fa-light fa-money-check-dollar"></i> <b> {{__($totalPost)}} @lang('Jobs posted')</b> - {{__($running)}} @lang('running project') @if ($completed > 0) ,
								{{__($completed)}} @lang('completed project')
							@endif

							</li>
							<li><i class="fa-light fa-envelope"></i>
								@if (auth()->user()->email_verification)
									@lang('Email Verified')
								@else
									@lang('Email Unverified')
								@endif

							</li>

							</ul>
						</div>
						<div><small>@lang('Member since') {{dateTime($jobDetails->user->created_at)}}</small></div>
						<hr />
						<div>
							<h5>@lang('Job Link')</h5>
							<input type="text" value="{{$url}}" id="jobLink" readonly/>
							<button id="copyBtn" onclick="copyFunction('jobLink')" class="btn-custom-outline copytext"><i
									class="fa fa-copy"></i> @lang('Copy Link')</button>
						</div>
					</div>
				</div>
				</div>
			</div>
		</div>
	</div>
</section>

@endsection

@push('scripts')
	<script>

		function copyFunction() {
		var copyText = document.getElementById("jobLink");
		copyText.select();
		copyText.setSelectionRange(0, 99999);
		document.execCommand("copy");
		Notiflix.Notify.Success(`Copied: ${copyText.value}`);
	   }
	</script>

@endpush
