<div class="job-box">
	<a href="javascript:void(0)" class="job-title">@lang('Employment History') </a>

	@forelse($employments as $data)
		<div class="info-box mt-2">

			<div class="d-flex align-items-center">
				<h6> <span>{{__($data->title)}}</span> | <span>{{__($data->company)}}</span> </h6>

				<button class="btn-action-icon bg-primary mx-2 mb-3 edit" data-bs-toggle="modal" data-bs-target="#editEmployModal" data-id="{{$data->id}}" data-title="{{__($data->title)}}" data-company= "{{__($data->company)}}" data-from_period="{{$data->from_period}}" data-city="{{__($data->city)}}" data-description="{{__($data->description)}}" data-to="{{__($data->to)}}" >
					<i class="fal fa-pencil"></i>
				</button>

				<button class="btn-action-icon bg-danger mx-2 mb-3 delete" data-id="{{$data->id}}" data-bs-toggle="modal" data-bs-target="#deleteModal" >
					<i class="fal fa-trash"></i>
				</button>
			</div>
			<p>{{__($data->description)}}</p>
			<p> <span>{{dateTime($data->from_period,'d M, Y')}} - {{($data->to)}}
				</span>
			</p>

		</div>
		<hr>
	@empty
		<div class="">
			<div class="img-box text-center pt-3">
				<img src="{{asset($themeTrue.'images/no-data.png')}}" class="img-fluid no-data-img" alt="img" />
			</div>
			<div class="text-box">
				<p class="text-center">@lang('No information available ')</p>
			</div>
		</div>
	@endforelse


	<div class="feedback">
		<button data-bs-toggle="modal" data-bs-target="#employmentModal" class="">
			<i class="fa-light fa-plus"></i>
		</button>
	</div>
</div>

{{--add --}}
<div class="modal fade" id="employmentModal" tabindex="-1" aria-labelledby="employmentModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="employmentModalLabel">@lang('Add Employment ')</h5>
				<button type="button" class="close-btn" data-bs-dismiss="modal" aria-label="Close">
					<i class="fal fa-times"></i>
				</button>
			</div>
			<div class="modal-body">
				<form action="{{route('user.employment.create')}}" method="post" enctype="multipart/form-data">
					@csrf
					<div class="row g-3">
						<div class="input-box col-12">
							<label for="company">@lang('Company')</label> <span class="text-danger">*</span>
							<input type="text" name="company" id="company" class="form-control" placeholder="@lang('Ex. Company name')" value="{{old('company')}}" />
							@if($errors->has('company'))
								<div class="error text-danger">@lang($errors->first('company')) </div>
							@endif
						</div>
						<div class="input-box col-6">
							<label for="location">@lang('City')</label> <span class="text-danger">*</span>
							<input type="text" name="city" class="form-control" placeholder="@lang('City')"  value="{{old('city')}}"/>
							@if($errors->has('city'))
								<div class="error text-danger">@lang($errors->first('location')) </div>
							@endif
						</div>

						<div class="input-box col-6">
							<label for="country_id">@lang('Country')</label> <span class="text-danger">*</span>
							<select
								class="form-select js-example-basic-multiple-limit"
								name="country_id" id="country_id"
								aria-label="Default select example">
								<option value="" selected disabled>@lang('Select Country')</option>
								@foreach ($countries as $data)
									<option value="{{$data->id}}" {{$userProfile->country_id == $data->id ? 'selected' : ''}}>
										{{$data->name}}
									</option>
								@endforeach
							</select>
							@error('country_id')
							<span class="text-danger">@lang($message)</span>
							@enderror
						</div>

						<div class="input-box col-12">
							<label for="title">@lang('Title')</label> <span class="text-danger">*</span>
							<input type="text" class="form-control" name="title" id="title" placeholder="@lang('Enter project title')"/>
							@if($errors->has('title'))
								<div class="error text-danger">@lang($errors->first('title')) </div>
							@endif
						</div>


						<div class="input-box col-12">
							<label for="from_period">@lang('From Period')</label> <span class="text-danger">*</span>
							<input type="text" name="from_period" id="from_period" class="form-control period_date" value="{{old('from_period')}}" />
							@if($errors->has('from_period'))
								<div class="error text-danger">@lang($errors->first('from_period')) </div>
							@endif
						</div>
						<div class="input-box col-12 d-none" id="to_period">
							<label for="to_period">@lang('To Period')</label> <span class="text-danger">*</span>
							<input type="text" name="to_period" class="form-control period_date" value="{{old('to_period')}}" />
							@if($errors->has('to_period'))
								<div class="error text-danger">@lang($errors->first('to_period')) </div>
							@endif
						</div>


						<div class="input-box col-12">

							<div class="form-check form-switch">
								<input class="form-check-input check" type="checkbox" role="switch" name="present" value="Present" id="check" checked>
								<label class="form-check-label" for="check">@lang('I currently work here')</label>
							</div>

						</div>


						<div class="input-box col-12">
							<label for="description">@lang('Description')</label> <span class="text-danger">*</span>
							<textarea cols="30" rows="10" class="form-control" name="description" id="description"></textarea>
							@if($errors->has('description'))
								<div class="error text-danger">@lang($errors->first('description')) </div>
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

