@extends('admin.layouts.master')
@section('page_title',__('Listing Service Fee'))

@section('content')
	<div class="main-content">
		<section class="section">
			<div class="section-header">
				<h1>@lang('Listing Service Fee')</h1>
				<div class="section-header-breadcrumb">
					<div class="breadcrumb-item active">
						<a href="{{route('admin.home')}}">@lang('Dashboard')</a>
					</div>
					<div class="breadcrumb-item">@lang('Listing Service Fee')</div>
				</div>
			</div>

			<div class="row">
				<div class="col-12">
					<div class="card card-primary shadow">
						<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
							<h6 class="m-0 font-weight-bold text-primary">@lang('Service Fee')</h6>
							<div class="media mb-4 float-right">

								<button type="button" class="btn btn-sm btn-outline-primary mr-2" data-toggle="modal" data-target="#exampleModalCenter"><span><i class="fa fa-plus-circle"></i>@lang('Add New')</span>
								</button>
							</div>
						</div>

						<div class="card-body">
							<div class="table-responsive">
								<table class="table table-striped table-hover align-items-center table-borderless" id="category-table">
									<thead>
									<tr>
										<th data-label="@lang('SL')">@lang('SL')</th>
										<th data-label="@lang('Level')">@lang('Level')</th>
										<th data-label="@lang('Percentage')">@lang('Percentage')</th>
										<th data-label="@lang('Status')">@lang('Status')</th>
										<th data-label="@lang('Action')">@lang('Action')</th>
									</tr>
									</thead>
									<tbody>

									@forelse($fees as $key=>$fee)
										<tr>
											<td data-label="@lang('SL No.')">{{$loop->index+1}}</td>
											<td data-label="@lang('Level')">{{@$fee->levels->details->name}}</td>
											<td data-label="@lang('Percentage')">{{$fee->percentage}}%</td>
											<td data-label="@lang('Action')">
												@if($fee->status == 1)
												<span class="badge badge-success">@lang('Active')</span>
												@else
													<span class="badge badge-danger">@lang('Inactive')</span>
												@endif
											</td>
											<td data-label="@lang('Edit')">

												<button type="button" class="btn btn-sm btn-outline-primary mr-2 edit" data-toggle="modal" data-target="#editModal" data-id="{{$fee->id}}" data-percentage="{{$fee->percentage}}" data-lavel="{{$levels}}">
													<span><i class="fa fa-pen pr-1"></i>@lang('Edit')</span>
												</button>

												@if($fee->status == 1)
													<a href="{{route('admin.listing.service.fee.status',$fee->id)}}" class="btn btn-outline-danger">
														<span><i class="fas fa-regular fa-toggle-off pr-1"></i>@lang('Inactive')</span>
													</a>
												@else
													<a href="{{route('admin.listing.service.fee.status',$fee->id)}}" class="btn btn-outline-success">
														<span><i class="fas fa-regular fa-toggle-on pr-1"></i>@lang('Active')</span>
													</a>
												@endif

											</td>

										</tr>
									@empty
										<tr>
											<th colspan="100%" class="text-center">
												<img src="{{asset('assets/global/no-data.png')}}" alt="@lang('no-data')" class="no-data-img">
												<br>
												@lang('No data found')</th>
										</tr>

									@endforelse
									</tbody>
								</table>
							</div>
						</div>



					</div>
				</div>
			</div>

		</section>
	</div>

	{{-- generate service fees modal--}}
	<div class="service-generator modal fade" id="exampleModalCenter"  tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLongTitle">@lang('Service Fee')</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>

				<div>
					<div class="card-body">

						<div class="row  formFiled justify-content-center ">

							<div class="col-md-6">
								<div class="form-group">
									<label class="font-weight-bold">@lang('Set Level')</label>
									<input type="number" id="numberOfInput" name="level" placeholder="Number Of Level" class="form-control  numberOfLevel">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>&nbsp;</label>
									<button type="button" class="btn btn-primary btn-block  makeForm " id="generate">
										<i class="fa fa-spinner"></i> @lang('GENERATE') </button>
								</div>
							</div>


						</div>

						<form action="{{ route('admin.listing.fee.store') }}" method="POST" class="form-row" id="serviceForm">
							@csrf
							<div class="col-md-12 newFormContainer"></div>

							<div class="col-md-12">
								<button type="submit" class="btn btn-primary btn-block mt-3 submit-btn" id="submitBtn">@lang('Submit')</button>
							</div>
						</form>


					</div>
				</div>
			</div>
		</div>
	</div>


