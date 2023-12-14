@extends($theme.'layouts.user')
@section('title',__('Edit Listing'))

@push('css-lib')
	<link rel="stylesheet" href="{{asset($themeTrue.'css/tagsinput.css')}}" />
	<link rel="stylesheet" href="{{ asset($themeTrue.'css/rte_textEditor_theme_default.css') }}">
	<link rel="stylesheet" href="{{ asset($themeTrue.'css/image-uploader.css') }}">
	<link rel="stylesheet" href="{{ asset($themeTrue.'css/summernote.min.css') }}">
	<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
@endpush

@section('content')
	<div class="col-xl-9 col-lg-8 col-md-12">
		<h4>@lang('Edit Listings')</h4>

		<div class="form-box mt-4">
			<form action="{{ route('user.listing.update',$listing->id )}}" method="POST" enctype="multipart/form-data">
				@csrf
				<div class="row g-4">

					<div class="input-box col-md-12">
						<label for="yourself">@lang('Tell us a bit about yourself(Optional)')
							<button type="button" data-bs-toggle="tooltip" data-bs-placement="top"
									title="Give details, but don’t include your personal contact info.">
								<i class="fad fa-info-circle"></i>
							</button>
						</label>

						<p>@lang('Ex. I’m an Italian restaurant owner and I want to expand my business.')</p>
						<input class="form-control" name="title" value="{{@$listing->title}}" placeholder="@lang('I\'m a...')" ></input>
						<div class="text-danger">
							@error('title') @lang($message) @enderror
						</div>
					</div>

					<div class=" packages-pricing-factors">
						<table class="table table-striped">
							<thead>
							<tr>
								<th scope="col">@lang('NAME')</th>
								<th scope="col">@lang('BASIC')</th>
								<th scope="col">@lang('STANDARD')</th>
								<th scope="col">@lang('PREMIUM')</th>
							</tr>
							</thead>
							<tbody>
							<tr>
								<td></td>
								@foreach($listing->package as $package)
								<td>
									<input type="text" name="package_name[]" class="form-control"  value="{{$package['package_name']}}" placeholder="@lang('Name your package')">
								</td>
								@endforeach

							</tr>
							<tr>
								<td></td>

								@foreach($listing->package as $package)
								<td>
									<textarea class="form-control" name="package_desc[]" cols="30" rows="3" placeholder="@lang('Describe the details of your offering')">{{ $package['package_desc'] }}</textarea>
								</td>
								@endforeach

							</tr>
							<tr>
								<td>
									@lang('Delivery')
								</td>
								<td>
									<div class="input-box">
										<select class="js-example-basic-single form-control" name="delivery[]">
											<option value="">@lang('Delivery Time')</option>
											<option value="1">@lang('1 day delivery')</option>
											<option value="3">@lang('3 day delivery')</option>
											<option value="6">@lang('6 day delivery')</option>
											<option value="10">@lang('10 day delivery')</option>
										</select>
									</div>
								</td>
								<td>
									<div class="input-box">
										<select class="js-example-basic-single form-control" name="delivery[]">
											<option value="">@lang('Delivery Time')</option>
											<option value="1">@lang('1 day delivery')</option>
											<option value="3">@lang('3 day delivery')</option>
											<option value="6">@lang('6 day delivery')</option>
											<option value="10">@lang('10 day delivery')</option>

										</select>
									</div>
								</td>
								<td>
									<div class="input-box">
										<select class="js-example-basic-single form-control" name="delivery[]">
											<option value="">@lang('Delivery Time')</option>
											<option value="1">@lang('1 day delivery')</option>
											<option value="3">@lang('3 day delivery')</option>
											<option value="6">@lang('6 day delivery')</option>
											<option value="10">@lang('10 day delivery')</option>
										</select>
									</div>
								</td>
							</tr>

							<tr>
								<td>
									@lang('Revision\'s')
								</td>
								<td>
									<div class="input-box">
										<select class="js-example-basic-single form-control" name="revision[]">
											<option value="">@lang('Number of revision')</option>
											<option value="1">@lang('1 time revision')</option>
											<option value="2">@lang('2 time revision')</option>
											<option value="3">@lang('3 time revision')</option>
											<option value="4">@lang('Unlimited revision')</option>
										</select>
									</div>
								</td>

								<td>
									<div class="input-box">
										<select class="js-example-basic-single form-control" name="revision[]">
											<option value="type1">@lang('Number of revision')</option>
											<option value="1">@lang('1 time revision')</option>
											<option value="2">@lang('2 time revision')</option>
											<option value="3">@lang('3 time revision')</option>
											<option value="4">@lang('Unlimited revision')</option>
										</select>
									</div>
								</td>

								<td>
									<div class="input-box">
										<select class="js-example-basic-single form-control" name="revision[]">
											<option value="type1">@lang('Number of revision')</option>
											<option value="1">@lang('1 time revision')</option>
											<option value="2">@lang('2 time revision')</option>
											<option value="3">@lang('3 time revision')</option>
											<option value="4">@lang('Unlimited revision')</option>
										</select>
									</div>
								</td>
							</tr>

							<tr>
								<td>
									@lang('Price')
								</td>
								@foreach($listing->package as $pack )
								<td>
									<input type="number" class="form-control" name="extra_price[]" value="{{$pack['package_price']}}" placeholder="$">
								</td>
								@endforeach

							</tr>
							</tbody>
						</table>
					</div>

					<div class="col-md-6 form-group">
						<label for="image">@lang('Image')</label> <span class="text-danger">*</span>
						<div class="image-input">
							<label for="image-upload" id="image-label">
								<i class="fa-regular fa-upload"></i>
							</label>
							<input type="file" name="image" placeholder="@lang('Choose image')" id="image" >
							<img class="w-100 preview-image" id="image_preview_container"
								 src="{{getFile($listing->driver,$listing->image)}}"
								 alt="@lang('Upload Image')">
						</div>
						@error('image')
						<span class="text-danger">@lang($message)</span>
						@enderror
					</div>

					<div class="col-md-6 custom-margin">
						<label for="image">@lang('Image')</label> <span class="text-danger">*</span>
						<div class="listing-image h-100 listing-image-uploader"></div>
						<span class="text-danger"> @error('listing_image.*') @lang($message) @enderror</span>
					</div>


					<div class="input-box col-lg-6">
						<label for="category_id">@lang('Select Category')</label> <span class="text-danger">*</span>
						<select class="form-select js-example-basic-multiple-limit" name="category_id" aria-label="Default select example" id="category_id" required>
							<option value="" selected disabled>@lang('Select a Category')</option>
							@foreach($categories as $category)
								<option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
									{{ __(optional($category->details)->name) }}
								</option>
							@endforeach
						</select>
					</div>
					<div class="input-box col-lg-6">
						<label for="subCategory_id">@lang('Select a Sub Category')</label> <span class="text-danger">*</span>
						<select class="subCategoryHtml form-select js-example-basic-multiple-limit" name="subCategory_id" id="subCategoryId" aria-label="Default select example">
						</select>
						@error('subCategory_id')
							<span class="text-danger">@lang($message)</span>
						@enderror
					</div>
					<div class="input-box col-12">
						<label for="">@lang('Which industry are you in? (Optional)')</label>
						<input type="text" class="form-control" name="tag" id="tag" data-role="tagsinput" required value="{{$listing->tag}}" placeholder="@lang('Keywords')"/>
						<div class="text-danger d-flex flex-row justify-content-between">
							<small>@lang('*write keyword and press enter.')</small>
							<small>@lang('*5 tags maximum')</small>
						</div>
						<div class="text-danger">
							@error('tag') @lang($message) @enderror
						</div>
					</div>

					<div class="col-md-12 py-3">
						<div class="card">
							<div class="card-header d-flex flex-wrap align-items-center justify-content-between bgPrimary">
								<h5 class="card-title mb-0 textPrimary">
									@lang('Extra Services')
								</h5>
								<div class="card-btn">
									<button type="button" class="btn-action text-white addExtra"><i class="fas fa-add"></i> @lang('Add New')</button>
								</div>
							</div>
							<div class="card-body">
								<div class="row justify-content-center addExtraService">
									<div class="input-box col-lg-12 extraServiceRemove">
										@foreach($listing->extra_services as $service)
										<div class="row">
											<div class="col-xl-9 col-lg-12 form-group">
												<input type="text" name="extra_title[]" class="form-control" value="" placeholder="@lang('Enter Title')">
											</div>

											<div class="col-xl-2 col-lg-12 form-group">
												<div class="input-group mb-3">
													<input type="number" class="form-control" name="extra_price[]" placeholder="@lang('Enter Price')">
													<span class="input-group-text" id="basic-addon2">{{__($basic->currency_symbol)}}</span>
												</div>
											</div>
										</div>
										@endforeach
									</div>
								</div>
							</div>
						</div>
					</div>

					<!------- Faqs ------->
					<div class="col-md-12 py-3">
						<div class="card">
							<div class="card-header d-flex flex-wrap align-items-center justify-content-between bgPrimary">
								<h5 class="card-title mb-0 textPrimary">
									@lang('Frequently Asked Questios')
								</h5>
								<div class="card-btn">
									<button type="button" class="btn-action text-white addNewFaq"><i class="fas fa-add"></i> @lang('Add New')</button>
								</div>
							</div>
							<div class="card-body">
								<div class="row justify-content-center addFaqs">
									<div class="input-box col-lg-12 faqRemove mb-4">
										<div class="row">
											<div class="col-xl-11 col-lg-12 form-group mb-3">
												<input type="text" name="faq_title[]" class="form-control" placeholder="@lang('Enter FAQ Title')" required>
											</div>

											<div class="col-xl-11 col-lg-12 form-group">
												<div class="input-group mb-3">
													<textarea name="faq_description[]" class="form-control" placeholder="@lang('Enter FAQ Description')" cols="10" rows="10" required></textarea>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="col-md-12 py-3">
						<div class="card">
							<div class="card-header d-flex flex-wrap align-items-center justify-content-between bgPrimary">
								<h5 class="card-title mb-0 textPrimary">
									@lang('Requirements for Client')
								</h5>
								<div class="card-btn">
									<button type="button" class="btn-action text-white addNewRequirementQues"><i class="fas fa-add"></i> @lang('Add New')</button>
								</div>
							</div>
							<div class="card-body">
								<div class="row justify-content-center addRequirementsQues">
									<div class="input-box col-lg-12 requirementsQuesRemove mb-3">
										<div class="row">
											<div class="col-xl-11 col-lg-12 form-group mb-3">
												<input type="text" name="requirementsQues[]" class="form-control" placeholder="@lang('Enter Requirements Ques')" required>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="input-box col-md-12">
						<label for="description">@lang('Explain Your Listing in Brief')</label> <span class="text-danger">*</span>
						<textarea name="description" id="editor" cols="30" rows="10" class="form-control"  required>{{__($listing->description)}}</textarea>

						<div class="text-danger">
							@error('description') @lang($message) @enderror
						</div>
					</div>

					<div class="input-box col-12">
						<button type="submit" class="btn-custom">@lang('submit')</button>
					</div>
				</div>
			</form>
		</div>
	</div>
