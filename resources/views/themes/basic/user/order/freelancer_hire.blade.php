@extends($theme.'layouts.user')
@section('title',__('Hiring Freelencer Lists'))
@section('content')
	<div class="col-xl-9 col-lg-8 col-md-12">
		<div class="d-flex flex-row justify-content-between">
			<h4>@lang('Freelancer Lists')</h4>

		</div>
		<!-- table -->
		<div class="table-parent table-responsive">
			<table class="table table-striped">
				<thead>
				<tr>
					<th>@lang('SL')</th>
					<th>@lang('Freelancer')</th>
					<th>@lang('Title')</th>
					<th>@lang('Duration')</th>
					<th>@lang('Action')</th>
				</tr>
				</thead>

				<tbody>
				@forelse($hires as $key => $item)
					<tr >
						<td data-label = "@lang('SL')">{{++$key }}</td>
						<td data-label="@lang('Freelancer')"> {{__(optional($item->proposser)->name)}}</td>
						<td data-label="@lang('Title')"> {{Str::limit(optional($item->job)->title,30)}}</td>

						<td data-label="@lang('Duration')">
							<div class="progress" id="progressBar_{{$item->id}}">
								<div class="progress-bar progress-bar-striped progress-bar-animated" id="bar" role="progressbar"  aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
							</div>
						</td>

						<td data-label="@lang('Action')">

								<a href="javascript:void(0)" data-id="{{$item->id}}" data-bs-toggle="modal" data-bs-target="#editModal" class="btn-action text-light expand" type="button" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="@lang('If influencer requests for extra time then client can update duration time.')">
									<i class="fa-light fa-clock me-2"></i>@lang('Time extend')
								</a>

								<a href="{{route('user.milestone.payment',[slug(optional($item->job)->title),$item->id])}}" class="btn-action text-light file" type="button" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="@lang('See all milestone list.')"><i class="fa-regular fa-eye me-2" id="icon"></i>@lang('Milestone')</a>

						</td>
					</tr>
				@empty
					<tr>
						<th colspan="100%" class="text-center">
							<img src="{{asset($themeTrue.'images/no-data.png')}}" alt="@lang('no-data')" class="no-data-img"> <br>
							@lang('No Data Found')</th>
					</tr>
				@endforelse
				</tbody>

			</table>
		</div>
	</div>

	<!-- update Modal -->
	<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="editModalLabel">@lang('Expand submission date time')</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<form method="post" action="{{route('user.hire.expand_date')}}">
					@csrf
					<input type="hidden" name="id">
					<div class="modal-body">
						<div class="col-lg-12 input-box">
							<p>
								<input class="form-control flatpickr_date" type="text" id="date" value="{{@request()->from_date}}" name="submit_date" placeholder="@lang('From Date')" autocomplete="off"/>
							</p>
						</div>
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-primary">@lang('Update')</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<!-- File download Modal -->
	<div class="modal fade" id="fileModal" tabindex="-1" aria-labelledby="fileModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="fileModalLabel">@lang('File Download')</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>

					<div class="modal-body">
						<div class="title">
							<h5 class="text-primary"></h5>
						</div>
						<div>
							<a href="#" class="file"></a>
						</div>
					</div>


			</div>
		</div>
	</div>


@endsection

@push('style')
	<link rel="stylesheet" href="{{asset($themeTrue.'css/flatpickr.min.css')}}">
@endpush

@push('extra-js')
	<script src="{{asset($themeTrue.'js/flatpickr.js')}}"></script>
@endpush

@push('scripts')

	<script>
		var hires = @json($hires);
		hires.forEach(function(item) {
			var startDate = new Date(item.created_at);
			var submitDate = new Date(item.submit_date);
			var currentDate = new Date();

			var totalDays = Math.ceil((submitDate - startDate) / (1000 * 60 * 60 * 24));
			var remainingDays = Math.ceil((submitDate - currentDate) / (1000 * 60 * 60 * 24));
			var progressPercentage = ((totalDays - remainingDays) / totalDays) * 100;


			var progressBar = document.getElementById('progressBar_' + item.id);
			var progressBarInner = progressBar.querySelector('.progress-bar');
			progressBarInner.style.width = progressPercentage + '%';
			progressBarInner.setAttribute('aria-valuenow', progressPercentage);

			if(remainingDays > 0)
			{
				progressBar.innerHTML += '<span>' + remainingDays + ' day\'s</span>';
			}
			else{
				progressBar.innerHTML += '<span>' + 'Expired' + '</span>'

			}
		});

		$(function(){
			var today = new Date().toISOString().split('T')[0];
			var dueDate = $("#dueDate");
			dueDate.attr('min',today);
			dueDate.on('input',function(){
				var chooseDate = $(this).val();

				if(chooseDate < new Date(today))
				{
					$(this).val(today);
				}

			});
		});

		$(document).ready(function (){
			$(".flatpickr_date").flatpickr({
				minDate: "today",
				altInput: true,
				altFormat: "d/m/y",
				dateFormat: "Y-m-d",
			});
		});

		$('.expand').on('click',function (){
			var modal = $('#editModal');
			var id = $(this).data('id');
			modal.find('input[name="id"]').val(id);
			modal.show();
		});

	</script>
@endpush
