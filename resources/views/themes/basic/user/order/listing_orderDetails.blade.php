@extends($theme.'layouts.user')
@section('title',__('Listing Order Lists'))
@section('content')
	<div class="col-xl-9 col-lg-8 col-md-12">

		<div class="d-flex flex-row justify-content-between align-items-center mb-3">
			<h4>@lang(' Order Details')</h4>
			<a href="{{route('user.listing.order.list')}}" class="btn-custom btn-sm">@lang('Back')</a>
		</div>

		<div class="card-box">
			<ul class="list-unstyled">
				<li class="d-flex justify-content-between flex-wrap mb-3">
					<span>@lang('Title')</span>
					<span>{{__(@$order->listing->title)}}</span>
				</li>
				<li class="d-flex justify-content-between flex-wrap mb-3">
					<span>@lang('Package')</span>
					<span>{{__($order->package_name)}} </span>
				</li>
				<li class="d-flex justify-content-between flex-wrap mb-3">
					<span>@lang('Client info')</span>
					<span>{{__(@$order->client->name)}}</span>
				</li>
				<li class="d-flex justify-content-between flex-wrap mb-3">
					<span>@lang('Amount')</span>
					<span>{{getAmount($order->amount)}} {{$basic->base_currency}}</span>
				</li>
				<li class="d-flex justify-content-between flex-wrap mb-3">
					<span>@lang('Duration')</span>
					<span>
						{{diffForHumans($order->delivery_date)}}
					</span>
				</li>
				<li class="d-flex justify-content-between flex-wrap mb-3">
					<span>@lang('File')</span>
					<span>
						@if($order->file)
							<a href="#" download>	{{__($order->file_name)}}</a>
						@else
							@lang('N/A')
						@endif
					</span>
				</li>
				<li class="d-flex justify-content-between flex-wrap">
					<span>@lang('Action')</span>
					<span>
						@if($order->status == 0)
							@if(auth()->user()->id == $order->influencer_id)
								<button type="button" class="btn-action accept" data-bs-toggle="modal" data-bs-target="#acceptModal" data-route="{{route('user.listing.order.accept',$order->id)}}">@lang('Accept')</button>

								<button type="button" class="btn-action bg-danger cancel" data-bs-toggle="modal" data-bs-target="#cancelModal" data-route="{{route('user.listing.order.cancel',$order->id)}}">@lang('Cancel')</button>
							@elseif(auth()->user()->id == $order->user_id)
								<button type="button" class="btn-action">@lang('Pending')</button>
							@endif

						@elseif($order->status == 1 && !$order->file)
							@if(auth()->user()->id == $order->influencer_id)
								<button type="button" class="btn-action bg-info ">@lang('Running')</button>
							@elseif(auth()->user()->id == $order->user_id)
								<button type="button" class="btn-action bg-info">@lang('Running')</button>
							@endif

						@elseif($order->status == 1 && $order->file)
							@if(auth()->user()->id == $order->influencer_id)
								<button type="button" class="btn-action " id="done" data-bs-toggle="modal" data-bs-target="#acceptModal" data-route="{{route('user.listing.order.done',$order->id)}}">@lang('Done')</button>
							@elseif(auth()->user()->id == $order->user_id)
								<button type="button" class="btn-action " >@lang('Running')</button>
							@endif

						@elseif($order->status == 2 && $order->file)
							@if(auth()->user()->id == $order->user_id)
								<button type="button" class="btn-action .complete" id="complete" data-bs-toggle="modal" data-bs-target="#acceptModal" data-route="{{route('user.listing.order.complete',$order->id)}}">@lang('Complete')</button>
							@elseif(auth()->user()->id == $order->influencer_id)
								<button type="button" class="btn-action bg-warning">@lang('Wait for Complete')</button>
							@endif

						@elseif($order->status == 3)
							<button type="button" class="btn-action  bg-success">@lang('Completed')</button>
						@elseif($order->status == 4)
							<button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal">
							  @lang('Canceled')
							</button>

						@endif
					</span>

				</li>

			</ul>
		</div>
	</div>

	<div class="modal fade" id="acceptModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h1 class="modal-title fs-5" id="exampleModalLabel">@lang('Confirmation Alert')</h1>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<form action="" method="post" class="url">
					@csrf
					<div class="modal-body">
						<p>@lang('Are you want to change action ?')</p>
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn-action">@lang('Yes')</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<div class="modal fade" id="cancelModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">@lang('Cancel Confirmation')</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<form action="" method="post" class="url">
					@csrf
					<div class="modal-body">
						<p>@lang('Are you want to cancel this order ?')</p>
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn-action">@lang('Yes')</button>
					</div>
				</form>
			</div>
		</div>
	</div>
@endsection

@push('scripts')
	<script>
		$('.accept').on('click',function (){
			$('.url').attr('action',$(this).attr('data-route'));
		});
		$('.cancel').on('click',function (){

			$('.url').attr('action',$(this).attr('data-route'));
		});

		$('#done').on('click',function (){
			$('.url').attr('action',$(this).attr('data-route'));
		});
		$('#complete').on('click',function (){
			$('.url').attr('action',$(this).attr('data-route'));
		});
	</script>
@endpush
