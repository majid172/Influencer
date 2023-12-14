@extends($theme.'layouts.user')
@section('title',__('Order'))
@section('content')
	<div class="col-xl-9 col-lg-8 col-md-12">
		<div class="d-flex flex-row justify-content-between">
			<h4>@lang('Order Lists')</h4>

		</div>
		<!-- table -->
		<div class="table-parent table-responsive">
			<table class="table table-striped">
				<thead>
				<tr>
					<th>@lang('SL')</th>
					<th>@lang('Client')</th>
					<th>@lang('Title')</th>
					<th>@lang('Duration')</th>
					<th>@lang('Action')</th>
				</tr>
				</thead>

				<tbody>
				@forelse($orders as $key => $item)
					<tr>
						<td class="p-3" data-label = "@lang('SL')">{{++$key }}</td>
						<td class="p-3" data-label="@lang('Freelancer')"> {{__(optional($item->client)->name)}}</td>
						<td data-label="@lang('Title')"> {{Str::limit(optional($item->job)->title,30)}}</td>

						<td data-label="@lang('Duration')">
							<div class="progress" id="progressBar_{{$item->id}}">
								<div class="progress-bar progress-bar-striped progress-bar-animated" id="bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
							</div>
						</td>
						<td data-label="@lang('Action')">
							<div class="d-flex">
								@if($item->deposit_type == 1)
									<a href="{{route('user.except.milestone.payment',$item->id)}}" class="btn-action text-light file" type="button" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="@lang('See all milestone list.')"><i class="fa-regular fa-eye me-2" id="icon"></i>@lang('Milestone')</a>
								@elseif($item->deposit_type == 2)
									<a href="{{route('user.milestone.payment',[slug(optional($item->job)->title),$item->id])}}" class="btn-action text-light file" type="button" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="@lang('See all milestone list.')"><i class="fa-regular fa-eye me-2" id="icon"></i>@lang('Milestone')</a>
								@endif
							</div>
						</td>
					</tr>
				@empty
					<tr>
						<th colspan="100%" class="text-center">
							<img src="{{asset($themeTrue.'images/no-data.png')}}" alt="@lang('no-data')" class="no-data-img"> <br>
							@lang('No data found')</th>
					</tr>
				@endforelse
				</tbody>

			</table>
		</div>
	</div>
@endsection

@push('scripts')
	<script>
		var orders = @json($orders);
		orders.forEach(function(item) {
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

		$('.fileUpload').on('click',function (){
			let modal = $('#fileModal');
			let hire_id = $(this).data('id')
			let title = $(this).attr('data-job_title');
			let description= $(this).attr('data-job_description');
			modal.find('input[name="hire_id"]').val(hire_id);
			modal.find('.title h5').html(title);
			modal.find('.description p').html(description);
			modal.show();
		});
	</script>
@endpush
