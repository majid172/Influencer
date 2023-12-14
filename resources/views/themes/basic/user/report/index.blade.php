@extends($theme.'layouts.user')
@section('title',__('Reports'))
@section('content')
	<div class="col-xl-9 col-lg-8 col-md-12">
		<div class="d-flex justify-content-between align-items-center flex-wrap">
			<h4>@lang('Reports Summary')</h4>
			<form action="{{route('user.listing.order.export')}}" method="get" class="align-self-end">
				@foreach($listing_orders as $key => $value)

					<input type="hidden" name="data[{{ $key }}][SL.]"
						   value="{{$key+1}}">
					<input type="hidden" name="data[{{ $key }}][Date]"
						   value="{{$value->created_at}}">
					<input type="hidden" name="data[{{ $key }}][Title]" value="{{__(optional($value->listing)->title)}}">
					<input type="hidden" name="data[{{ $key }}][File]" value="{{__($value->file_name)}}">
					<input type="hidden" name="data[{{ $key }}][Amount]" value="{{$basic->currency_symbol}}{{ getAmount($value->amount)}}">
					<input type="hidden" name="data[{{ $key }}][Status]" value="@if($value->status) Success @else Pending @endif">
				@endforeach
				<input type="hidden" name="file_name" value="Listing_order">

				<button type="submit" class="btn btn-primary btn-sm export-button-width"><i class="fa-regular fa-file-excel"></i>
					@lang('Export CSV')
				</button>
			</form>
		</div>

		<div class="card-box search-box my-3">
			<form>
				<div class="row">
					<div class="col-md-6">
						<div class="input-box">
							<label for="date">@lang(' Statement Period')</label>
							<input class="form-control flatpickr_date" type="text" id="start_date" value="{{@request()->from_date}}"
								   name="delivery_date" placeholder="@lang('Statement period')" autocomplete="off"/>
						</div>
					</div>
					<div class="col-md-6">
						<div class="input-box">
							<label for="type">@lang('Select Type')</label>
							<select name="type" id="type" class="form-select js-example-basic-multiple-limit">
								<option value="">@lang('Choose your option')</option>
								<option value="listing" > @lang('Listing')</option>
								<option value="job"> @lang('Job')</option>
							</select>
						</div>
					</div>
				</div>
			</form>
		</div>
		<div class="table-responsive mb-5">
			<table class="table table-striped table-hover align-items-center table-borderless" >
				<thead class="thead-light">
				<tr>
					<th>@lang('Date')</th>
					<th>@lang('Amount')</th>
					<th>@lang('Status')</th>
				</tr>
				</thead>
				<tbody class="listing_order">
				@forelse($listing_orders as $key=>$order)
					<tr>

						<td data-label="@lang('Date')">{{$order->created_at}}</td>
						<td data-label="@lang('Amount')">{{$basic->currency_symbol}}{{getAmount($order->amount)}}</td>
						<td data-label="@lang('Status')">
							@if($order->status  == 0)
								<span class="badge bg-primary">@lang('Pending')</span>
							@elseif($order->status  == 1)
								<span class="badge bg-info">@lang('Ongoing')</span>
							@elseif($order->status  == 2)
								<span class="badge bg-warning">@lang('Done')</span>
							@elseif($order->status  == 3)
								<span class="badge bg-success">@lang('Completed')</span>
							@elseif($order->status == 4)
								<span class="badge bg-danger">@lang('Canceled')</span>
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
		{{ $listing_orders->links() }}

	</div>
@endsection

@push('css-lib')
	<link rel="stylesheet" href="{{asset($themeTrue.'css/flatpickr.min.css')}}">
@endpush

@push('style')
	<style>
		.mdc-data-table {
			width: 100%;
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

@section('scripts')
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
				url:"{{ route('user.listing.order.filter') }}",
				type:"GET",
				data:{
					startDate:start,
					endDate:end,
				},
				success:function (response)
				{

					$('.listing_order').html('');
					$.each(response,function (index, item){
						if(item.length ===0)
						{
							let noData = `<tr><td>@lang('No Data Found')</td></tr>`;
							$('.listing_order').append(noData);
						}
						let markup = `<tr>
									<td data-label="@lang('date')">${item.created_at}</td>
									<td data-label="@lang('amount')">${item.amount}</td>
									<td data-label="@lang('status')">${item.status}</td>
								</tr>`;
						$('.listing_order').append(markup);

					});
				},
				error: function (error) {
				}
			})
		});
		$("#type").on('change',function (){
			let type = $(this).val()
			if(type == 'listing')
			{
				$.ajax({
					url:"{{route('user.type.filter')}}",
					method:"GET",
					data:{
						type:type,
					},
					success:function (response)
					{
						$('.listing_order').html('');
						$.each(response,function (index, item){
							console.log(item.title)
							if(item.length ===0)
							{
								let noData = `<tr><td>@lang('No Data Found')</td></tr>`;
								$('.listing_order').append(noData);
							}
							let markup = `<tr>
									<td data-label="@lang('date')">${item.created_at}</td>

									<td data-label="@lang('amount')">${item.amount}</td>
									<td data-label="@lang('status')">${item.status}</td>
								</tr>`;
							$('.listing_order').append(markup);

						});
					},
					error:function (error){
					}
				})
			}
			else{
				$.ajax({
					url:"{{route('user.type.filter')}}",
					method:"GET",
					data:{ type:type},
					success:function (response){
						$('.listing_order').html('');
						$.each(response,function (index, item){
							console.log(item.title)
							if(item.length ===0)
							{
								let noData = `<tr><td>@lang('No Data Found')</td></tr>`;
								$('.listing_order').append(noData);
							}
							let markup = `<tr>
									<td data-label="@lang('date')">${item.created_at}</td>

									<td data-label="@lang('amount')">${item.amount}</td>
									<td data-label="@lang('status')">${item.status}</td>
								</tr>`;
							$('.listing_order').append(markup);

						});
					},
					error:function(error)
					{
					}

				})
			}
		});
	</script>

@endsection
