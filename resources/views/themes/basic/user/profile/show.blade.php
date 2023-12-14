@extends($theme.'layouts.app')
@section('title',__('Profile'))
@section('content')
	<section class="influencer-profile-setting">
		<div class="container">
			<div class="top">
				<div class="row">
					@include($theme.'user.profile.content.profile')
					<div class="col-lg-6">
						<div class="btn-group">
							<a href="{{route('influencer.profile',$user->username)}}" target="_blank" class="btn-custom">@lang('See Public View')</a>
							<a href="{{route('user.change.password')}}" class="btn-custom">@lang('Profile Setting')</a>
						</div>
					</div>
				</div>
			</div>
			<!-- job section -->
			<div class="row g-4">
				<div class="col-lg-4">

					@include($theme.'user.profile.content.additionalInfo')
					@include($theme.'user.profile.content.skillsInfo')
					@include($theme.'user.profile.content.languageInfo')
					@include($theme.'user.profile.content.socialInfo')

				</div>

				<div class="col-lg-8">
					@include($theme.'user.profile.content.designation')
					@include($theme.'user.profile.content.addressInfo')
					@include($theme.'user.profile.content.educationalInfo')
					@include($theme.'user.profile.content.certificationalInfo')
					@include($theme.'user.profile.content.work_history')
					@include($theme.'user.profile.content.portfolio')
					@include($theme.'user.profile.content.testimonial')
					@include($theme.'user.profile.content.employment')

				</div>
			</div>
		</div>
	</section>


	<!-- Modal -->
	<div class="modal fade" id="formModal" tabindex="-1" aria-labelledby="formModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="formModalLabel">@lang('Manage Profile')</h5>
					<button type="button" class="close-btn" data-bs-dismiss="modal" aria-label="Close">
						<i class="fal fa-times"></i>
					</button>
				</div>
				<div class="modal-body">
					<div class="form-box mt-4">
						<form action="{{ route('user.profile.info') }}" method="post" enctype="multipart/form-data">
							@csrf
							<div class="row g-4">
								<div class="input-box col-md-6">
									<label>@lang('Name')</label>
									<input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-control" />
								</div>
								<div class="input-box col-md-6">
									<label>@lang('Email')</label>
									<input type="email" name="email" value="{{$user->email}}" class="form-control"  />
								</div>

								<div class="input-box col-md-6">
									<label>@lang('Date of Birth')</label>
									<input type="date" class="form-control" name="date_of_birth"
										   value="{{old('date_of_birth') ?? $userProfile->date_of_birth }}"/>
									@error('date_of_birth')
									<span class="text-danger">@lang($message)</span>
									@enderror
								</div>

								<div class="input-box col-md-6">
									<label>@lang('Phone Number')</label>
									<input type="text" class="form-control" name="phone_number" value="{{$userProfile->phone_code}}{{$userProfile->phone}}" placeholder="@lang('Enter your phone number')" />
								</div>

								<div class="input-box col-md-12">
									<label for="gender">@lang('gender')</label> <span class="text-danger">*</span>
									<select class="form-select js-example-basic-multiple-limit" name="gender"
										aria-label="Default select example">
										<option value="" selected disabled>@lang('Select Gender')</option>
										<option value="Male" {{old('gender',$userProfile->gender) == 'Male' ? 'selected' : ''}}>@lang('Male')</option>
										<option value="Female" {{old('gender',$userProfile->gender) == 'Female' ? 'selected' : ''}}>@lang('Female')</option>
									</select>
									@error('gender')
									<span class="text-danger">@lang($message)</span>
									@enderror
								</div>

								<div class="input-box col-md-12">
									<label for="">@lang('Attachment')</label>
									<ul class="attachment-list list-unstyled" id="file-list">
										<li id="file-preview" class="file-item d-flex">
											<i class="fa-light fa-paperclip "></i>
											<span class="filename">@lang('ex. attachment.file')</span>
											<button class="btn-action-icon remove"><i class="fa-light fa-trash-can"></i></button>
										</li>
									</ul>

									<div class="upload-file mb-2">
										<div class="text-center">
											<i class="fa-light fa-cloud-arrow-up"></i>
											<p class="mb-0">@lang('Drag or upload project files')</p>
										</div>
										<input class="form-control"  name="file" accept="image/*" type="file" id="file" multiple
										/>
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


@endsection

@push('css-lib')
	<link rel="stylesheet" href="{{asset($themeTrue.'css/tagsinput.css')}}" />
@endpush

@push('extra_scripts')
	<script src="{{asset($themeTrue.'js/tagsinput.js')}}"></script>
@endpush

@push('scripts')
	<script src="{{ asset($themeTrue.'js/image-uploader.js') }}"></script>
	<script>
		'use strict';
		// $('select[name=known_languages]').selectpicker();
		$('#file').change(function() {

			var files = $(this)[0].files;
			$('#file-list').empty();

			for (var i = 0; i < files.length; i++) {
				var file = files[i];
				var listItem = $('<li class="file-item"></li>');
				listItem.text(file.name);
				var removeButton = $('<button class="btn-action-icon remove"><i class="fa-light fa-trash-can"></i></button>');
				removeButton.click(function() {

					$(this).parent().remove();
				});
				listItem.append(removeButton);

				$('#file-list').append(listItem);
			}
		});

		$('#image').change(function () {
			let reader = new FileReader();
			reader.onload = (e) => {
				$('#image_preview_container').attr('src', e.target.result);
			}
			reader.readAsDataURL(this.files[0]);
		});

	</script>



	@if ($errors->any())

		<script>
			"use strict";
			@foreach ($errors as $error)
			Notiflix.Notify.Failure("{{ trans($error) }}");
			@endforeach
		</script>
	@endif
@endpush


