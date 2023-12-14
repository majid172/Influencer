@extends($theme.'layouts.user')
@section('title', trans('Job Proposal List'))
@section('content')
	<div class="col-xl-9 col-lg-8 col-md-12 change-password">

		@forelse($proposals as $item)
			<div class="form-box mb-3">

				<h4><a href="{{route('job.proposser.details',$item->id)}}"
				   class="job-title text-primary">{{ucfirst($item->proposer->name)}}</a></h4>
				<p>@lang('Bid Amount'): {{$item->bid_amount}} {{basicControl()->base_currency}} - @lang('Duration'):

					@php
						$duration = ($item->durations->duration)/($item->durations->frequency)
					@endphp
					@if($item->durations->frequency == 1)
						@lang('Less then one month')
					@elseif($item->durations->frequency == 30)
						@lang('More then') {{ceil($duration)}} @lang('month')
					@endif
				</p>
				<p><span>
					<i class="fa-solid fa-location-dot"></i>
					{{@$item->proposer->profile->getCountry->name}}
					</span></p>

			<p>
				<strong>@lang('Cover letter ')</strong> - {{\Str::limit($item->cover_letter,250)}}
				<a href="{{route('job.proposser.details',$item->id)}}">@lang('more')</a>
			</p>

				<div class="collapse" id="collapseExample">
					<div class="">
						@lang('Some placeholder content for the collapse component. This panel is hidden by default but revealed when the user activates the relevant trigger.')
					</div>
				</div>

			<div class="input-box col-12">
				<button type="button" class="btn btn-primary message " data-bs-toggle="modal" data-sender_id="{{auth()->user()->id}}" data-receiver_id="{{optional($item->proposer)->id}}" data-job_id="{{optional($item->job)->id}}" data-bs-target="#messageModal">
					@lang('Message')
				</button>

				<a href="{{ route('user.job.hire', [optional($item->proposer)->id,$item->job_id,$item->id]) }}" class="btn-custom">@lang('Hire')</a>
			</div>
		</div>
		@empty
		<div class="card-box no-data">
			<div>
				<img src="{{asset($themeTrue.'images/no-data.png')}}" alt="@lang('no-data')" class="no-data-img">
				<h6 class="text-center">@lang('No data available')</h6>
			</div>
		</div>
		@endforelse
		<div class="row">
			<div class="col-12">
				{{$proposals->links()}}
			</div>
		</div>

	</div>


	<div class="modal fade" id="messageModal" tabindex="-1" aria-labelledby="messageModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="messageModalLabel">@lang('Message')</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<form action="{{route('user.proposer.message')}}" method="POST">
					@csrf
					<div class="modal-body">
						<input type="hidden" class="form-control" name="sender_id">
						<input type="hidden" class="form-control" name="receiver_id">
						<input type="hidden" class="form-control" name="job_id">

						<textarea class="form-control" name="message" rows="2" cols="10" placeholder="@lang('write something ...')"></textarea>

					</div>
					<div class="modal-footer">

						<button type="submit" class="btn btn-primary">@lang('Send')</button>
					</div>
				</form>

			</div>
		</div>
	</div>

@endsection

@push('scripts')
	<script>
		$('.message').on('click',function (){
			let modal = $('#messageModal');
			let sender_id = $(this).attr('data-sender_id')
			let receiver_id = $(this).attr('data-receiver_id');
			let job_id = $(this).attr('data-job_id');

			modal.find('input[name="sender_id"]').val(sender_id);
			modal.find('input[name="receiver_id"]').val(receiver_id);
			modal.find('input[name="job_id"]').val(job_id);
			modal.show();
		});
	</script>
@endpush


