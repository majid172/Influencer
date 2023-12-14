@extends($theme.'layouts.user')
@section('title',__('Listing Order Lists'))
@section('content')
	<div class="col-xl-9 col-lg-8 col-md-12">

			<div class="d-flex flex-row justify-content-between">
				<h4>@lang(' Order Lists')</h4>
			</div>

		<!-- table -->
		<div class="table-parent table-responsive">
			<table class="table table-striped">
				<thead>
				<tr>
					<th>@lang('Order')</th>
					<th>@lang('Title')</th>
					<th>@lang('Amount')</th>
					<th>@lang('Package')</th>
					<th>@lang('Deadline')</th>
					<th>@lang('Status')</th>
					<th class="text-center">@lang('Action')</th>
				</tr>
				</thead>

				<tbody>
				@forelse($orders as $key => $order)
					<tr>
						<td data-label="@lang('Order')">
							{{$order->order_no}}
						</td>
						<td data-label="@lang('Order')">
							<a href="{{ route('user.listing.details', ['slug' => $order->listing->title, 'id' => $order->listing->id]) }}">
								{{ Str::limit($order->listing->title, 20) }}
							</a>

						</td>
						<td  data-label="@lang('Amount')">
							<b>{{$basic->currency_symbol}}{{getAmount($order->amount)}}</b>
						</td>
						<td data-label="@lang('Order')">
							{{$order->package_name}}
						</td>
						<td data-label="@lang('Delivery')">
							{{$order->delivery_date}}
						</td>

						<td data-label="@lang('Status')">
							@if($order->status == 0)
								<span class="badge bg-warning ">@lang('Pending')</span>
							@elseif($order->status == 1)
								<span class="badge bg-success">@lang('Accepted')</span>
							@elseif($order->status == 2)
								<span class="badge bg-info">@lang('Done')</span>
							@elseif($order->status == 3)
								<span class="badge bg-success ">@lang('Complete')</span>
							@elseif($order->status == 4)
								<span class="badge bg-danger">@lang('Cancel')</span>
							@endif
						</td>
						<td data-label="@lang('Action')" class="actionButtonsCenter">

							<div class="sidebar-dropdown-items">
								<button type="button" class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
									<i class="fa-light fa-ellipsis-vertical"></i>
								</button>
								<ul class="dropdown-menu dropdown-menu-end">
									<li>
										@if(auth()->user()->is_client == 1)
											@if($order->file)
												<a href="{{getFile($order->driver,$order->file)}}" class="dropdown-item" download><i class="fa-regular fa-arrow-down-to-line"></i>{{__($order->file_name)}}</a>

												<button type="button" class="dropdown-item review" data-bs-toggle="modal" data-bs-target="#reviewModal" data-influencer_id="{{$order->influencer_id}}" data-listing_id="{{$order->listing_id}}">
													<i class="fa-regular fa-star-sharp-half-stroke"></i>@lang('Review')
												</button>
											@else
												<a href="javascript:void(0)" class="dropdown-item" type="button" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="@lang('The project file has not yet been submitted.')"><i class="fa-light fa-empty-set" id="icon"></i>@lang('Empty File')</a>
											@endif
										@endif

										@if($order->influencer_id == auth()->user()->id)
											<button type="button" class="dropdown-item upload " data-bs-toggle="modal" data-bs-target="#staticBackdrop" data-id="{{$order->id}}" data-order_no="{{$order->order_no}}">
												<i class="fa-thin fa-folder-arrow-up"></i>@lang('Upload File')
											</button>
										@endif
									</li>
									<li>
										<a class="dropdown-item" href="{{route('user.listing.order.details',$order->id)}}" data-bs-original-title="@lang('Show order details.')"><i class="fa-sharp fa-regular fa-eye"></i>@lang('Details')</a>
									</li>
									<li>
										<button type="button" title="Conversation" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#messageModal" data-sender_id="{{$order->user_id}}" data-receiver_id="{{$order->influencer_id}}" data-listing_id="{{$order->listing_id}}"><i class="fa-brands fa-rocketchat"></i> @lang('Message')</button>
									</li>
								</ul>
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
		<div class="">
			{{ $orders->links() }}
		</div>
	</div>

{{--	file upload --}}
	<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="staticBackdropLabel">@lang('File Upload')</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<form action="{{route('user.listing.order.upload')}}" method="post" enctype="multipart/form-data">
					@csrf
					<div class="modal-body">
						<h6 class="order_no">@lang('Order number') : <span></span></h6>
						<input type="hidden" name="order_id">
						<input type="file" class="form-control" name="file">
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn-action btn-primary">@lang('Upload')</button>
					</div>
				</form>
			</div>
		</div>
	</div>


