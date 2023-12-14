@foreach ($send_offers as $item)
	<div class="form-box mb-4">
		<h4>{{optional($item->job)->title}}</h4>
		<div class="hire_freelancer">
			<h6>@lang('Freelancer') : {{__(optional($item->proposser)->name)}}</h6>
		</div>

		<div class="job-description mb-1">
			<h6><b>@lang('Job description') </b></h6>
			<p> {{__(optional($item->job)->description)}} </p>
		</div>

		<div class="col-lg-4 col-6">
			<ul>
				<li class="mb-0"><b>@lang('Select project type')</b> -
					@if ($item->pay_type == 1)
						@lang('Hourly')
					@elseif($item->pay_type == 2)
						@lang('Fixed')
					@endif
				</li>

			</ul>
		</div>
		<div class="col-lg-4 col-6">
			<ul>
				<li class="mb-0"><b>@lang('Project rate')</b> - {{$item->rate}} {{basicControl()->base_currency}}</li>
			</ul>
		</div>

		<div class="col-lg-4 col-6">
			<ul>
				<li class="mb-0"><b>@lang('Project duration')</b> -
					{{$item->submit_date}}
				</li>

			</ul>
		</div>

		<div class="col-12 input-box mb-2">
			<h6><b>@lang('Details') </b></h6>
			<p>{{__($item->description)}}</p>
		</div>

		@if ($item->is_hired == 0)
			<button class="btn-action text-warning disabled" data-bs-toggle="modal" data-route="{{route('user.job.accept',$item->job_id)}}" data-bs-target="#acceptModal">
				@lang('Pending')
			</button>
		@elseif($item->is_hired == 1)
			<button class="btn-action disabled text-success" data-bs-toggle="modal" data-route="{{route('user.job.cancel',$item->job_id)}}" >
				@lang('Accepted')
			</button>
		@endif
	</div>
@endforeach
