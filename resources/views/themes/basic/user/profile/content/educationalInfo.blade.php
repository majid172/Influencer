
<div class="job-box">
	<a href="javascript:void(0)" class="job-title">@lang('Education')</a>

	@forelse($educationInfo as $data)
		<div class="info-box mt-2">

			<div class="d-flex align-items-center">
				<h6>{{__($data->degree)}}</h6>
				<button class="btn-action-icon bg-primary mx-2 mb-3 edu_edit" data-bs-toggle="modal" data-bs-target="#editEducationModal" data-id="{{$data->id}}" data-degree="{{__($data->degree)}}" data-institution= "{{__($data->institution)}}" data-start="{{$data->start}}" data-end="{{$data->end}}" data-route="{{route('user.educationInfoUpdate',$data->id)}}">
					<i class="fal fa-pencil"></i>
				</button>

				<button class="btn-action-icon bg-primary mx-2 mb-3 edu_delete" data-bs-toggle="modal" data-bs-target="#deleteEducationModal"  data-route="{{route('user.educationInfoDelete',$data->id)}}">
					<i class="fal fa-trash"></i>
				</button>
			</div>
			<h6>@lang('Institution'): <span>{{__($data->institution)}} </span> </h6>
			<p> <span>{{dateTime($data->start,'d M, Y')}} - @if(isset($data->end))
						{{dateTime(@$data->end,'d M, Y')}}
					@else
						@lang('N/A')
					@endif
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
				<p class="text-center">@lang('No Educational information available ')</p>
			</div>
		</div>
	@endforelse

		<div class="feedback">
			<button data-bs-toggle="modal" data-bs-target="#addEducationModal" class="">
				<i class="fa-light fa-plus"></i>
			</button>
		</div>
</div>

<div class="modal fade" id="editEducationModal" tabindex="-1" aria-labelledby="editEducationModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="editEducationModalLabel">@lang('Edit Educational Information')</h5>
				<button type="button" class="close-btn" data-bs-dismiss="modal" aria-label="Close">
					<i class="fal fa-times"></i>
				</button>
			</div>
			<div class="modal-body">
				<form action="" method="post" class="updateForm">
					@csrf
					<div class="row g-3">
						<input type="hidden" name="id">
						<div class="input-box col-12">
							<label for="degree">@lang('Degree')</label> <span class="text-danger">*</span>
							<input type="text" name="degree" class="form-control" placeholder="@lang('Your Degree')" value="{{old('degree')}}" required/>
							@if($errors->has('degree'))
								<div class="error text-danger">@lang($errors->first('degree')) </div>
							@endif
						</div>
						<div class="input-box col-12">
							<label for="institution">@lang('Institution')</label> <span class="text-danger">*</span>
							<input type="text" name="institution" class="form-control" placeholder="@lang('Your Institution')" required value="{{old('institution')}}"/>
							@if($errors->has('institution'))
								<div class="error text-danger">@lang($errors->first('institution')) </div>
							@endif
						</div>
						<div class="input-box col-6">
							<label for="start">@lang('Start Date')</label> <span class="text-danger">*</span>
							<input type="date" name="start" class="form-control period_startdate" value="{{old('start')}}" required/>
							@if($errors->has('start'))
								<div class="error text-danger">@lang($errors->first('start')) </div>
							@endif
						</div>
						<div class="input-box col-6">
							<label for="end">@lang('End Date')</label>
							<input type="date" name="end" class="form-control period_enddate" value="{{old('end')}}"/>
							@if($errors->has('end'))
								<div class="error text-danger">@lang($errors->first('end')) </div>
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

<div class="modal fade" id="deleteEducationModal" tabindex="-1" aria-labelledby="deleteEducationModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="deleteEducationModalLabel">@lang('Delete Educational Information')</h5>
				<button type="button" class="close-btn" data-bs-dismiss="modal" aria-label="Close">
					<i class="fal fa-times"></i>
				</button>
			</div>
			<div class="modal-body">
				<form action="" method="post" class="edu_deleteAction">
					@csrf
					<div class="row g-3">
						<p>@lang('Are you want to remove it?')</p>
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


{{--add--}}
<div class="modal fade" id="addEducationModal" tabindex="-1" aria-labelledby="addEducationModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="addEducationModalLabel">@lang('Add Education')</h5>
				<button type="button" class="close-btn" data-bs-dismiss="modal" aria-label="Close">
					<i class="fal fa-times"></i>
				</button>
			</div>
			<div class="modal-body">
				<form action="{{route('user.educationInfoCreate')}}" method="post">
					@csrf
					<div class="row g-3">

						<div class="input-box col-12">
							<label for="degree">@lang('Degree')</label> <span class="text-danger">*</span>
							<input type="text" name="degree" class="form-control" placeholder="@lang('Your Degree')" value="{{old('degree')}}" />
							@if($errors->has('degree'))
								<div class="error text-danger">@lang($errors->first('degree')) </div>
							@endif
						</div>
						<div class="input-box col-12">
							<label for="institution">@lang('Institution')</label> <span class="text-danger">*</span>
							<input type="text" name="institution" class="form-control" placeholder="@lang('Your Institution')"  value="{{old('institution')}}"/>
							@if($errors->has('institution'))
								<div class="error text-danger">@lang($errors->first('institution')) </div>
							@endif
						</div>
						<div class="input-box col-12">
							<label for="start">@lang('Start Date')</label> <span class="text-danger">*</span>
							<input type="date" name="start" class="form-control period_date" value="{{old('start')}}" />
							@if($errors->has('start'))
								<div class="error text-danger">@lang($errors->first('start')) </div>
							@endif
						</div>
						<div class="input-box col-12">
							<label for="end">@lang('End Date')</label>
							<input type="date" name="end" class="form-control period_date" value="{{old('end')}}"/>
							@if($errors->has('end'))
								<div class="error text-danger">@lang($errors->first('end')) </div>
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

@push('script')

	<script>
		@error('educationCreateInfo')
		var addEducation= new bootstrap.Modal(document.getElementById("addEducationModal"), {});
		document.onreadystatechange = function () {
			addEducation.show();
		};
		@enderror

		@error('educationUpdateInfo')
			var editEducation= new bootstrap.Modal(document.getElementById("editEducationModal"), {});
			document.onreadystatechange = function () {
				editEducation.show();
			};
		@enderror

		$('.edu_edit').on('click',function (){
			let id = $(this).data('id');
			let modal = $("#editEducationModal");
			let url = $(this).attr('data-route');
			modal.find('input[name="degree"]').val($(this).data('degree'))
			modal.find('input[name="institution"]').val($(this).data('institution'))
			modal.find('.period_startdate').val($(this).data('start'))
			modal.find('.period_enddate').val($(this).data('end'))
			$(".updateForm").attr('action',url)

			$('.error').text('')
		});

		$('.edu_delete').on('click',function (){
			$('edu_deleteAction').attr('action',$(this).attr('data-route'));
		})

		$(document).ready(function (){
			$(".period_date").flatpickr({
				altInput: true,
				altFormat: "d/m/y",
				dateFormat: "Y-m-d",
			});
			$(".period_startdate").flatpickr({
				altInput: true,
				altFormat: "d/m/y",
				dateFormat: "Y-m-d",
			});
			$(".period_enddate").flatpickr({
				altInput: true,
				altFormat: "d/m/y",
				dateFormat: "Y-m-d",
			});
		});

	</script>
@endpush