{{--	message --}}
	<div class="modal fade" id="messageModal" tabindex="-1" aria-labelledby="messageModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="messageModalLabel">@lang('Message')</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<form action="{{route('user.proposer.message')}}" method="POST">
					@csrf
					<div class="modal-body">
						<input type="hidden" class="form-control" name="sender_id">
						<input type="hidden" class="form-control" name="receiver_id">
						<input type="hidden" class="form-control" name="listing_id">

						<textarea class="form-control" name="message" rows="2" cols="10" placeholder="@lang('write something ...')"></textarea>

					</div>
					<div class="modal-footer">

						<button type="submit" class="btn-custom">@lang('Send')</button>
					</div>
				</form>

			</div>
		</div>
	</div>


	<div class="modal fade" id="reviewModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="reviewModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="reviewModalLabel">@lang('Review')</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>

				<div class="add-review">
				<form action="{{route('user.review')}}" method="post">
					@csrf
					<div class="modal-body">
						<input type="hidden" name="user_id" value="{{auth()->user()->id}}">
						<input type="hidden" class="form-control" name="influencer_id">
						<input type="hidden" name="listing_id" >
						<div class="row g-3">

							<h6 class="text-left mb-0">@lang('Ratings')</h6>
							<div class="rating">
								<input type="radio" id="star1" name="rating" value="5" />
								<label for="star1" title="text"></label>
								<input type="radio" id="star2" name="rating" value="4" />
								<label for="star2" title="text"></label>
								<input checked="" type="radio" id="star3" name="rating" value="3" />
								<label for="star3" title="text"></label>
								<input type="radio" id="star4" name="rating" value="2" />
								<label for="star4" title="text"></label>
								<input type="radio" id="star5" name="rating" value="1" />
								<label for="star5" title="text"></label>
							</div>


							<div class="input-box col-12">
								<h6>@lang('Comment')</h6>
                                 <textarea class="form-control" cols="30" rows="3" name="comment" placeholder="@lang('Write comment')"
								 ></textarea>
							</div>
							<div class="input-box col-12">
								<button type="submit" class="btn-custom">@lang('Submit')</button>
							</div>
						</div>
					</div>
				</form>
				</div>
			</div>
		</div>
	</div>
@endsection

@push('style')
	<style>
		.add-review {
			margin-bottom: 50px;
		}
		.add-review .rating {
			display: flex;
			flex-direction: row-reverse;
			justify-content: start;
		}
		.add-review .rating:not(:checked) > input {
			position: absolute;
			-webkit-appearance: none;
			-moz-appearance: none;
			appearance: none;
		}
		.add-review .rating:not(:checked) > label {
			cursor: pointer;
			font-size: 36px;
			color: var(--borderColor);
		}
		.add-review .rating:not(:checked) > label:before {
			content: "★";
		}
		.add-review .rating > input:checked + label:hover,
		.add-review .rating > input:checked + label:hover ~ label,
		.add-review .rating > input:checked ~ label:hover,
		.add-review .rating > input:checked ~ label:hover ~ label,
		.add-review .rating > label:hover ~ input:checked ~ label {
			color: var(--gold);
		}
		.add-review .rating:not(:checked) > label:hover,
		.add-review .rating:not(:checked) > label:hover ~ label {
			color: var(--gold);
		}
		.add-review .rating > input:checked ~ label {
			color: var(--gold);
		}
		.add-review form .input-box label {
			font-weight: 500;
			margin-bottom: 10px;
			text-transform: capitalize;
		}
		.add-review form .input-box .form-select,
		.add-review form .input-box .form-control {
			height: 50px;
			border-radius: 5px;
			background-color: var(--bgLight);
			border: 1px solid var(--bgLight);
			padding: 8px;
			padding-left: 15px;
			font-weight: normal;
			caret-color: var(--primary);
			color: var(--fontColor);
		}
		.add-review form .input-box .form-select:focus,
		.add-review form .input-box .form-control:focus {
			color: var(--fontColor);
			box-shadow: 0 0 0 0rem var(--white);
			border: 1px solid var(--primary);
		}
		.add-review form .input-box .form-select::-moz-placeholder, .listing-details .add-review form .input-box .form-control::-moz-placeholder {
			color: var(--fontColor);
		}
		.add-review form .input-box .form-select::placeholder,
		.add-review form .input-box .form-control::placeholder {
			color: var(--fontColor);
		}
		.add-review form .input-box .form-select {
			background-image: url(../img/icon/downward-arrow.png);
		}
		.add-review form .input-box .form-select option {
			background: var(--white);
			color: var(--fontColor);
		}
		.add-review form .input-box textarea.form-control {
			height: 120px;
			border-radius: 5px;
		}
	</style>
@endpush

@push('scripts')
	<script>
		$('.upload').on('click',function (){
			let order_id = $(this).data('id');
			let order_no = $(this).data('order_no');
			let modal = $('#staticBackdrop');

			modal.find('.order_no span').text(order_no);
			modal.find('input[name="order_id"]').val(order_id);

		});

		$('.message').on('click',function(){
			let modal = $('#messageModal');
			modal.find('input[name="sender_id"]').val($(this).attr('data-sender_id'));
			modal.find('input[name="receiver_id"]').val($(this).attr('data-receiver_id'));
			modal.find('input[name="listing_id"]').val($(this).attr('data-listing_id'));
		})

		$('.review').on('click',function (){
			let influencer_id = $(this).data('influencer_id');
			let listing_id = $(this).data('listing_id');
			let modal = $('#reviewModal');
			modal.find('input[name="influencer_id"]').val(influencer_id);
			modal.find('input[name="listing_id"]').val(listing_id);
		});

	</script>
@endpush
