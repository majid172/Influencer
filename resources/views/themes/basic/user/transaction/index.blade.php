@extends($theme.'layouts.user')
@section('title',__('Transaction List'))

@section('content')
	<div class="col-xl-9 col-lg-8 col-md-12">
		<div class="row">
			<div class="col-lg-12">
				<div class=" mb-4">
					<div class=" py-3 d-flex flex-row align-items-center justify-content-between">
						<h4 class="m-0 font-weight-bold text-primary">@lang('Transaction List')</h4>
						<h6>@lang('Balance'): {{$basic->currency_symbol}} {{getAmount(auth()->user()->balance)}}</h6>
					</div>

					<div class="card-box mb-3">
						<form>
							<div class="row g-4 align-items-end">

								<div class="col-xl-3 col-md-6">
									<div class="input-box">
										<label for="date">@lang('Statement Period')</label>
										<input class="form-control flatpickr_date" type="text" id="start_date" value="{{@request()->from_date}}"
											   name="delivery_date" placeholder="@lang('From Date')" autocomplete="off"/>
									</div>
								</div>


								<div class="col-xl-3 col-md-6">
									<div class="input-box">
										<label for="status">@lang('Transactional Type')</label>
										<div class="input-box">
											<select class="js-example-basic-single form-control" id="type" name="type">
												<option value="">@lang('Choose your option')</option>
												<option value="Transfer">@lang('Transfer')</option>
												<option value="Payout">@lang('Payout')</option>

											</select>
										</div>
									</div>
								</div>

								<div class="col-xl-3 col-md-6">
									<div class="input-box">
										<label for="status">@lang('Transactional Status')</label>
										<div class="input-box">
											<select class="js-example-basic-single form-control" id="status" name="status">
												<option value="">@lang('Choose your option')</option>
												<option value="0">@lang('Pending')</option>
												<option value="1">@lang('Success')</option>

											</select>
										</div>
									</div>
								</div>

								<div class="col-xl-3 col-md-6">
									<form action="{{route('transfer.export')}}" method="get" class="align-self-end">
										@foreach($transactions as $key => $value)

											<input type="hidden" name="data[{{ $key }}][SL.]"
												   value="{{$key+1}}">
											<input type="hidden" name="data[{{ $key }}][Date]"
												   value="{{$value->created_at}}">

											<input type="hidden" name="data[{{ $key }}][Amount]" value="{{ (getAmount(optional($value->transactional)->amount)) .' '. config('basic.base_currency') }}">

											<input type="hidden" name="data[{{ $key }}][Trx. ID]"
												   value="{{ __(optional($value->transactional)->utr)}}">

											<input type="hidden" name="data[{{ $key }}][Type]"
												   value="{{ __(str_replace('App\Models\\', '', $value->transactional_type)) }}">


											<input type="hidden" name="data[{{ $key }}][Status]"
												   value="@if($value->transactional->status)
													Success
												@else
													Pending
												@endif">

										@endforeach
										<input type="hidden" name="file_name" value="Transfer">
										<button type="submit" class="btn btn-primary btn-sm export-button-width"><i class="fal fa-file-excel text-white"></i>
											@lang('Export CSV')
										</button>
									</form>
								</div>
							</div>
						</form>
					</div>

					<div class="table-responsive">
						<table
							class="table table-striped table-hover align-items-center table-borderless">
							<thead class="thead-light">
							<tr>
								<th>@lang('Transaction ID')</th>
								<th>@lang('Amount')</th>
								<th>@lang('Type')</th>
								<th>@lang('Status')</th>
								<th>@lang('Created time')</th>
							</tr>
							</thead>
							<tbody class="tbody">
							@forelse($transactions as $key => $value)
								<tr>
									<td data-label="@lang('Transaction ID')">{{ __(optional($value->transactional)->utr) }}</td>
									<td data-label="@lang('Requested Amount')">{{ (getAmount(optional($value->transactional)->amount)) .' '. config('basic.base_currency') }}</td>
									<td data-label="@lang('Type')">
										{{ __(str_replace('App\Models\\', '', $value->transactional_type)) }}
									</td>
									<td data-label="@lang('Status')">
										@if($value->transactional->status)
											<span class="badge bg-success">@lang('Success')</span>
										@else
											<span class="badge bg-warning">@lang('Pending')</span>
										@endif
									</td>
									<td data-label="@lang('Created time')"> {{ $value->getTimeZone()}} </td>
								</tr>
							@empty
								<tr>
									<th colspan="100%" class="text-center">@lang('No Data Found')</th>
								</tr>
							@endforelse
							</tbody>
						</table>
					</div>

						{{ $transactions->links() }}

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
		$('#start_date,#status,#type').on('input change',function (){
			let val = $('#start_date').val();
			let status = $("#status").val();
			let type = $("#type").val();
			var dates = val.split(" to ");
			var start = dates[0];
			var end = dates[1];
			var startObj = new Date(start);
			var endObj = new Date(end);
			var startDate = startObj.toLocaleDateString('en-US', { day: 'numeric', month: 'short', year: 'numeric' });
			var endDate = endObj.toLocaleDateString('en-US', { day: 'numeric', month: 'short', year: 'numeric' });

			$.ajax({
				url:"{{ route('user.transaction.search') }}",
				type:"GET",
				data:{
					startDate:start,
					endDate:end,
					status:status,
					type:type,

				},
				success:function (response)
				{

					$('.tbody').html('');
					$.each(response,function (index, item){
						if (item === null || item === 0 || item === '') {
							let markup = `<tr>
									<td data-label="@lang('No Data Found')">@lang('No Data Found')</td>

								</tr>`;
							$('.tbody').append(markup);
						}
						let markup = `<tr>
									<td data-label="@lang('')">${item.transactional.utr}</td>
									<td data-label="@lang('amount')">${item.amount}</td>
									<td data-label="@lang('type')">${item.type}</td>
									<td data-label="@lang('status')">${item.status}</td>
									<td data-label="@lang('created')">${item.date}</td>
								</tr>`;
						$('.tbody').append(markup);
					 });
				},
				error: function (error) {
					console.error(error);
				}
			})
		});


	</script>

@endpush

