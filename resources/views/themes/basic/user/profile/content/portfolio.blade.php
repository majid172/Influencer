
<div class="job-box">
	<a href="javascript:void(0)" class="job-title">@lang('Portfolio') ({{$portfolios->count()}})</a>

	<div class="row">
		@forelse($portfolios as $portfolio)
			<div class="col-lg-3">
				<div class="author-portfolio-box">
					<div class="img-box">
						<img class="img-fluid" src="{{getFile($portfolio->driver,$portfolio->image)}}" alt="portfolio_img">
						<div class="btn-grp d-flex">
							<button data-bs-toggle="modal" data-bs-target="#editPortfolioModal" class="btn-action-icon bg-danger mx-2 mb-3 edit" data-id="{{$portfolio->id}}" data-project_title="{{__($portfolio->project_title)}}" data-completion_date="{{$portfolio->completion_date}}" data-project_url="{{__($portfolio->project_url)}}" data-description="{{__($portfolio->description)}}" data-img="{{getFile($portfolio->driver,$portfolio->image)}}" data-image="{{__($portfolio->image)}}" data-driver="{{__($portfolio->driver)}}">
								<i class="fa-light fa-pencil"></i>
							</button>
							<button data-bs-toggle="modal" data-bs-target="#deletePortfolioModal" class="btn-action-icon bg-danger mx-2 mb-3 deletePortfolio" data-route="{{route('user.portfolio.delete',['id'=>$portfolio->id])}}">
								<i class="fa-light fa-trash"></i>
							</button>
						</div>
					</div>

					<p><a class="text-primary view" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#viewPortfolioModal" data-project_title="{{__($portfolio->project_title)}}" data-description="{{__($portfolio->description)}}"  data-img="{{getFile($portfolio->driver,$portfolio->image)}}" data-skills="{{__($portfolio->skills)}}"> {{ Illuminate\Support\Str::limit($portfolio->project_title, $limit = 25, $end = '...') }}
						</a></p>

				</div>
			</div>


		@empty
			<div class="">
				<div class="img-box text-center pt-3">
					<img src="{{asset($themeTrue.'images/no-data.png')}}" class="img-fluid no-data-img" alt="img" />
				</div>
				<div class="text-box">
					<p class="text-center">@lang('No portfolio information available ')</p>
				</div>
			</div>
		@endforelse
	</div>


	<div class="feedback">
		<button data-bs-toggle="modal" data-bs-target="#addPortfolioModal" class="">
			<i class="fa-light fa-plus"></i>
		</button>
	</div>
</div>

<div class="modal fade" id="addPortfolioModal" tabindex="-1" aria-labelledby="addPortfolioModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="addPortfolioModalLabel">@lang('Add Portfolio')</h5>
				<button type="button" class="close-btn" data-bs-dismiss="modal" aria-label="Close">
					<i class="fal fa-times"></i>
				</button>
			</div>
			<div class="modal-body">
				<form action="{{route('user.portfolio.create')}}" method="post" enctype="multipart/form-data">
					@csrf
					<div class="row g-3">
						<div class="input-box col-12">
							<label for="title">@lang('Project Title')</label> <span class="text-danger">*</span>
							<input type="text" name="title" id="title" class="form-control" placeholder="@lang('Enter a brife but descriptive title')" value="{{old('title')}}" />
							@if($errors->has('title'))
								<div class="error text-danger">@lang($errors->first('title')) </div>
							@endif
						</div>
						<div class="input-box col-6">
							<label for="date">@lang('Completion Date')</label> <span class="text-danger">*</span>
							<input type="text" name="completion_date" class="form-control complete_date" value="{{old('completion_date')}}"/>
							@if($errors->has('completion_date'))
								<div class="error text-danger">@lang($errors->first('completion_date')) </div>
							@endif
						</div>


						<div class="input-box col-6">
							<label for="title">@lang('Project URL')</label> <span class="text-danger">*</span>
							<input type="text" name="url" id="url" class="form-control" placeholder="@lang('Enter a project url')" value="{{old('url')}}" />
							@if($errors->has('url'))
								<div class="error text-danger">@lang($errors->first('url')) </div>
							@endif
						</div>


						<div class="input-box col-12">
							<label for="skills">@lang('Skills')</label> <span class="text-danger">*</span>
							<input type="text" class="form-control" name="skills" id="skills" data-role="tagsinput" value="{{ old('skills', $userProfile->skills) }}" placeholder="Keywords"/>
							@if($errors->has('skills'))
								<div class="error text-danger">@lang($errors->first('skills')) </div>
							@endif
						</div>


						<div class="col-md-6 form-group">
							<label for="image">@lang('Image')</label> <span class="text-danger">*</span>
							<div class="image-input">
								<label for="image-upload" id="image-label">
									<i class="fa-regular fa-upload"></i>
								</label>
								<input type="file" name="image" placeholder="@lang('Choose image')" id="image" >
								<img class="w-100 preview-image" id="image_preview_container" src="{{getFile(config('location.default'))}}" alt="@lang('Upload Image')">
							</div>
							@error('image')
							<span class="text-danger">@lang($errors->first('image'))</span>
							@enderror
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

