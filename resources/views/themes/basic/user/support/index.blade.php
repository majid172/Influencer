@extends($theme.'layouts.user')
@section('title',__('Support Ticket'))

@section('content')
	<div class="col-xl-9 col-lg-8 col-md-12">
		<div class="d-flex flex-row justify-content-between">
			<h4>@lang('Support Ticket')</h4>
			<a href="{{route('user.ticket.create')}}" class="btn-action text-white">
				<i class="fal fa-plus-circle"></i> @lang('Create Ticket')
			</a>
		</div>
		<!-- table -->
		<div class="table-parent table-responsive">
			<table class="table table-striped">
				<thead>
					<tr>
						<th>@lang('Subject')</th>
						<th>@lang('Status')</th>
						<th>@lang('Last Reply')</th>
						<th>@lang('Action')</th>
					</tr>
				</thead>

				<tbody>
					@forelse($tickets as $key => $ticket)
						<tr>
							<td data-label="@lang('Subject')">
								[{{ trans('Ticket# ').__($ticket->ticket) }}] {{ __($ticket->subject) }}
							</td>
							<td data-label="@lang('Status')">
								@if($ticket->status == 0)
									<span class="badge bg-success">@lang('Open')</span>
								@elseif($ticket->status == 1)
									<span class="badge bg-primary">@lang('Answered')</span>
								@elseif($ticket->status == 2)
									<span class="badge bg-warning">@lang('Replied')</span>
								@elseif($ticket->status == 3)
									<span class="badge bg-secondary">@lang('Closed')</span>
								@endif
							</td>
							<td data-label="@lang('Last Reply')">
								{{ __($ticket->last_reply->diffForHumans()) }}
							</td>
							<td data-label="@lang('Action')">
								<a href="{{ route('user.ticket.view', $ticket->ticket) }}" class="btn-action">
									<i class="fa-light fa-eye me-2"></i> @lang('Details')
								</a>
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
