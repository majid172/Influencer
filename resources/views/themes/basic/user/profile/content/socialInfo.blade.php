<div class="card-box skills mt-4">
	<div class="d-flex">
		<h4>@lang('Social Links')</h4>

		<button class="btn-action-icon bg-primary mx-2 mb-3" data-bs-toggle="modal" data-bs-target="#addSocialModal">
			<i class="fal fa-plus"></i>
		</button>
	</div>

	<div>
	@forelse($socialInfo as $item)
			<div class="d-flex">
				<span>  <a href="{{$item->link}}" target="_blank">  {{__($item->sitename)}} </a> </span>
				<button class="btn-action-icon bg-primary mx-2 mb-3 edit_social" data-bs-toggle="modal" data-bs-target="#editSocialModal" data-route="{{route('user.socialLink.update',$item->id)}}" data-sitename="{{__($item->sitename)}}" data-link="{{__($item->link)}}" data-icon="{{__($item->icon)}}" data-user_id="{{$item->user_id}}">
					<i class="fal fa-pencil"></i>
				</button>

				<button class="btn-action-icon bg-primary mx-2 mb-3 delete_social" data-bs-toggle="modal" data-bs-target="#deleteSocialModal"  data-route="{{route('user.socialInfo.delete',$item->id)}}">
					<i class="fal fa-trash"></i>
				</button>
			</div>
	@empty
		<div class="no_img">
			<div class="img-box text-center pt-3">
				<img src="{{asset($themeTrue.'images/no-data.png')}}" class="img-fluid no-data-img" alt="img" />
			</div>
			<div class="text-box">
				<p class="text-center">@lang('No social link available ')</p>
			</div>
		</div>
	@endforelse
	</div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editSocialModal" tabindex="-1" aria-labelledby="editSocialModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="editSocialModalLabel">@lang('Manage Social Link')</h5>
				<button type="button" class="close-btn" data-bs-dismiss="modal" aria-label="Close">
					<i class="fal fa-times"></i>
				</button>
			</div>
			<div class="modal-body">
				<div class="form-box mt-4">
					<form action="" method="post" enctype="multipart/form-data" class="acitonUrl">
						@csrf
						<div class="row g-4">

							<input type="hidden" name="user_id" value="">
							<div class="input-box col-md-6">
								<label for="sitename">@lang('Sitename')</label> <span class="text-danger">*</span>
								<input type="text" class="form-control" name="sitename" id="sitename" placeholder="@lang('Enter social sitename')" />
								<div class="text-danger">
									@error('sitename') @lang($message) @enderror
								</div>
							</div>


							<div class="input-box col-md-6">
								<label for="link">@lang('Link')</label> <span class="text-danger">*</span>
								<input type="text" class="form-control" name="link" id="link" placeholder="@lang('Enter social link')"/>
								<div class="text-danger">
									@error('link') @lang($message) @enderror
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


<div class="modal fade" id="deleteSocialModal" tabindex="-1" aria-labelledby="deleteSocialModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="deleteSocialModalLabel">@lang('Delete Social Link')</h5>
				<button type="button" class="close-btn" data-bs-dismiss="modal" aria-label="Close">
					<i class="fal fa-times"></i>
				</button>
			</div>
			<div class="modal-body">
				<div class="form-box mt-4">
					<form action="" method="post" enctype="multipart/form-data" class="actionDelete">
						@csrf
						<div class="row g-4">
							<p>@lang('Are you want to remove link?')</p>
							<div class="input-box col-12">
								<button type="submit" class="btn btn-danger">@lang('Delete')</button>
							</div>
						</div>
					</form>
				</div>
			</div>

		</div>
	</div>
</div>

<div class="modal fade" id="addSocialModal" tabindex="-1" aria-labelledby="addSocialModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="addSocialModalLabel">@lang('Add Social Links')</h5>
				<button type="button" class="close-btn" data-bs-dismiss="modal" aria-label="Close">
					<i class="fal fa-times"></i>
				</button>
			</div>
			<div class="modal-body">
				<div class="form-box mt-4">
					<form action="{{ route('user.socialLink.store') }}" method="post" enctype="multipart/form-data">
						@csrf
						<div class="row g-4">
							<input type="hidden" name="user_id" value="{{$user->id}}">
							<div class="input-box col-md-6">
								<label for="sitename">@lang('Sitename')</label> <span class="text-danger">*</span>
								<input type="text" class="form-control" name="sitename" id="sitename" placeholder="@lang('Enter social sitename')" />
								<div class="text-danger">
									@error('sitename') @lang($message) @enderror
								</div>
							</div>


							<div class="input-box col-md-6">
								<label for="link">@lang('Link')</label> <span class="text-danger">*</span>
								<input type="text" class="form-control" name="link" id="link" placeholder="@lang('Enter social link')"/>
								<div class="text-danger">
									@error('link') @lang($message) @enderror
								</div>
							</div>

							<div class="input-box col-12">
								<button type="submit" class="btn-custom">@lang('Submit')</button>
							</div>
						</div>
					</form>
				</div>
			</div>

		</div>
	</div>
</div>


@push('style')
	<link href="{{ asset('assets/dashboard/css/bootstrap-iconpicker.min.css') }}" rel="stylesheet" type="text/css">
@endpush

@push('script')
	<script src="{{ asset('assets/dashboard/js/bootstrap-iconpicker.bundle.min.js') }}"></script>

	<script>
		'use strict'
		$(document).ready(function () {
			$.uploadPreview({
				input_field: "#image-upload",
				preview_box: "#image-preview",
				label_field: "#image-label",
				label_default: "Choose File",
				label_selected: "Change File",
				no_label: false
			});
		});
		$('.iconPicker').iconpicker({
			align: 'center', // Only in div tag
			arrowClass: 'btn-danger',
			arrowPrevIconClass: 'fas fa-angle-left',
			arrowNextIconClass: 'fas fa-angle-right',
			cols: 10,
			footer: true,
			header: true,
			icon: 'fas fa-bomb',
			iconset: 'fontawesome5',
			labelHeader: '{0} of {1} pages',
			labelFooter: '{0} - {1} of {2} icons',
			placement: 'bottom', // Only in button tag
			rows: 5,
			search: true,
			searchText: 'Search icon',
			selectedClass: 'btn-success',
			unselectedClass: ''
		}).on('change', function (e) {
			$(this).parent().siblings('.icon').val(`${e.icon}`);
		});


		$('.edit_social').on('click',function (){
			let url = $(this).attr('data-route');
			let modal = $('#editSocialModal');
			modal.find('input[name="user_id"]').val($(this).data('user_id'))
			modal.find('input[name="sitename"]').val($(this).data('sitename'))
			modal.find('input[name="link"]').val($(this).data('link'))
			modal.find('input[name="icon"]').val($(this).data('icon'))
			$('.acitonUrl').attr('action',url);
		})

		$(".delete_social").on('click',function (){
			let url = $(this).attr('data-route');
			$('.actionDelete').attr('action',url);

		})

	</script>


@endpush