{{--	<!-- Modal -->--}}
	<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLongTitle">@lang('Edit service fee')</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>

				<form action="{{route('admin.listing.fee.update')}}" method="POST">
					@csrf
					<div class="modal-body">
						<input type="hidden" name="id">
						<div>
							<div class="col-12 mb-2">
								<label for="level">@lang('Level')</label>
								<select name="level_id" class="form-control type-select">
									<option value="">@lang('Select any option')</option>
									@foreach($levels as $level)
										<option value="{{$level->id}}">{{__($level->details->name)}}</option>
									@endforeach
								</select>
							</div>

							<div class="col-12">
								<label for="">@lang('percentage')</label>
								<input type="number" class="form-control" name="percentage" id="fixed">
							</div>

						</div>

					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-primary">@lang('Edit Fee')</button>
					</div>
				</form>
			</div>
		</div>
	</div>

@endsection

@section('scripts')
	<script>
		$(document).ready(function(){
			$('#flat').hide();
			$('input[name="type"]').change(function() {
				var selectedValue = $('input[name="type"]:checked').val();

				if (selectedValue === '1') {
					$('#range').show();
				}
				else if (selectedValue === '0') {
					$('#range').hide();
				}
			});

			$('.edit').on('click', function() {
				var type = $(this).data('type');
				var modal = $('#editModal');
				modal.find('input[name="id"]').val($(this).data('id'));
				modal.find('input[name="percentage"]').val($(this).data('percentage'));
				modal.show();
			});


			// change status
			$('.status').on('click',function(){
				let url = $(this).data('route');
				$('.status').attr('action',url);

			});
		});
	</script>

	<script>
		$(document).ready(function(){
			$(".makeForm").on('click', function () {
				var levelGenerate = $(this).parents('.formFiled').find('.numberOfLevel').val();
				var value = 1;
				var viewHtml = '';
				const levels = @json($levels);

				if (levelGenerate !== '' && levelGenerate > 0) {
					for (var i = 0; i < parseInt(levelGenerate); i++) {
						viewHtml += `<div class="input-group mt-4">
                <input type="hidden" name="levelGenerate" value="${levelGenerate}">
                <div class="input-group-prepend">
                    <span class="input-group-text no-right-border">LEVEL #${value++}</span>
                </div>
                <select name="level[]" class="form-control type-select">
                    <option value="">@lang('Select any option')</option>`;

						levels.forEach(function (level) {

							viewHtml += `<option value="${level.id}">${level.details.name}</option>`; // Use fee.name for option text
						});

						viewHtml += `</select>
                <input name="percentage[]" class="form-control" type="number" required placeholder="@lang('Charge')">
                <span class="input-group-btn">
                    <button class="btn btn-danger removeForm" type="button"><i class='fa fa-trash-alt'></i></button>
                </span>
            </div>`;
					}

					$('.newFormContainer').html(viewHtml);
					$('.submit-btn').addClass('d-block');
					$('.submit-btn').removeClass('d-none');

					$('.type-select').change(function () {
						var selectedType = $(this).val();
						var rangeInput = $(this).closest('.input-group').find('.range-input');

						if (selectedType === '1') {
							rangeInput.hide();
						} else {
							rangeInput.show();
						}
					});
				} else {
					$('.submit-btn').addClass('d-none');
					$('.submit-btn').removeClass('d-block');
					$('.newFormContainer').html('');
					Notiflix.Notify.Failure("@lang('Please Set the number of level')");
				}
			});
		});
	</script>
@endsection