<div class="modal fade" id="editPortfolioModal" tabindex="-1" aria-labelledby="editPortfolioModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="editPortfolioModalLabel">@lang('Edit Portfolio')</h5>
				<button type="button" class="close-btn" data-bs-dismiss="modal" aria-label="Close">
					<i class="fal fa-times"></i>
				</button>
			</div>
			<div class="modal-body">
				<form action="{{route('user.portfolio.update')}}" method="post" enctype="multipart/form-data">
					@csrf
					<input type="hidden" name="id">
					<div class="row g-3">
						<div class="input-box col-12">
							<label for="title">@lang('Project Title')</label> <span class="text-danger">*</span>
							<input type="text" name="title" id="title" class="form-control" placeholder="@lang('Enter a brife but descriptive title')" value="{{old('title')}}"/>
							@if($errors->has('title'))
								<div class="error text-danger">@lang($errors->first('title')) </div>
							@endif
						</div>
						<div class="input-box col-6">
							<label for="date">@lang('Completion Date')</label> <span class="text-danger">*</span>
							<input type="text" name="completion_date" class="form-control complete_date"/>

							@if($errors->has('completion_date'))
								<div class="error text-danger">@lang($errors->first('completion_date')) </div>
							@endif
						</div>

						<div class="input-box col-6">
							<label for="title">@lang('Project URL')</label> <span class="text-danger">*</span>
							<input type="text" name="url" id="url" class="form-control" placeholder="@lang('Enter a project url')" value="{{old('url')}}" />
							@if($errors->has('url'))
								<div class="error text-danger">@lang($errors->first('url')) </div>
							@endif
						</div>

						<div class="input-box col-12">
							<label for="skills">@lang('Skills')</label> <span class="text-danger">*</span>
							<input type="text" class="form-control" name="skills" id="skills" data-role="tagsinput" value="{{ old('skills', $userProfile->skills) }}" placeholder="Keywords"/>
							@if($errors->has('skills'))
								<div class="error text-danger">@lang($errors->first('skills')) </div>
							@endif
						</div>

						<div class="col-md-6 form-group">
							<label for="image">@lang('Image')</label> <span class="text-danger">*</span>
							<div class="image-input">
								<label for="image-upload" class="image-label">
									<i class="fa-regular fa-upload"></i>
								</label>
								<input type="file" name="image" placeholder="@lang('Choose image')" class="image" >
								<img class="w-100 preview-image" id="portfolio_image_preview_container"
									 src=""
									 alt="@lang('Upload Image')">
							</div>
							@error('image')
								<span class="text-danger">@lang($message)</span>
							@enderror
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

