@extends($theme.'layouts.user')
@section('title',__('Fund Added List'))

@section('content')
	<!-- Main Content -->
	<div class="col-xl-9 col-lg-8 col-md-12">
		<div class="row g-4">
			<div class="col-lg-12">
				<div class="card-box p-0">
					<div class="row align-items-end">
						<div class="col-lg-7">
							<div class="p-4">
								<h5 class="text-primary">@lang('Welcome') @lang(auth()->user()->name)! 🎉</h5>
								<a href="{{route('fund.initialize')}}" class="btn-custom">@lang('Add Fund')</a>

							</div>
						</div>
						<div class="col-lg-5 text-center text-sm-left d-none d-lg-block">
							<div class="text-right">
								<img src="{{asset($themeTrue.'images/dashboard-man-with-pc.png')}}"
									 height="140" alt="View Badge User"
									 data-app-dark-img="{{asset($themeTrue.'images/dashboard-man-with-pc.png')}}"
									 data-app-light-img="{{asset($themeTrue.'images/dashboard-man-with-pc.png')}}" />
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-12">

				<div class="table-responsive">
					<table
						class="table table-striped table-hover align-items-center table-borderless">
						<thead class="thead-light">
						<tr>
							<th>@lang('SL')</th>
							<th>@lang('Method')</th>
							<th>@lang('Transaction ID')</th>
							<th>@lang('Requested Amount')</th>
							<th>@lang('Status')</th>
							<th>@lang('Created time')</th>
						</tr>
						</thead>
						<tbody>
						@forelse($funds as $key => $value)
							<tr>
								<td data-label="@lang('SL')">{{loopIndex($funds) + $key }}</td>
								<td data-label="@lang('Method')">{{ __(optional(optional($value->depositable)->gateway)->name) ?? __('N/A') }}</td>
								<td data-label="@lang('Transaction ID')">{{ __($value->utr) }}</td>
								<td data-label="@lang('Requested Amount')">{{ (getAmount($value->amount)).' '.config('basic.base_currency') }}</td>
								<td data-label="@lang('Status')">
									@if($value->status)
										<span class="badge bg-success">@lang('Success')</span>
									@else
										<span class="badge bg-warning">@lang('Pending')</span>
									@endif
								</td>
								<td data-label="@lang('Created time')"> {{ dateTime($value->created_at)}} </td>
							</tr>
						@empty
							<tr>
								<th colspan="100%" class="text-center">@lang('No Data Found')</th>
							</tr>
						@endforelse
						</tbody>
					</table>
				</div>
					{{ $funds->links() }}
			</div>
		</div>
	</div>

@endsection
