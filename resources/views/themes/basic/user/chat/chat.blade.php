@extends($theme.'layouts.user')
@section('title', trans('Job Proposal List'))
@section('content')
<div class="col-lg-8 col-md-6 job-section">

	<div id="jobContainer">
		<div class="job-box">
			<div>
				<h5>{{auth()->user()->name}}</h5>
			</div>
			<hr>
			<div class="chats">

			</div>
			<form action="{{route('user.chat.store',$proposser_id)}}" method="POST">
				@csrf
				<div class="d-flex">
					<input type="hidden" name="proposser_id" value="{{$proposser_id}}">
					<input type="hidden" name="creator_id" value="">
					<input type="text" class="form-control" name="chat" id="">
					<button class="btn btn-primary" type="submit">@lang('Send')</button>
				</div>
			</form>


		</div>


	</div>
</div>
@endsection

@push('style')
<style>
.chats {
    padding: 30px 15px 10px 15px;
    height: 500px;
    overflow-y: auto;
    position: relative;
	}
</style>

@endpush
