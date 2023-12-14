@extends($theme.'layouts.user')
@section('title',__('Receive Invitation'))
@section('content')

<div class="col-xl-9 col-lg-8 col-md-12 change-password">
	@forelse ($invitations as $invite)
	<div class="form-box mb-3">
		<div class="message">
			<div class="row">
				<div class="col-lg-8">
					<p> <b>@lang('Hello') {{__(@$invite->receiver->name)}}</b> @lang('You have received interview offer from') <strong>{{__(@$invite->sender->name)}}</strong></p>
				</div>
				<div class="col-lg-4 text-end">
					@if ($invite->status == 0)
					<button type="button" class="btn-action btn-primary approve" data-bs-toggle="modal" data-bs-target="#approveModal" data-id={{$invite->id}}>
						<i class="fa-light fa-circle-check"></i>@lang('Respond')
					</button>
					@endif

					<button type="button" class="btn-action btn-danger cancel" data-bs-toggle="modal" data-bs-target="#cancelModal" data-id={{$invite->id}}>
						<i class="fa-light fa-circle-xmark"></i>@lang('Cancel')
					  </button>
				</div>
			</div>


		</div>

		<div class="job-link">
			<p><b>@lang('View Job') : </b><a href="{{route('user.jobs.details',[slug($invite->job->title),$invite->job->id])}}"  class="text-primary">{{$invite->job->title}}</a></p>
		</div>
		<div class="description-box">
			<p>{{__($invite->details)}}</p>
		</div>
		<p> <i class="fas fa-clock text-primary"></i> <b>@lang('Invitation time')</b> : {{$invite->created_at->format('m/d/Y h:i A')}}</p>
	</div>
	@empty
		<div class="card-box no-data">
			<div>
				<img src="{{asset($themeTrue.'images/no-data.png')}}" alt="@lang('no-data')" class="no-data-img">
				<h6 class="text-center">@lang('No Data available')</h6>
			</div>
		</div>

	@endforelse
</div>
  <!-- Modal -->
  <div class="modal fade" id="approveModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
	  <div class="modal-content">
		<div class="modal-header">
		  <h5 class="modal-title" id="exampleModalLabel">@lang('Approve Invitation')</h5>
		  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		</div>
		<form action="{{route('user.invite.approve')}}" method="POST">
			@csrf
			<div class="modal-body">
				<p>@lang('Are you want to approve this invitation?')</p>
				<input type="hidden" name="id">
			</div>
			<div class="modal-footer">
			  <button type="submit" class="btn btn-primary">@lang('Approve')</button>
			</div>
		</form>
	  </div>
	</div>
  </div>

  <div class="modal fade" id="cancelModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
	  <div class="modal-content">
		<div class="modal-header">
		  <h5 class="modal-title" id="exampleModalLabel">@lang('Cancel Invitation')</h5>
		  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		</div>
		<form action="{{route('user.invite.cancel')}}" method="POST">
			@csrf
			<div class="modal-body">
				<p>@lang('Are you sure to cancel this invitation?')</p>
				<input type="hidden" name="id">
			</div>
			<div class="modal-footer">
			  <button type="submit" class="btn btn-primary">@lang('Cancel')</button>
			</div>
		</form>
	  </div>
	</div>
  </div>


@endsection

@push('scripts')
<script>
	$(function(){
		$('.approve').on('click',function(){
			var modal = $('#approveModal');
			modal.find('input[name="id"]').val($(this).data('id'));
			modal.show();
		});

		$('.cancel').on('click',function(){
			var modal = $('#cancelModal');
			modal.find('input[name="id"]').val($(this).data('id'));
			modal.show();
		});


	});
</script>

@endpush


