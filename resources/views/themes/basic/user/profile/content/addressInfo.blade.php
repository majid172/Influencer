
<div class="job-box">
	<a href="javascript:void(0)" class="job-title">@lang('Address')</a>

	<div class="influencer-box">
		<span><strong>@lang('Address') : </strong>  {{__($userProfile->address)?? 'N/A'}} @lang(';') </strong></span> <br>
		<span><strong>@lang('Postal Code') : </strong>  {{($userProfile->zip_code)??'N/A'}} @lang(';') </strong></span>
		<span><strong>@lang('City') : </strong>  {{__(optional($userProfile->getCity)->name)??'N/A'}} @lang(';') </strong></span>
		<span><strong>@lang('State') : </strong>  {{__(optional($userProfile->getState)->name) ?? 'N/A'}}@lang(';') </strong></span>
		<span><strong>@lang('Country') : </strong>  {{__(optional($userProfile->getCountry)->name) ?? 'N/A'}} </strong></span>
	</div>



	<div class="feedback">
		<button data-bs-toggle="modal" data-bs-target="#addressModal" class="">
			<i class="fa-light fa-pencil"></i>
		</button>
	</div>
</div>

<div class="modal fade" id="addressModal" tabindex="-1" aria-labelledby="addressModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="addressModalLabel">@lang('Address')</h5>
				<button type="button" class="close-btn" data-bs-dismiss="modal" aria-label="Close">
					<i class="fal fa-times"></i>
				</button>
			</div>
			<div class="modal-body">
				<form action="{{ route('user.address')}}" method="post">
					@csrf
					<div class="row g-4">

						<div class="input-box col-md-6">
							<label for="country_id">@lang('Country')</label> <span class="text-danger">*</span>
							<select class="form-select js-example-basic-multiple-limit" name="country_id" id="country_id" aria-label="Default select example">
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

						<div class="input-box col-md-6">
							<label for="state_id">@lang('State')</label> <span class="text-danger">*</span>
							<select id="state_id" class="form-select js-example-basic-multiple-limit" name='state_id' aria-label="Default select example"></select>
							@error('state_id')
							<span class="text-danger">@lang($message)</span>
							@enderror
						</div>

						<div class="input-box col-md-6">
							<label for="city_id">@lang('City')</label>
							<select id="city_id" class="form-select js-example-basic-multiple-limit" name="city_id" aria-label="Default select example"></select>
							@error('city_id')
							<span class="text-danger">@lang($message)</span>
							@enderror
						</div>

						<div class="input-box col-md-6">
							<label for="zip_code">@lang('Postal Code')</label>
							<input type="text" name="zip_code" id="zip_code" value="{{old('zip_code') ?? $userProfile->zip_code }}"
								class="form-control" onkeyup="this.value = this.value.replace (/^\.|[^\d\.]/g, '')" placeholder="@lang('Enter Postal Code')"
							/>
							@error('zip_code')
							<span class="text-danger">@lang($message)</span>
							@enderror
						</div>

						<div class="input-box col-12">
							<label for="address">@lang('Address')</label> <span class="text-danger">*</span>
							<textarea
								class="form-control"
								cols="30"
								rows="3"
								name="address"
								id="address"
								placeholder="@lang('Enter Your Address')">{{ old('address', $userProfile->address) }}</textarea>
							@error('address')
							<span class="text-danger">@lang($message)</span>
							@enderror
						</div>

						<div class="input-box col-12">
							<button type="submit" class="btn-custom w-100">@lang('save changes')</button>
						</div>

					</div>
				</form>
			</div>

		</div>
	</div>
</div>

@push('script')

	@if($errors->has('address') || $errors->has('city_id') || $errors->has('state_id') || $errors->has('zip_code') || $errors->has('country_id'))
		<script defer>
			var myModal = new bootstrap.Modal(document.getElementById("addressModal"), {});
			document.onreadystatechange = function () {
				myModal.show();
			};
		</script>
	@endif
	<script>

		var idCountry = $("#country_id").val();
		var selectedState = "{{$userProfile->state_id??null}}"
		var selectedCity = "{{$userProfile->city_id??null}}"

		getStates(idCountry, selectedState);
		getCities(selectedState, selectedCity);

		$(document).on('change', '#country_id', function () {
			var idCountry = this.value;
			$("#state_id").html('');
			getStates(idCountry);
		});

		$(document).on('change', '#state_id', function () {
			var idState = this.value;
			$("#city_id").html('');
			getCities(idState)
		});


		function getStates(idCountry, selectedState = null) {
			$.ajax({
				url: "{{route('user.states')}}",
				type: "POST",
				data: {
					country_id: idCountry,
					_token: '{{csrf_token()}}'
				},
				dataType: 'json',
				success: function (result) {
					$('#state_id').html('<option value="">@lang("Select State")</option>');
					$.each(result.states, function (key, value) {
						$("#state_id").append(`<option value="${value.id}" ${(value.id == selectedState) ? 'selected' : ''}>${value.name}</option>`);
					});
					$('#city_id').html(`<option value="">@lang("Select City")</option>`);
				}
			});
		}

		function getCities(idState = null, selectedCity = null) {
			$.ajax({
				url: "{{route('user.cities')}}",
				type: "POST",
				data: {
					state_id: idState,
					_token: '{{csrf_token()}}'
				},
				dataType: 'json',
				success: function (res) {
					$('#city_id').html(`<option value="">@lang("Select City")</option>`);
					$.each(res.cities, function (key, value) {
						$("#city_id").append(`<option value="${value.id}" ${(value.id == selectedCity) ? 'selected' : ''}>${value.name}</option>`);
					});
				}
			});
		}
	</script>
@endpush
