@extends($theme.'layouts.user')
@section('title', trans('Proposal Details'))
@section('content')

<div class="col-xl-9 col-lg-8 col-md-12 change-password">
	<div class="form-box">
			<div class="row">
				<div class="col-md-8">
					<h3 class="text-primary">{{$details->proposer->name}}</h3>
					<div class="row">
						<p> <strong>@lang('Earned'): </strong>  {{basicControl()->currency_symbol}} {{getAmount($details->proposer->balance)}}</p>
					</div>
					<p>
					<i class="fa-solid fa-location-dot"></i>
					{{$details->proposer->profile->getCountry->name}}</p>
				</div>

				<div class="col-md-4 text-md-end">

					<a class="btn-custom  " href="{{route('user.job.hire',[$details->proposer->id, $details->job_id,$details->id])}}">@lang('Hire Freelencer')</a>
				</div>
			</div>
			<hr>
			<div class="d-flex">
				<p class="job-title">@lang('Proposal Details') :  </p>
				<div>
					<h5> {{basicControl()->currency_symbol}} {{$details->bid_amount}} <span>@lang('(Proposed Bid)')</span></h5>
				</div>
			</div>

			<h5 class="my-4">@lang('Cover Letter')</h5>
			<p class="my-4">
			   {{$details->cover_letter}}
			</p>
			<div class="my-4">
				<h5>@lang('Describe Experience')</h5>
				<p>{{$details->describe_experience}}</p>
			</div>

			<div class="col-md-6 form-group my-4">
				<h5>@lang('Attachment')</h5>
				<a class="text-primary" href="{{getFile($details->driver,$details->file)}}" target="_blank" download>{{$details->file_name}}</a>
			</div>


		 </div>

	</div>
</div>

@endsection
