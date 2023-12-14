@extends($theme.'layouts.user')
@section('title',__('Create Job'))
@section('content')
<div class="col-xl-9 col-lg-8 col-md-12 change-password">
	<div class="form-box">
		<form method="post" action="{{ route('user.job.store') }}" enctype="multipart/form-data">
			@csrf
			<div class="row g-4">
				<!------- overview ------->
				<div class="input-box col-md-12">
					<label for="title">@lang('Title')</label> <span class="text-danger">*</span>
					<input type="text" class="form-control" name="title" id="title" placeholder="@lang('Enter Job\'s Title')"  maxlength="100" minlength="6" required value="{{ old('title') }}"/>
					<div class="text-danger">
						@error('title') @lang($message) @enderror
					</div>
				</div>

				<div class="input-box col-md-6">
					<label for="category_id">@lang('Select Category')</label> <span class="text-danger">*</span>
					<select class="form-select js-example-basic-multiple-limit" name="category_id" aria-label="Default select example"
						id="category_id" required>
						<option value="" selected disabled>@lang('Select a Category')</option>
						@foreach($categories as $category)
							<option
								value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
								{{ __(optional($category->details)->name) }}
							</option>
						@endforeach
					</select>
					@error('category_id')
						<span class="text-danger">@lang($message)</span>
					@enderror
				</div>

			<div class="input-box col-md-6">
				<label for="scope">@lang('Scope')</label>
				<select class="form-select js-example-basic-multiple-limit" name="scope" id="scope" aria-label="Default select example">
				<option value="" selected disabled>@lang('Select a scope')</option>
				@foreach ($scopes as $item)
				<option value="{{$item->id}}">{{$item->scope_type}} </option>
				@endforeach

				</select>

			</div>


			<div class="input-box col-12">
				<label for="">@lang('Skill\'s')</label> <span class="text-danger">*</span>
				<select class="js-example-basic-single form-control" name="skill[]" multiple="multiple">
					@foreach ($skills as $item)
						<option>{{$item->skill}}</option>
					@endforeach

				</select>
				<div class="text-danger d-flex flex-row justify-content-between">
					<small>@lang('*write keyword and press enter.')</small>
					<small>@lang('*5 tags maximum')</small>
				</div>
				<div class="text-danger">
					@error('tag') @lang($message) @enderror
				</div>
			</div>


			<div class="input-box col-md-6">
			<label for="experience">@lang('Experience')</label>
			<select class="form-select js-example-basic-multiple-limit" name="experience" id="experience" aria-label="Default select example" >
				<option value="" selected disabled>@lang('Select a experience')</option>
				<option value="1">@lang('Entry')</option>
				<option value="2">@lang('Intermidiate')</option>
				<option value="3">@lang('Expert')</option>
			</select>

			</div>

			<div class="input-box col-md-6">
			<label for="experience">@lang('Project Duration') <span class="text-danger">*</span> </label>
				<select name="duration" class="form-select js-example-basic-multiple-limit">

					@foreach ($durations as $item)
						@php
							$duration = ($item->duration)/($item->frequency);
						@endphp
						<option value="{{$item->duration}}">
							@if ($item->frequency == 1)
								{{$duration}} @lang('Day\'s')
							@elseif($item->frequency == 30)
								@if($duration > floor($duration))
									@lang('More than') {{floor($duration)}} @lang('Month\'s')
								@elseif($duration == floor($duration))
									{{floor($duration)}} @lang('Month\'s')
								@endif
							@elseif($item->frequency == 365)
								{{$duration}} @lang('Year')
							@endif
						</option>
					@endforeach
				</select>

			</div>

			<div class="input-box col-md-6">
			<label for="job_type">@lang('Budget Type')</label>
				<div class="row">
					<div class="col-lg-6">
						<div class="card-box">
							<div class="form-check">
								<input class="form-check-input" type="radio" name="job_type" id="type1" value="1" checked>
								<label class="form-check-label" for="type1">
									@lang('Hourly Rate')
								</label>
							</div>
						</div>
					</div>

					<div class="col-lg-6">
						<div class="card-box">
							<div class="form-check">
								<input class="form-check-input" type="radio" name="job_type" id="type2" value="2" checked>
								<label class="form-check-label" for="type2">
									@lang('Project Budget')
								</label>
							</div>
						</div>
					</div>

				</div>

			</div>


			<div class="input-box col-md-6 d-none" id="rate">
				<div class="row">
					<div class="col-md-6">
						<label for="from">@lang('Starting rate /hour')</label>
						<div class="input-group mb-3">
							<input type="number" min="1" name="start_rate" value="1" class="form-control">
							<span class="input-group-text" id="basic-addon2">{{__($basic->base_currency)}}</span>
						</div>
					</div>

					<div class="col-md-6">
						<label for="to">@lang('Ending rate /hour')</label>
						<div class="input-group mb-3">
							<input type="number" min="5" name="end_rate" value="5" class="form-control">
							<span class="input-group-text" id="basic-addon2">{{__($basic->base_currency)}}</span>
						</div>
					</div>
				</div>
			</div>

			<div class="input-box col-md-6 d-none" id="fixed_rate">
				<div class="row">
					<div class="col-md-12">
						<label for="from">@lang('Fixed rate')</label>
						<div class="input-group mb-3">

							<input type="number" min="1" name="fixed_rate" value="1" class="form-control">
							<span class="input-group-text" id="basic-addon2">{{__($basic->base_currency)}}</span>
						</div>
					</div>

				</div>
			</div>



				<!------- Requirements for Client ------->
			<div class="col-md-12 py-3">
				<div class="card">
					<div class="card-header d-flex flex-wrap align-items-center justify-content-between bgPrimary">
						<h5 class="card-title mb-0 textPrimary">
							@lang('Requirements for Proposal')
						</h5>
						<div class="card-btn">
							<button type="button" id="addNewButton" class="btn-action text-white addNewRequirementQues"><i class="fas fa-add"></i> @lang('Add New')</button>
						</div>
					</div>

					<div class="card-body">
						<div class="row justify-content-center addRequirementsQues">
							<div class="input-box col-lg-12 requirementsQuesRemove mb-3 template">
								<div class="row">
									<div class="col-xl-12 col-lg-12 d-flex form-group mb-3">
										<input type="text" name="requirementsQues[]" class="form-control" placeholder="@lang('Enter Requirements Ques')" required>
										<button class="btn btn-danger removeButton"><i class="fas fa-times"></i></button>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

					<!------- description ------->
			<div class="input-box col-md-12">
				<label for="description">@lang('Describe Job')</label> <span class="text-danger">*</span>
				<textarea name="description" id="div_editor1" cols="30" rows="10" class="form-control"  required>{{old('description')}}</textarea>

				<div class="text-danger">
					@error('description') @lang($message) @enderror
				</div>
			</div>

			<div class="input-box col-md-12">
				<label for="job_type">@lang('Upload Attachment')</label>
				<input type="file" class="form-control" name="attachment" >

			</div>

			<div class="input-box col-md-12">
				<label for="job_type">@lang('Note')</label>
				<input type="text" class="form-control" name="note">

			</div>

		<div class="input-box col-12">
			<button type="submit" class="btn-custom w-100">@lang('Create Job')</button>
		</div>
		</div>
		</form>
	</div>