<div class="modal fade" id="deletePortfolioModal" tabindex="-1" aria-labelledby="deletePortfolioModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="deletePortfolioModalLabel">@lang('Delete Portfolio')</h5>
				<button type="button" class="close-btn" data-bs-dismiss="modal" aria-label="Close">
					<i class="fal fa-times"></i>
				</button>
			</div>
			<div class="modal-body">
				<form action="" method="post" enctype="multipart/form-data" class="actionUrl">
					@csrf
					<div class="row g-3">
						<div class="input-box col-12">
							<p>@lang('Are you want to remove it?')</p>
						</div>
					</div>

					<div class="modal-footer">
						<button type="button" class="btn btn-danger" data-bs-dismiss="modal">@lang('No')</button>
						<button type="submit" class="btn-custom">@lang('Yes')</button>
					</div>
				</form>
			</div>

		</div>
	</div>
</div>


<div class="modal fade" id="viewPortfolioModal" tabindex="-1" aria-labelledby="viewPortfolioModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">

			<div class="modal-body">
				<div class="row g-3">
					<div class="input-box col-12">
						<h5 class="title"></h5>
						<div class="img text-center">
							<img src="" id="img" alt="view_img" class="img-fluid ">
						</div>
						<div class="skills mt-3">
							<h6>@lang('Skills')</h6>
						</div>

						<div class="mt-3">
							<h6 class="font-weight-bold">@lang('Project Description')</h6>
							<p class="description"></p>
						</div>
					</div>

				</div>

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

	<script src="{{ asset($themeTrue.'js/image-uploader.js') }}"></script>
	<script>

		@error('portfolioCreateInfo')
			var addportfolio= new bootstrap.Modal(document.getElementById("addPortfolioModal"), {});
			document.onreadystatechange = function () {
				addportfolio.show();
			};
		@enderror

		@error('portfolioUpdateInfo')
			var editportfolio= new bootstrap.Modal(document.getElementById("editPortfolioModal"), {});
			document.onreadystatechange = function () {
				editportfolio.show();
			};
		@enderror

		$('.edit').on('click',function (){
			let id = $(this).data('id');
			let driver = $(this).data('driver');
			let image = $(this).attr('data-img');

			let modal = $("#editPortfolioModal");
			modal.find('input[name="id"]').val($(this).data('id'));
			modal.find('input[name="title"]').val($(this).data('project_title'))
			modal.find('textarea[name="description"]').val($(this).data('description'))
			modal.find('input[name="url"]').val($(this).data('project_url'))
			modal.find('.complete_date').val($(this).data('completion_date'))
			modal.find('.preview-image').attr('src',image)

			$('.error').text('')
		})

		$('.deletePortfolio').on('click',function (){
			let route = $(this).attr('data-route');
			$('.actionUrl').attr('action',route);
		});

		$('.view').on('click',function (){
			let modal = $('#viewPortfolioModal');
			let title = ($(this).data('project_title'))
			let skills = $(this).data('skills');
			let skillsArray = skills.split(',');
			let skillsContainer = modal.find('.skills');
			skillsContainer.empty();

			skillsArray.forEach(function(skill) {
				let tag = $('<a href="javascript:void(0)"></a>').text(skill);
				skillsContainer.append(tag);
			});
			let img = $(this).attr('data-img');
			modal.find('.title').text(title);
			modal.find('.description').text($(this).data('description'));
			modal.find('#img').attr('src',img)
		})

		$('.complete_date').flatpickr({
			altInput:true,
			altFormat:"d/m/y",
			dateFormat:"Y-m-d"
		})
	//	image upload
		$('.image').change(function () {
			let reader = new FileReader();
			reader.onload = (e) => {
				$('#portfolio_image_preview_container').attr('src', e.target.result);
			}
			reader.readAsDataURL(this.files[0]);
		});

	</script>
@endpush