@endsection

@push('extra_scripts')
	<script src="{{ asset($themeTrue.'js/tagsinput.js') }}"></script>
	<script src="{{ asset($themeTrue.'js/textEditor_all_plugins.js') }}"></script>
	<script src="{{ asset($themeTrue.'js/textEditor_richeditor.js') }}"></script>
	<script src="{{ asset($themeTrue.'js/textEditor_rte.js') }}"></script>
@endpush

@push('scripts')
	<script src="{{asset($themeTrue.'js/summernote.min.js')}}"></script>
	<script src="{{ asset($themeTrue.'js/image-uploader.js') }}"></script>
	<script>

		$(document).ready(function() {
			$('#editor').summernote();
		});

		let listingImageOptions = {
			imagesInputName: 'listing_image',
			label: 'Drag & Drop files here or click to browse images',
			extensions: ['.jpg', '.jpeg', '.png'],
			mimes: ['image/jpeg', 'image/png'],
			maxSize: 5242880
		};

		$('.listing-image').imageUploader(listingImageOptions);

		$('#image').change(function () {
			let reader = new FileReader();
			reader.onload = (e) => {
				$('#image_preview_container').attr('src', e.target.result);
			}
			reader.readAsDataURL(this.files[0]);
		});


		$('#category_id').on('change', function(){
			var category = $(this).val();
			$.ajax({
				type:"POST",
				url:"{{route('user.get.subcategory')}}",
				data: {
					category : category,
					_token : '{{csrf_token()}}'
				},
				dataType: 'json',
				success:function(data){
					var html = '';
					if(data.error){
						$("#subCategoryId").empty();
						html += `<option value="" selected disabled>${data.error}</option>`;
						$(".subCategoryHtml").html(html);
					}
					else{
						$("#subCategoryId").empty();
						html += `<option value="" selected disabled>@lang('Select Sub Category')</option>`;
						$.each(data, function(index, item) {
							html += `<option value="${item.id}">${item.details.name}</option>`;
							$(".subCategoryHtml").html(html);
						});
					}
				}
			});
		});

		//packages
		$(document).on('click', '.addPackage', function () {
			var html = `
				<div class="input-box col-lg-12 extraPackageRemove">
					<div class="row">
						<div class="col-xl-3 col-lg-12 form-group">
							<input type="text" name="package_name[]" class="form-control" placeholder="@lang('Enter Title')" required>
						</div>
						<div class="col-xl-3 col-lg-12 form-group">
							<select type="text" name="revision[]" class="form-control" placeholder="@lang('Number of revision')">
								<option value="">@lang('Choose number of rivision')</option>
								<option value="1">@lang('1')</option>
								<option value="2">@lang('2')</option>
								<option value="3">@lang('3')</option>
								<option value="4">@lang('4')</option>
								<option value="5">@lang('Unlimited')</option>
							</select>
						</div>

						<div class="col-xl-3 col-lg-12 form-group">
							<select type="text" name="delivery[]" class="form-control" placeholder="@lang('Delivery Time')">
								<option value="">@lang('Choose your delivery time')</option>
								<option value="1">@lang('1 Day')</option>
								<option value="2">@lang('2 Days')</option>
								<option value="3">@lang('3 Days')</option>
								<option value="4">@lang('4 Days')</option>
								<option value="5">@lang('Unlimited')</option>
							</select>
						</div>

						<div class="col-xl-2 col-lg-12 form-group">
							<div class="input-group mb-3">
								<input type="number" class="form-control" name="package_price[]" placeholder="@lang('Enter Price')" required="">
								<span class="input-group-text" id="basic-addon2">{{__($basic->currency_symbol)}}</span>
							</div>
						</div>
						<div class="col-xl-1">
							<button type="button" class="btn-action text-white bg-danger cancelBtn btnHeight35">
								<i class="fa fa-times font16 p-1"></i>
							</button>
						</div>
					</div>
				</div>`;
			$('.addPackageService').append(html);
		});

		//remove extra packages
		$(document).on('click', '.cancelBtn', function () {
			$(this).closest('.extraPackageRemove').remove();
		});

		// extra service
		$(document).on('click', '.addExtra', function () {
			var html = `
				<div class="input-box col-lg-12 extraServiceRemove">
					<div class="row">
						<div class="col-xl-9 col-lg-12 form-group">
							<input type="text" name="extra_title[]" class="form-control" placeholder="@lang('Enter Title')" >
						</div>

						<div class="col-xl-2 col-lg-12 form-group">
							<div class="input-group mb-3">
								<input type="number" class="form-control" name="extra_price[]" placeholder="@lang('Enter Price')" required="">
								<span class="input-group-text" id="basic-addon2">{{__($basic->currency_symbol)}}</span>
							</div>
						</div>
						<div class="col-xl-1">
							<button type="button" class="btn-action text-white bg-danger removeBtn btnHeight35">
								<i class="fa fa-times font16 p-1"></i>
							</button>
						</div>
					</div>
				</div>`;
			$('.addExtraService').append(html);
		});

		// remove extra service row
		$(document).on('click', '.removeBtn', function () {
			$(this).closest('.extraServiceRemove').remove();
		});


		// Faqs
		$(document).on('click', '.addNewFaq', function () {

			var html = `
    <div class="input-box col-lg-12 faqRemove mb-4">
      <div class="row">
        <div class="col-xl-11 col-lg-12 form-group mb-3">
          <input type="text" name="faq_title[]" class="form-control" placeholder="@lang('Enter FAQ Title')" >
        </div>

        <div class="col-xl-11 col-lg-12 form-group">
          <div class="input-group mb-3">
            <textarea name="faq_description[]" class="form-control" placeholder="@lang('Enter FAQ Description')" cols="10" rows="10" required></textarea>
          </div>
        </div>
        <div class="col-xl-1">
          <button type="button" class="btn-action text-white bg-danger removeFaqBtn btnHeight35">
            <i class="fa fa-times font16 p-1"></i>
          </button>
        </div>
      </div>
    </div>`;
			$('.addFaqs').append(html);
		});

		// remove Faqs row
		$(document).on('click', '.removeFaqBtn', function () {
			$(this).closest('.faqRemove').remove();
		});

		// Requirements for Clients
		$(document).on('click', '.addNewRequirementQues', function () {
			var html = `
				<div class="input-box col-lg-12 requirementsQuesRemove mb-3">
					<div class="row">
						<div class="col-xl-11 col-lg-12 form-group mb-3">
							<input type="text" name="requirementsQues[]" class="form-control" placeholder="@lang('Enter Requirements Ques')" >
						</div>
						<div class="col-xl-1">
							<button type="button" class="btn-action text-white bg-danger removeRequirementQuesBtn btnHeight35">
								<i class="fa fa-times font16 p-1"></i>
							</button>
						</div>
					</div>
				</div>`;
			$('.addRequirementsQues').append(html);
		});

		// remove requirements clients row
		$(document).on('click', '.removeRequirementQuesBtn', function () {
			$(this).closest('.requirementsQuesRemove').remove();
		});


		// text editor
		var editor1 = new RichTextEditor("#div_editor1");


		// image
		$(document).on('click', '#image-label', function () {
			$('#image').trigger('click');
		});

		$('#image').change(function () {
			let reader = new FileReader();
			reader.onload = (e) => {
				$('#image_preview_container').attr('src', e.target.result);
			}
			reader.readAsDataURL(this.files[0]);
		});


		// documents count
		$(document).on('change', '#documents', function () {
			var fileCount = $(this)[0].files.length;
			$('.select-files-count').text(fileCount + ' file(s) selected');
		});

		$('#tag').tagsinput({
			maxTags: 5
		});

	</script>

	@if ($errors->any())
		@php
			$collection = collect($errors->all());
			$errors = $collection->unique();
		@endphp
		<script>
			"use strict";
			@foreach ($errors as $error)
			Notiflix.Notify.Failure("{{ trans($error) }}");
			@endforeach
		</script>
	@endif
@endpush