<div class="modal fade" id="editEmployModal" tabindex="-1" aria-labelledby="editEmployModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="editEmployModalLabel">@lang('Edit Employment ')</h5>
				<button type="button" class="close-btn" data-bs-dismiss="modal" aria-label="Close">
					<i class="fal fa-times"></i>
				</button>
			</div>
			<div class="modal-body">
				<form action="{{route('user.employment.update')}}" method="post" enctype="multipart/form-data">
					@csrf
					<input type="hidden" name="id">
					<div class="row g-3">
						<div class="input-box col-12">
							<label for="company">@lang('Company')</label> <span class="text-danger">*</span>
							<input type="text" name="company" id="company" class="form-control" placeholder="@lang('Ex. Company name')" value="{{old('company')}}" />
							@if($errors->has('company'))
								<div class="error text-danger">@lang($errors->first('company')) </div>
							@endif
						</div>
						<div class="input-box col-6">
							<label for="location">@lang('City')</label> <span class="text-danger">*</span>
							<input type="text" name="city" class="form-control" placeholder="@lang('City')"  value="{{old('city')}}"/>
							@if($errors->has('city'))
								<div class="error text-danger">@lang($errors->first('location')) </div>
							@endif
						</div>

						<div class="input-box col-6">
							<label for="country_id">@lang('Country')</label> <span class="text-danger">*</span>
							<select
								class="form-select js-example-basic-multiple-limit"
								name="country_id" id="country_id"
								aria-label="Default select example">
								<option value="" selected disabled>@lang('Select Country')</option>
								@foreach ($countries as $data)
									<option value="{{$data->id}}" {{$userProfile->country_id == $data->id ? 'selected' : ''}}>
										{{$data->name}}
									</option>
								@endforeach
							</select>
							@error('country_id')
							<span class="text-danger">@lang($message)</span>
							@enderror
						</div>


						<div class="input-box col-12">
							<label for="title">@lang('Title')</label> <span class="text-danger">*</span>
							<input type="text" class="form-control" name="title" id="title" placeholder="@lang('Enter project title')"/>
							@if($errors->has('title'))
								<div class="error text-danger">@lang($errors->first('title')) </div>
							@endif
						</div>

						<div class="input-box col-12">
							<label for="from_period">@lang('From Period')</label> <span class="text-danger">*</span>
							<input type="text" name="from_period" id="from_period" class="form-control from_period_date" value="{{old('from_period')}}" />
							@if($errors->has('from_period'))
								<div class="error text-danger">@lang($errors->first('from_period')) </div>
							@endif
						</div>

						<div class="input-box col-12 d-none" id="to_period_edit">
							<label for="to_period">@lang('To Period')</label> <span class="text-danger">*</span>
							<input type="text" name="to_period" class="form-control to_period_date" value="{{old('to_period')}}" />
							@if($errors->has('to_period'))
								<div class="error text-danger">@lang($errors->first('to_period')) </div>
							@endif
						</div>

						<div class="input-box col-12">

							<div class="form-check form-switch " id="edit_form_switch">
								<input class="form-check-input check" type="checkbox" role="switch" name="present" value="Present" id="check_edit" checked>
								<label class="form-check-label" for="check">@lang('I currently work here')</label>
							</div>

						</div>


						<div class="input-box col-12">
							<label for="description">@lang('Description')</label> <span class="text-danger">*</span>
							<textarea cols="30" rows="10" class="form-control" name="description" id="description"></textarea>
							@if($errors->has('description'))
								<div class="error text-danger">@lang($errors->first('description')) </div>
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

