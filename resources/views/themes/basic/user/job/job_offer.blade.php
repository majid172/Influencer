@extends($theme.'layouts.user')
@section('title',__('Job Offer'))
@section('content')

	<div class="col-xl-9 col-lg-8 col-md-12 change-password">
		<div class="form-box mb-4">
			<div class="job-title">
				<h4>{{__($offer->job->title)}}</h4>
			</div>

			<div class="job-description">
				<h6><b>@lang('Job description') </b></h6>
				<p> {{__($offer->job->description)}} </p>
			</div>

				<div class="col-lg-4 col-6">
					<ul>
						<li class="mb-0"><b>@lang('Select project type')</b> -
						@if ($offer->pay_type == 1)
							@lang('Hourly')
						@elseif($offer->pay_type == 2)
							@lang('Fixed')
						@endif
						</li>

					</ul>
				</div>
				<div class="col-lg-4 col-6">
					<ul>
						<li class="mb-0"><b>@lang('Project rate')</b> -
						@if ($offer->pay_type == 1)
						{{getAmount($offer->hourly_rate)}}
						@elseif($offer->pay_type == 2)
            			 {{getAmount($offer->fixed_rate)}} {{basicControl()->base_currency}}
						@endif
						</li>
					</ul>
				</div>

				<div class="col-lg-4 col-6">
					<ul>
						<li class="mb-0"><b>@lang('Project duration')</b> -
						{{$offer->submit_date}}
						</li>

					</ul>
				</div>

				<div class="col-12 input-box mb-2">
					<h6><b>@lang('Details') </b></h6>
					<p>{{__($offer->description)}}</p>
				 </div>

				@if ($offer->is_hired == 0)
				<button class="btn-custom accept" data-bs-toggle="modal" data-route="{{route('user.job.accept',$offer->job_id)}}" data-bs-target="#acceptModal">
					@lang('Accept')
				</button>

				<button class="btn-custom cancel" data-bs-toggle="modal" data-route="{{route('user.job.cancel',$offer->job_id)}}" data-bs-target="#cancelModal">
					@lang('Cancel')
				</button>
				@endif
		</div>
	</div>

<!-- offer accepted modal -->
	<div class="modal fade" id="acceptModal" tabindex="-1" aria-labelledby="acceptModal" aria-hidden="true">
		<div class="modal-dialog">
		  <div class="modal-content">
			<div class="modal-header">
			  <h5 class="modal-title" id="exampleModalLabel">@lang('Accept the hiring offer')</h5>
			  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<p>@lang('Are you ready to start working on this project?')</p>
			</div>
			<div class="modal-footer">
				<form action="" method="post" class="confirm">
					@csrf
					<button type="submit" class="btn btn-primary">@lang('Accept')</button>
				</form>

			</div>
		  </div>
		</div>
	  </div>

	<div class="modal fade" id="cancelModal" tabindex="-1" aria-labelledby="cancelModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="cancelModalLabel">@lang('Accept the hiring offer')</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<p>@lang('Are you sure to cancel this offer?')</p>
				</div>
				<div class="modal-footer">
					<form action="" method="post" class="reject">
						@csrf
						<button type="submit" class="btn btn-primary">@lang('Yes')</button>
					</form>

				</div>
			</div>
		</div>
	</div>

@endsection

@push('scripts')
<script>
	$(function(){
		$('.accept').click(function(){
			var url = $(this).data('route');
			$('.confirm').attr('action',url);
		});

		$('.cancel').on('click',function (){
			let url = $(this).data('route');
			$('.reject').attr('action',url);
		});
	});
</script>

@endpush
