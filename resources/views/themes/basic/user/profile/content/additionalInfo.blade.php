<div class="additional-info card-box">
	<div class="d-flex">
		<h4>@lang('View Profile')
		</h4>
	</div>
	@if($profileComplete == 0)
		<div class="progress">
			<div class="progress-bar progress-bar-striped bg-danger progress-bar-animated" role="progressbar" style="width: 3%" aria-valuenow="{{$profileComplete}}" aria-valuemin="0" aria-valuemax="100">{{$profileComplete}}%</div>
		</div>
	@else
		<div class="progress">
			<div class="progress-bar progress-bar-striped bg-primary progress-bar-animated" role="progressbar" style="width: {{$profileComplete}}%" aria-valuenow="{{$profileComplete}}" aria-valuemin="0" aria-valuemax="100">{{$profileComplete}}%</div>
		</div>
	@endif

	@if(isset($approvedProfile->status) && $approvedProfile->status == 1)
		<span class="text-primary">*@lang('Congratulations! Your profile is live now.')</span>
	@else
		@if($profileComplete == 100)
			<span class="text-primary">*@lang('Welldone! Your profile is ready to be approved soon.')</span>
		@else
			<span class="text-primary">*@lang('Please update your profile 100% to get approved.')</span>
		@endif
	@endif
</div>

