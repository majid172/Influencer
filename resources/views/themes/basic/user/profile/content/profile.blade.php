<div class="col-lg-6">
	<div class="d-flex">
		<div class="profile d-flex">
			<div class="img">
				{!! $user->profilePicture() !!}
				<button data-bs-toggle="modal" data-bs-target="#profileModal" class="upload-btn">
					<i class="fa-light fa-pencil"></i>
				</button>
				<div class="text-danger mb-5">@error('profile_picture') @lang($message) @enderror</div>
			</div>
		</div>

		<div class="text-box">
			<h4 class="d-flex">
				{{__($user->name)}}
				<button class="btn-action-icon bg-primary" data-bs-toggle="modal" data-bs-target="#formModal">
					<i class="fal fa-pencil"></i>
				</button>
			</h4>
			<p>{{__($user->timezone)}} - <span> {{ \Illuminate\Support\Carbon::now()->format('H:i') }}
					@lang('Local Time')</span></p>
			<p class="mb-0">
				<span>
					<i class="fal fa-map-marker-alt"></i>
					@lang('From'):
				</span>
				<span>{{__(optional($userProfile->getCountry)->name)??'Insert your Country'}}</span>
			</p>

			<p class="mb-0">
				<span>
					<i class="fal fa-user"></i>
					@lang('Memeber since') :
				</span>
				<span>{{dateTime($user->created_at,'d M , Y')}}</span>
			</p>
		</div>
	</div>
</div>

<div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="profileModalLabel">@lang('Edit Profile Photo')</h5>
				<button type="button" class="close-btn" data-bs-dismiss="modal" aria-label="Close">
					<i class="fal fa-times"></i>
				</button>
			</div>
			<div class="modal-body">
				<form action="{{route('user.profile.picture')}}" method="post" enctype="multipart/form-data">
					@csrf
					<div class="row g-3">

						<div class="col-md-12 input-box">
							<label for="image">@lang('Profile Image')</label> <span class="text-danger">*</span>
							<div class="image-input">
								<label for="image-upload" id="image-label">
									<i class="fa-regular fa-upload"></i>
								</label>
								<input type="file" name="image" placeholder="@lang('Choose image')" id="profile_image" >
								<img class="w-100 preview-profile_image" id="profile_image_preview_container"
									 src="{{getFile($userProfile->driver,$userProfile->profile_picture)}}"
									 alt="@lang('Upload Image')">
							</div>
							@error('image')
							<span class="text-danger">@lang($message)</span>
							@enderror
						</div>

					</div>

					<div class="modal-footer">
						<button type="submit" class="btn-custom">@lang('Submit')</button>
					</div>
				</form>
			</div>

		</div>
	</div>
</div>

@push('scripts')
	<script src="{{ asset($themeTrue.'js/image-uploader.js') }}"></script>
	<script>

		$('#profile_image').change(function () {
			let reader = new FileReader();
			reader.onload = (e) => {
				$('#profile_image_preview_container').attr('src', e.target.result);
			}
			reader.readAsDataURL(this.files[0]);
		});
	</script>
@endpush
