
<div class="job-box">
	<a href="javascript:void(0)" class="job-title">@lang('Certification')</a>
	@forelse($certificationInfo as $data)
		<div class="info-box mt-2">

			<div class="d-flex align-items-center">
				<h6>{{__($data->name)}}</h6>
				<button class="btn-action-icon bg-primary mx-2 mb-3 edit editCertificationModal" data-bs-toggle="modal" data-bs-target="#editCertificationModal" data-id="{{$data->id}}" data-name="{{__($data->name)}}" data-institution= "{{__($data->institution)}}" data-start="{{$data->start}}" data-end="{{$data->end}}" data-route="{{route('user.certificationInfoUpdate',$data->id)}}">
					<i class="fal fa-pencil"></i>
				</button>

				<button class="btn-action-icon bg-danger mx-2 mb-3 deleteCertification" data-bs-toggle="modal" data-bs-target="#deleteCertificationModal" data-route="{{route('user.certificationInfoDelete',$data->id)}}">
					<i class="fal fa-trash"></i>
				</button>
			</div>

			<h6>@lang('Institution'): <span>{{$data->institution}} </span> </h6>
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
				<p class="text-center">@lang('No certificational information available ')</p>
			</div>
		</div>
	@endforelse

	<div class="feedback">
		<button data-bs-toggle="modal" data-bs-target="#addCertificationModal" class="addCertificationModal">
			<i class="fa-light fa-plus"></i>
		</button>
	</div>
</div>

{{--Edit certification--}}
<div class="modal fade" id="editCertificationModal" tabindex="-1" aria-labelledby="editCertificationModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="editCertificationModalLabel">@lang('Edit Certification')</h5>
				<button type="button" class="close-btn" data-bs-dismiss="modal" aria-label="Close">
					<i class="fal fa-times"></i>
				</button>
			</div>
			<div class="modal-body">
				<form action="" method="post" class="aciton">
					@csrf
					<div class="row g-3">
						<div class="input-box col-12">
							<label for="name">@lang('name')</label> <span class="text-danger">*</span>
							<input type="text" name="name" class="form-control" placeholder="@lang('Certification Name')" value="{{old('name')}}" />
							@if($errors->has('name'))
								<div class="error text-danger">@lang($errors->first('name')) </div>
							@endif
						</div>
						<div class="input-box col-12">
							<label for="institution">@lang('Institution')</label> <span class="text-danger">*</span>
							<input type="text" name="institution" class="form-control" placeholder="@lang('Your Institution')"  value="{{old('institution')}}"/>
							@if($errors->has('institution'))
								<div class="error text-danger">@lang($errors->first('institution')) </div>
							@endif
						</div>
						<div class="input-box col-6">
							<label for="start">@lang('Start Date')</label> <span class="text-danger">*</span>
							<input type="text" name="start" class="form-control period_startdate"  required/>
							@if($errors->has('start'))
								<div class="error text-danger">@lang($errors->first('start')) </div>
							@endif
						</div>
						<div class="input-box col-6">
							<label for="end">@lang('End Date')</label> <span class="text-danger">*</span>
							<input type="text" name="end" class="form-control period_enddate" value="{{old('end')}}"/>
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


{{--Delete certificaiton--}}
<div class="modal fade" id="deleteCertificationModal" tabindex="-1" aria-labelledby="deleteCertificationModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="deleteCertificationModalLabel">@lang('Delete Certification')</h5>
				<button type="button" class="close-btn" data-bs-dismiss="modal" aria-label="Close">
					<i class="fal fa-times"></i>
				</button>
			</div>
			<div class="modal-body">
				<form action="" method="post" class="deleteUrl">
					@csrf
					<div class="row g-3">
						<p>@lang('Are you want to remove it?')</p>
					</div>

					<div class="modal-footer">
						<button type="submit" class="btn-custom-outline">@lang('Yes')</button>
					</div>
				</form>
			</div>

		</div>
	</div>
</div>

{{--add certificaiton--}}
<div class="modal fade" id="addCertificationModal" tabindex="-1" aria-labelledby="addCertificationModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="addCertificationModalLabel">@lang('Add New Certification')</h5>
				<button type="button" class="close-btn" data-bs-dismiss="modal" aria-label="Close">
					<i class="fal fa-times"></i>
				</button>
			</div>
			<div class="modal-body">
				<form action="{{route('user.certificationInfoCreate')}}" method="post">
					@csrf


					<div class="row g-3">
						<div class="input-box col-12">
							<label for="name">@lang('name')</label> <span class="text-danger">*</span>
							<input type="text" name="name" class="form-control" placeholder="@lang('Certification Name')" value="{{old('name')}}" />
							@if($errors->has('name'))
								<div class="error text-danger">@lang($errors->first('name')) </div>
							@endif
						</div>
						<div class="input-box col-12">
							<label for="institution">@lang('Institution')</label> <span class="text-danger">*</span>
							<input type="text" name="institution" class="form-control" placeholder="@lang('Your Institution')"  value="{{old('institution')}}"/>
							@if($errors->has('institution'))
								<div class="error text-danger">@lang($errors->first('institution')) </div>
							@endif
						</div>
						<div class="input-box col-6">
							<label for="start">@lang('Start Date')</label> <span class="text-danger">*</span>
							<input type="date" name="start" class="form-control period_date" value="{{old('start')}}" />
							@if($errors->has('start'))
								<div class="error text-danger">@lang($errors->first('start')) </div>
							@endif
						</div>
						<div class="input-box col-6">
							<label for="end">@lang('End Date')</label> <span class="text-danger">*</span>
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

			@error('certificationCreateInfo')
				var addCertification = new bootstrap.Modal(document.getElementById("addCertificationModal"), {});
				document.onreadystatechange = function () {
					addCertification.show();
				};
			@enderror

			@error('certificationEditInfo')
			var editCertification = new bootstrap.Modal(document.getElementById("editCertificationModal"), {});
			document.onreadystatechange = function () {
				editCertification.show();
			};
			@enderror

		$('.editCertificationModal').on('click', function (){
			var data =  $(this).data();
			let modal = $("#editCertificationModal");
			let url = $(this).attr('data-route');
			modal.find('input[name="name"]').val(data.name)
			modal.find('input[name="institution"]').val(data.institution)
			modal.find('.period_startdate').val(data.start)
			modal.find('.period_enddate').val(data.end)
			$(".aciton").attr('action',url)
			$('.error').text('')
		})
		$('.deleteCertification').on('click',function (){
			$('.deleteUrl').attr('action',$(this).attr('data-route'));
		});

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