{{--delete--}}
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="deleteModalLabel">@lang('Delete Employment History')</h5>
				<button type="button" class="close-btn" data-bs-dismiss="modal" aria-label="Close">
					<i class="fal fa-times"></i>
				</button>
			</div>
			<div class="modal-body">
				<form action="{{route('user.employment.delete')}}" method="post" enctype="multipart/form-data">
					@csrf
					<input type="hidden" name="id">
					<p>@lang('Are you want to remove it?')</p>
					<div class="modal-footer">
						<button type="button" class="btn btn-danger" data-bs-dismiss="modal">@lang('No')</button>
						<button type="submit" class="btn-custom">@lang('Yes')</button>
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

	<script>

		@error('employmentCreateInfo')
			var addEmployment= new bootstrap.Modal(document.getElementById("employmentModal"), {});
			document.onreadystatechange = function () {
				addEmployment.show();
			};
		@enderror

		@error('employmentUpdateInfo')
			var editEmployment= new bootstrap.Modal(document.getElementById("editEmployModal"), {});
			document.onreadystatechange = function () {
				editEmployment.show();
			};
		@enderror

		$(document).ready(function() {

			$('.form-switch').on('click', function () {

				let isCheck = $('#check').prop('checked');
				if (isCheck == true) {
					$('#to_period').addClass('d-none').removeClass('d-block');

				} else {
					$('#to_period').addClass('d-block').removeClass('d-none');
				}
			})

			$('#edit_form_switch').on('click', function () {

				let isCheck = $('#check_edit').prop('checked');

				if (isCheck == true) {
					$('#to_period_edit').addClass('d-none').removeClass('d-block');

				} else {
					$('#to_period_edit').addClass('d-block').removeClass('d-none');
				}
			})

		});


		$('.edit').on('click',function (){
			let modal = $('#editEmployModal');
			modal.find('input[name="id"]').val($(this).data('id'));
			modal.find('input[name="company"]').val($(this).data('company'));
			modal.find('input[name="title"]').val($(this).data('title'));
			modal.find('input[name="city"]').val($(this).data('city'));
			modal.find('textarea[name="description"]').val($(this).data('description'));
			modal.find('.from_period_date').val($(this).data('from_period'));
			modal.find('.to_period_date').val($(this).data('to'));
			modal.find('input[name="present"]').val($(this).data('to'));

		});

		$('.delete').on('click',function (){
			let modal = $('#deleteModal');
			modal.find('input[name="id"]').val($(this).data('id'));
		})

		$(document).ready(function (){
			$(".period_date").flatpickr({
				altInput: true,
				altFormat: "d/m/y",
				dateFormat: "Y-m-d",
			});
			$(".from_period_date").flatpickr({
				altInput: true,
				altFormat: "d/m/y",
				dateFormat: "Y-m-d",
			});
			$(".to_period_date").flatpickr({
				altInput: true,
				altFormat: "d/m/y",
				dateFormat: "Y-m-d",
			});
		});

	</script>
@endpush