</div>
@endsection

@push('scripts')

<script>
	"use strict";
 	$(document).ready(function() {
		$('#fixed_rate').show();
  		$('input[name="job_type"]').on('change',function() {

			var selectedValue = $('input[name="job_type"]:checked').val();
			if (selectedValue === '1') {
				$('#rate').show(200);
				$('#fixed_rate').hide(200);
			} else if (selectedValue === '2') {
				$('#rate').hide(200);
				$('#fixed_rate').show(200);
			}
    	});

		var fieldcount = 1;
		var maxInputField = 5;
		// add new extra input field
		$('#addNewButton').on('click',function(){

			// Clone the template element
			if(fieldcount < maxInputField)
			{
				var newInputField = $(".template").clone();
				newInputField.removeClass("template");
				$(".addRequirementsQues").append(newInputField);
				newInputField.find("input").val("");
				fieldcount++;
			}

		});

		$(document).on('click', '.removeButton', function() {
			$(this).closest('.input-box').remove();
			if(fieldCount > 1)
				fieldCount--;
		});

	});

	$(document).ready(function() {
		$('.js-example-basic-single').select2();

		$('.js-example-basic-single').on('change', function() {
			var selectedOptions = $(this).val();
			if (selectedOptions.length > 5) {
				$(this).val(selectedOptions.slice(0, 5));
				$(this).trigger('change');
			}
		});
	});
</script>

@endpush
