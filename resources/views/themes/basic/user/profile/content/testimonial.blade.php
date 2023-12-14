<div class="job-box">
	<a href="javascript:void(0)" class="job-title">@lang('Testimonial') </a>
	<p>@lang('Endorsements from past clients')</p>
	@forelse($testimonials as $data)
		@if($data->is_accepted == 1)
			<div class="info-box mt-2">

				<div class="d-flex align-items-center">
					<p>{{__($data->client_note)}}</p>

					<button class="btn-action-icon bg-danger mx-2 mb-3 delete" data-id="{{$data->id}}"
							data-bs-toggle="modal" data-bs-target="#deleteModal">
						<i class="fal fa-trash"></i>
					</button>
				</div>
				@for($i = 0; $i < $data->ratings; $i++)
					<i class="fas fa-star text-primary"></i>
				@endfor
				<h6>{{__($data->first_name)}} {{__($data->last_name)}}</h6>
				<p><span>{{dateTime($data->updated_at,'d M, Y')}}  </span> <span> <i
							class="fa-solid fa-circle-check text-primary"></i>@lang(' Varified')</span></p>

			</div>

			<hr>
		@else
			<p>@lang('Your testimonial request awaiting for response')</p>
		@endif
	@empty
		<div class="">
			<div class="img-box text-center pt-3">
				<img src="{{asset($themeTrue.'images/no-data.png')}}" class="img-fluid no-data-img" alt="img" />
			</div>
			<div class="text-box">
				<p class="text-center">@lang('Showcasing client testimonials can strengthen your profile.')</p>
			</div>
		</div>
	@endforelse


	<div class="feedback">
		<button data-bs-toggle="modal" data-bs-target="#testimonialModal" class="">
			<i class="fa-light fa-plus"></i>
		</button>
	</div>
</div>


<div class="modal fade" id="testimonialModal" tabindex="-1" aria-labelledby="testimonialModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="testimonialModalLabel">@lang('Request a client testimonial')</h5>
				<button type="button" class="close-btn" data-bs-dismiss="modal" aria-label="Close">
					<i class="fal fa-times"></i>
				</button>
			</div>
			<div class="modal-body">
				<form action="{{route('user.testimonial.create')}}" method="post" enctype="multipart/form-data">
					@csrf
					<div class="row g-3">

						<div class="input-box col-6">
							<label for="title">@lang('First Name ( Client\'s )')</label> <span
								class="text-danger">*</span>
							<input type="text" name="first_name" id="first_name" class="form-control"
								   placeholder="@lang('Enter client\'s first name')" value="{{old('first_name')}}"/>
							@if($errors->has('first_name'))
								<div class="error text-danger">@lang($errors->first('first_name')) </div>
							@endif
						</div>

						<div class="input-box col-6">
							<label for="title">@lang('Last Name ( Client\'s )')</label>
							<input type="text" name="last_name" id="last_name" class="form-control"
								   placeholder="@lang('Enter client\'s last name')" value="{{old('last_name')}}"/>
							@if($errors->has('last_name'))
								<div class="error text-danger">@lang($errors->first('last_name')) </div>
							@endif
						</div>

						<div class="input-box col-6">
							<label for="email">@lang('Email')</label> <span class="text-danger">*</span>
							<input type="email" name="email" id="email" class="form-control"
								   placeholder="@lang('Enter a client\'s email')" value="{{old('email')}}"/>
							@if($errors->has('email'))
								<div class="error text-danger">@lang($errors->first('email')) </div>
							@endif
						</div>


						<div class="input-box col-6">
							<label for="link">@lang('Link')</label> <span class="text-danger">*</span>
							<input type="text" name="link" id="link" class="form-control"
								   placeholder="@lang('Enter a client\'s link')" value="{{old('link')}}"/>
							@if($errors->has('link'))
								<div class="error text-danger">@lang($errors->first('link')) </div>
							@endif
						</div>

						<div class="input-box col-6">
							<label for="title">@lang('Client\'s Title')</label> <span class="text-danger">*</span>
							<input type="text" name="client_title" id="title" class="form-control"
								   placeholder="@lang('Enter a client\'s title')" value="{{old('client_title')}}"/>
							@if($errors->has('client_title'))
								<div class="error text-danger">@lang($errors->first('client_title')) </div>
							@endif
						</div>

						<div class="input-box col-6">
							<label for="type">@lang('Project Type')</label> <span class="text-danger">*</span>
							<input type="text" name="project_type" id="type" class="form-control"
								   placeholder="@lang('Enter a client\'s project type')"
								   value="{{old('project_type')}}"/>
							@if($errors->has('project_type'))
								<div class="error text-danger">@lang($errors->first('project_type')) </div>
							@endif
						</div>


						<div class="input-box col-12">
							<label for="message">@lang('Message')</label> <span class="text-danger">*</span>
							<textarea cols="30" rows="10" class="form-control" name="message" id="message"></textarea>
							@if($errors->has('message'))
								<div class="error text-danger">@lang($errors->first('message')) </div>
							@endif
						</div>


					</div>

					<div class="modal-footer">
						<button type="button" class="btn btn-danger" data-bs-dismiss="modal">@lang('Close')</button>
						<button type="submit" class="btn-custom">@lang('Submit')</button>
					</div>
				</form>
			</div>

		</div>
	</div>
</div>


@push('css-lib')
	<link rel="stylesheet" href="{{asset($themeTrue.'css/flatpickr.min.css')}}">
@endpush

@push('extra-js')
	<script src="{{asset($themeTrue.'js/flatpickr.js')}}"></script>
@endpush

@push('script')

	@if($errors->has('first_name') || $errors->has('email') || $errors->has('link') || $errors->has('message') || $errors->has('title') || $errors->has('project_type'))
		<script defer>
			var myModal = new bootstrap.Modal(document.getElementById("testimonialModal"), {});
			document.onreadystatechange = function () {
				myModal.show();
			};
		</script>
	@endif

	<script src="{{ asset($themeTrue.'js/image-uploader.js') }}"></script>
	<script>


		$(document).ready(function () {
			$(".completion_date").flatpickr({
				minDate: "today",
				altInput: true,
				altFormat: "d/m/y",
				dateFormat: "Y-m-d",
			});
		});

	</script>
@endpush
