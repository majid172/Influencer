<div class="card-box skills mt-4">
	<div class="d-flex">
		<h4>@lang('Skills')
		</h4>
		<button class="btn-action-icon bg-primary mx-2 mb-3" data-bs-toggle="modal" data-bs-target="#skillModal">
			<i class="fal fa-pencil"></i>
		</button>
	</div>

	@foreach (explode(',',$userProfile->skills) as $skill)
		@if($skill)
		<a href="javascript:void(0)">{{__($skill)}}</a>
		@else
			<div class="img-box text-center pt-3">
				<img src="{{asset($themeTrue.'images/no-data.png')}}" class="img-fluid no-data-img" alt="img" />
			</div>
			<div class="text-box">
				<p class="text-center">@lang('No information available ')</p>
			</div>
		@endif
	@endforeach
</div>

<!-- Modal -->
<div class="modal fade" id="skillModal" tabindex="-1" aria-labelledby="skillModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="skillModalLabel">@lang('Manage Skills')</h5>
				<button type="button" class="close-btn" data-bs-dismiss="modal" aria-label="Close">
					<i class="fal fa-times"></i>
				</button>
			</div>
			<div class="modal-body">
				<div class="form-box mt-4">
					<form action="{{ route('user.skills.info') }}" method="post" enctype="multipart/form-data">
						@csrf
						<div class="row g-4">
							<div class="input-box col-md-12">
								<label for="skills">@lang('Skills')</label> <span class="text-danger">*</span>
								<input type="text" class="form-control" name="skills" id="skills" data-role="tagsinput" value="{{ old('skills', $userProfile->skills) }}" placeholder="Keywords"/>
								<div class="text-danger">
									@error('skills') @lang($message) @enderror
								</div>
							</div>

							<div class="input-box col-12">
								<button type="submit" class="btn-custom">@lang('Update')</button>
							</div>
						</div>
					</form>
				</div>
			</div>

		</div>
	</div>
</div>
