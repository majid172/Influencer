@extends($theme.'layouts.user')
@section('title',__('Invite Freelencer'))
@section('content')

<div class="col-xl-9 col-lg-8 col-md-12">
	@forelse ($freelancers as $freelancer)
	<div class="job-list-box card-box mb-3">
		<div class="row">

			<div class="col-10">
				<div class="user-box mb-3">
					<div class="img-box">
						{!! $freelancer->profilePicture() !!}
					</div>
					<h5>{{$freelancer->name}}</h5>
				</div>
				<span>
					{{__($freelancer->profile->designation)}}
				</span>
				<h5 class="text-primary mt-2"> {{basicControl()->currency_symbol}} {{getAmount($freelancer->balance)}}</h5>
			</div>
			<div class="col-lg-2 text-end">

				<button type="button" class="btn-action text-light invite" data-bs-toggle="modal" data-bs-target="#inviteModal" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="@lang('Send invitation all influencers for your job.')" data-id="{{$freelancer->id}}" data-name="{{__($freelancer->name)}}" data-designation="{{__($freelancer->profile->designation)}}" data-skills="{{__($freelancer->profile->skills)}}" data-bs-original-title="@lang('Send invitation all influencers for your job.')">
					@lang('Invite')
				</button>

			</div>
		</div>
		<div class="mt-0">
			<div class="d-flex align-items-center">
				<i class="fa-duotone fa-clipboard-list-check me-2"></i>
				<p class="mb-0">
					@php
						$user_skills = explode(',', $freelancer->profile->skills);
						$matching_skills = array_intersect($job_skills, $user_skills);
						$match_count = count($matching_skills);
					@endphp
					{{$match_count}} @lang('has relevent skills to this job')
				</p>
			</div>
		</div>

		<div class="skills mt-3">
			@foreach (explode(',',$freelancer->profile->skills) as $skill)
				<a href="javascript:void(0)" class="tag">{{$skill}}</a>
			@endforeach
		</div>

	</div>
	@empty
		<div class="card-box no-data">
			<div>
				<img src="{{asset($themeTrue.'images/no-data.png')}}" alt="@lang('no-data')" class="no-data-img">
				<h4 class="text-center">@lang('No Data available')</h4>
			</div>
		</div>
	@endforelse


</div>

  <!-- Modal -->
  <div class="modal fade" id="inviteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered ">
	  <div class="modal-content">
		<div class="modal-header">
		  <h5 class="modal-title" id="exampleModalLabel">@lang('Invite to job')</h5>
		  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		</div>

	  <div class="modal-body">
		<h5 class="user_name"></h5>
		<p><b><span class="designation"></span></b> | <span class="skills"></span></p>


		<form action="{{route('user.invite.store')}}" method="POST">
			@csrf
			<input type="hidden" name="to_id" id="to_id">
			<input type="hidden" name="job_id" id="job_id" value="{{$job->id}}">
			<b><label for="message" class="mb-2">@lang('Details for invitation')</label></b>
			<textarea name="details" id="message" class="form-control mb-2" cols="30" rows="5"></textarea>
			<button type="submit" class="btn btn-primary">@lang('Send Invitation')</button>
		</form>
	  </div>
	  </div>
	</div>
  </div>
@endsection

@push('scripts')
<script>
	$(function(){
		$('.invite').on('click',function(){
			var modal = $('#inviteModal');

			modal.find('.user_name').text($(this).data('name'));
			modal.find('.designation').text($(this).data('designation'));
			modal.find('.skills').text($(this).data('skills'));
			modal.find('input[name="to_id"]').val($(this).data('id'))

			modal.show()
		});
	});
</script>

@endpush
