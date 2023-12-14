<div class="job-box">
	<div class="d-lg-flex flex-wrap justify-content-lg-between mb-1">

		<a href="javascript:void(0)" class="job-title">@if($userProfile->designation){{__($userProfile->designation)}}
			@else @lang('Add Designation')
			@endif</a>
		<h6 class="mb-0 px-lg-5">{{$basic->currency_symbol}}{{getAmount($userProfile->hourly_rate)}} / @lang('hr')</h6>
	</div>
	<h6> @lang('Seller Type') : {{__($userProfile->seller_type)??'Beginner'}}</h6>
	<p class="justify-content-center">{{__($userProfile->about_me)??''}}</p>
	<div>
		@foreach(explode(',',$userProfile->skills) as $skill)
			@if($skill) <a href="javascript:void(0)" class="tag">{{__($skill)}}</a> @else @endif
		@endforeach
	</div>

	<div class="feedback">
		<button data-bs-toggle="modal" data-bs-target="#designationModal">
			<i class="fal fa-pencil"></i>
		</button>

	</div>
</div>

<div class="modal fade" id="designationModal" tabindex="-1" aria-labelledby="designationModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="designationModalLabel">@lang('Edit Additional Information')</h5>
				<button type="button" class="close-btn" data-bs-dismiss="modal" aria-label="Close">
					<i class="fal fa-times"></i>
				</button>
			</div>
			<div class="modal-body">
				<div class="form-box mt-4">
					<form action="{{ route('user.designation') }}" method="post" enctype="multipart/form-data">
						@csrf
						<div class="row g-4">
							<div class="input-box col-md-6">
								<label>@lang('Designation')</label>
								<input type="text" name="designation" value="{{ old('name', $userProfile->designation) }}" class="form-control" />
								<div class="text-danger">@error('designation') @lang($message) @enderror</div>
							</div>


							<div class="input-box col-md-6">
								<label>@lang('Hourly Rate')</label>
								<input type="number" name="hourly_rate" value="{{getAmount($userProfile->hourly_rate)}}" class="form-control"  />
								<div class="text-danger">@error('hourly_rate') @lang($message) @enderror</div>
							</div>


							<div class="input-box col-md-12">
								<label for="about_me">
									@lang('About Me')
									<button type="button" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('Give details within 400 words, but don’t include your personal contact info')">
										<i class="fad fa-info-circle"></i>
									</button>
								</label> <span class="text-danger">*</span>
								<textarea class="form-control" cols="30" rows="3" name="about_me" id="about_me" placeholder="@lang('Enter short description about you...')">{{ old('about_me', $userProfile->about_me) }}</textarea>
								<div class="text-danger">@error('about_me') @lang($message) @enderror</div>
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

@push('script')
	@if($errors->has('about_me') || $errors->has('hourly_rate') || $errors->has('designation'))
		<script defer>
			var myModal = new bootstrap.Modal(document.getElementById("designationModal"), {});
			document.onreadystatechange = function () {
				myModal.show();
			};
		</script>
	@endif
@endpush

