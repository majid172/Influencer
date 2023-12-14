@extends($theme.'layouts.user')
@section('title',__('Sent/Received Money List'))

@section('content')
	<div class="col-xl-9 col-lg-8 col-md-12">
		<div class="row mb-3">
			<div class="container-fluid" id="container-wrapper">
				<div class="row">
					<div class="col-lg-12">
						<div class=" mb-4 ">
							<div class=" py-3 d-flex flex-row align-items-center justify-content-between">
								<h4 class="m-0 font-weight-bold text-primary">@lang('Transactions List')</h4>
							</div>
							<h5>@lang('Balance'):<span class="text-primary"> {{$basic->currency_symbol}}{{getAmount(auth()->user()->balance)}}</span> </h5>

							<div class=" py-3 d-flex flex-row align-items-center justify-content-between">
								<div class="form-group">
									<label for="date">@lang('Statement Period')</label>
									<input class="form-control flatpickr_date" type="text" id="start_date" value="{{@request()->from_date}}"
										   name="delivery_date" placeholder="@lang('From Date')" autocomplete="off"/>

								</div>
								<div class="form-group">
									<label for="status">@lang('Transactional Status')</label>
									<div class="input-box">
										<select class="js-example-basic-single form-control" id="status" name="status">
											<option value="">@lang('Choose your option')</option>
											<option value="0">@lang('Pending')</option>
											<option value="1">@lang('Success')</option>

										</select>
									</div>
								</div>
								<form action="{{route('transfer.export')}}" method="get" class="align-self-end">
									@foreach($transfers as $key => $value)

											<input type="hidden" name="data[{{ $key }}][SL.]"
												   value="{{$key+1}}">
											<input type="hidden" name="data[{{ $key }}][Date]"
												   value="{{$value->created_at}}">

											<input type="hidden" name="data[{{ $key }}][Gateway]" value="{{__(@$value->depositable->gateway->name)??'Wallet'}}">

											<input type="hidden" name="data[{{ $key }}][Amount]" value="{{$basic->currency_symbol}}{{ getAmount($value->amount)}}">
											<input type="hidden" name="data[{{ $key }}][Trx. ID]"
												   value="{{ __($value->utr) }}">
										<input type="hidden" name="data[{{ $key }}][Status]"
												   value="@if($value->status)
													Success
										@else
											Pending
										@endif">

									@endforeach
									<input type="hidden" name="file_name" value="Transfer">
									<button type="submit" class="btn btn-primary btn-sm export-button-width"><i class="fa-regular fa-file-excel"></i>
										@lang('Export CSV')
									</button>
								</form>
							</div>


							<div class="table-responsive">
								<table class="table table-striped table-hover align-items-center table-borderless">
									<thead class="thead-light">
									<tr>
										<th>@lang('Date')</th>
										<th>@lang('Gateway')</th>
										<th>@lang('Amount')</th>
										<th>@lang('Trx Number')</th>
										<th>@lang('Type')</th>
										<th>@lang('Status')</th>
									</tr>
									</thead>
									<tbody class="tbody">

									@forelse($transfers as $key => $value)
										<tr>
											<td data-label="@lang('date')">{{$value->created_at}}</td>

											<td data-label="@lang('Gateway')">{{__(optional(optional($value->depositable)->gateway)->name)??'Wallet'}}</td>

											<td data-label="@lang('Amount')">{{$basic->currency_symbol}}{{ getAmount($value->amount)}} </td>
											<td data-label="@lang('Transaction ID')">{{ __($value->utr) }}</td>

											<td data-label="@lang('Type')">
												@if($value->sender_id == Auth::id())
													<span class="badge badge-info">@lang('Sent')</span>
												@else
													<span class="badge badge-success">@lang('Received')</span>
												@endif
											</td>
											<td data-label="@lang('Status')">
												@if($value->status)
													<span class="badge badge-success">@lang('Success')</span>
												@else
													<span class="badge badge-warning">@lang('Pending')</span>
												@endif
											</td>
										</tr>
									@empty
										<tr>
											<th colspan="100%" class="text-center">@lang('No data found')</th>
										</tr>
									@endforelse
									</tbody>
								</table>
							</div>
							<div class="">
								{{ $transfers->links() }}
							</div>

						</div>
					</div>
				</div>
			</div>
		</div>

	</div>
@endsection

@push('css-lib')
	<link rel="stylesheet" href="{{asset($themeTrue.'css/flatpickr.min.css')}}">
	<style>
		.flatpickr-day.selected, .flatpickr-day.startRange{
			background: #7863df;
			border-color: #7863df;
		}
	</style>
@endpush
@push('extra-js')
	<script src="{{asset($themeTrue.'js/flatpickr.js')}}"></script>
	<script>
		$(document).ready(function (){
			$("#start_date").flatpickr({
				mode:'range',
				altInput: true,
				altFormat: "d/m/y",
				dateFormat: "Y-m-d",

			});

		});
	</script>
@endpush

@push('scripts')
<script>
	$('#start_date').on('input',function (){
		let val = $('#start_date').val();
		var dates = val.split(" to ");
		var start = dates[0];
		var end = dates[1];
		var startObj = new Date(start);
		var endObj = new Date(end);
		var startDate = startObj.toLocaleDateString('en-US', { day: 'numeric', month: 'short', year: 'numeric' });
		var endDate = endObj.toLocaleDateString('en-US', { day: 'numeric', month: 'short', year: 'numeric' });

		$.ajax({
			url:"{{ route('transfer.list.search') }}",
			type:"GET",
			data:{
				startDate:start,
				endDate:end,
			},
			success:function (response)
			{
				$('.tbody').html('');
				$.each(response,function (index, item){
					if(item.length ===0)
					{
						let noData = `<tr><td>@lang('No Data')</td></tr>`;
						$('.tbody').append(noData);
					}
					let markup = `<tr>
									<td data-label="@lang('date')">${item.created_at}</td>
									<td data-label="@lang('payment')">${item.gateway}</td>
									<td data-label="@lang('amount')">${item.transfer_amount}</td>
									<td data-label="@lang('utr')">${item.utr}</td>
									<td data-label="@lang('utr')">${item.type}</td>
									<td data-label="@lang('status')">${item.statusBadge}</td>
								</tr>`;
					$('.tbody').append(markup);

				});
			},
			error: function (error) {
			}
		})
	});

	$("#status").on('change', function () {
		let status = $(this).val();
		$.ajax({
			url: "{{ route('transfer.list.search') }}",
			type: "GET",
			data: {status:status},
			success: function (response) {

				$('.tbody').html('');
				$.each(response,function (index, item){
					let markup = `<tr>
									<td data-label="@lang('date')">${item.created_at}</td>
									<td data-label="@lang('payment')">${item.gateway}</td>
									<td data-label="@lang('amount')">${item.transfer_amount}</td>
									<td data-label="@lang('utr')">${item.utr}</td>
									<td data-label="@lang('utr')">${item.type}</td>
									<td data-label="@lang('status')">${item.statusBadge}</td>
								</tr>`;
					$('.tbody').append(markup);

				});
			},
			error: function (error) {
			}
		});
	});

</script>
@endpush

