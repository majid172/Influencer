<div class="job-box">
	<a href="javascript:void(0)" class="job-title">@lang('Work History') </a>

	@forelse($work_history as $data)
			<div class="info-box mt-2">
				<div class="d-flex align-items-center">
					<h6>{{__(optional($data->job)->title)}}</h6>
					<button class="btn-action-icon bg-danger mx-2 mb-3 delete" data-id="{{$data->id}}" data-bs-toggle="modal" data-bs-target="#deleteWorkModal" >
						<i class="fal fa-trash"></i>
					</button>
				</div>
				<p>
					@auth
					<span class="font-weight-bold"><b>@lang('Rate') : </b></span> <span> {{$basic->currency_symbol}} {{getAmount($data->rate)}} ; </span>
					@endauth
					<span> <b>@lang('Submit Date'): </b> </span> <span> {{$data->submit_date}}</span>
				</p>

			</div>

			<hr>

	@empty
		<div class="no_img">
			<div class="img-box text-center pt-3">
				<img src="{{asset($themeTrue.'images/no-data.png')}}" class="img-fluid no-data-img" alt="img"/>
			</div>
			<div class="text-box text-center">
				<a href="{{route('jobs')}}" class="text-center">@lang('Start your search')</a>
				<p>@lang('No work history available ')</p>
			</div>
		</div>
	@endforelse


</div>


<div class="modal fade" id="deleteWorkModal" tabindex="-1" aria-labelledby="deleteWorkModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="deleteWorkModalLabel">@lang('Delete Work History')</h5>
				<button type="button" class="close-btn" data-bs-dismiss="modal" aria-label="Close">
					<i class="fal fa-times"></i>
				</button>
			</div>
			<div class="modal-body">
				<form action="{{route('user.work.remove')}}" method="post" enctype="multipart/form-data">
					@csrf
					<input type="text" name="id">
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

@push('scripts')
	<script src="{{ asset($themeTrue.'js/image-uploader.js') }}"></script>
	<script>

		$(document).ready(function (){
			$(".completion_date").flatpickr({
				minDate: "today",
				altInput: true,
				altFormat: "d/m/y",
				dateFormat: "Y-m-d",
			});
		});

		$('.delete').on('click',function (){
			var modal = $('#deleteWorkModal');
			var id = $(this).data('id');

			modal.find('input[name="id"]').val(id);
			modal.show();
		});


	</script>
@endpush
