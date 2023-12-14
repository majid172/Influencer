@extends($theme.'layouts.app')
@section('title', trans('Listings Details'))

@section('content')
	<section class="listing-details">
		<div class="overlay">
			<div class="container">
				<div class="row">
					<div class="col-12">
						<div class="row info-box g-lg-5 mb-4">
							<div class="col-lg-7">
								<h4 class="title mb-4">
									@lang($listingDetails->title)
								</h4>
								<div class="d-flex justify-content-between align-items-center">
									<div class="author">
										<div class="author-img">
											@if($listingDetails->user->profile->profile_picture)
												<img src="{{getFile(optional(optional($listingDetails->user)->profile)->driver, optional(optional($listingDetails->user)->profile)->profile_picture)}}" class="img-fluid" alt="@lang('influencer profile img')" />
											@else

												<div class="img-replace-txt">{{getFirstChar($listingDetails->user->name)}}</div>
											@endif
										</div>
										<div class="author-info">
											<a href="{{route('influencer.profile', optional($listingDetails->user)->username)}}" class="name" target="_blank">@lang(optional($listingDetails->user)->name)</a>
											<span>{{__(optional(optional($listingDetails->user)->profile)->seller_type)}}</span>
										</div>
									</div>

									<div class="rating">
										@for($i = 0; $i < $reviews->avg('ratings'); $i++)
											<i class="fas fa-star"></i>
										@endfor

										<span>{{$reviews->avg('ratings')}}</span> @lang('Total Review'): {{$reviews->count()}}
									</div>

								</div>
							</div>
						</div>
					</div>
				</div>


				<div class="row g-4">
					<div class="col-lg-7">
						<div class="gallery-box">
							<div id="mainCarousel" class="carousel mx-auto main_carousel">
								<div class="carousel__slide" data-src="{{getFile($listingDetails->driver,$listingDetails->image)}}" data-fancybox="gallery" data-caption="">
									<img class="img-fluid" src="{{getFile($listingDetails->driver,$listingDetails->image)}}" />
								</div>
									@forelse($listingDetails->extraImages as $extraImage)
										<div class="carousel__slide" data-src="{{getFile($extraImage->driver,$extraImage->extra_image)}}" data-fancybox="gallery" data-caption="">
											<img class="img-fluid" src="{{getFile($extraImage->driver,$extraImage->extra_image)}}" />
										</div>
									@empty

									@endforelse
							</div>


							<div class="row">
								<div class="col-md-12">
									<div id="thumbCarousel" class="carousel max-w-xl mx-auto thumb_carousel">
											<div class="carousel__slide col-md-4">
												<img class="panzoom__content img-fluid" src="{{ getFile($listingDetails->driver, $listingDetails->image) }}" />
											</div>

											@forelse($listingDetails->extraImages as $extraImage)
												<div class="carousel__slide col-md-4">
													<img class="panzoom__content img-fluid" src="{{ getFile($extraImage->driver, $extraImage->extra_image) }}" />
												</div>
											@empty
											@endforelse
									</div>
								</div>
							</div>

						</div>


						<div id="description" class="description-box mb-5 mt-5">
							<h4>@lang('Listing Details')</h4>
							{!! trans($listingDetails->description) !!}
						</div>


						<div class="seller-info mb-5">
							<div class="author mb-4">
								<div class="author-img">
									@if(@$listingDetails->user->profile->profile_picture)
										<img src="{{getFile(optional(optional($listingDetails->user)->profile)->driver, optional(optional($listingDetails->user)->profile)->profile_picture)}}" class="profile img-fluid" alt="@lang('influencer profile img')" />
									@else
										<div class="img-replace-txt">{{getFirstChar($listingDetails->user->name)}}</div>
									@endif

									@foreach($levels as $level)
										@if($level->details->name == $listingDetails->user->profile->seller_type)
											<img src="{{getFile($level->driver,$level->image)}}" alt="@lang('level_img')" class="level-badge" />
										@endif
									@endforeach
								</div>
								<div class="author-info">
									<a href="{{route('influencer.profile', optional($listingDetails->user)->username)}}" class="name" target="_blank">@lang(optional($listingDetails->user)->name)</a>
									<p class="mb-2">{{@$listingDetails->user->profile->seller_type}}</p>

									<a href="javascript:void(0)" class="btn-custom a-btn-light mt-3 message" data-bs-toggle="modal" data-bs-target="#messageModal" data-sender_id="{{auth()->user()->id}}" data-receiver_id="{{@$listingDetails->user->id}}" data-listing_id="{{$listingDetails->id}}">@lang('contact me') </a>
								</div>
							</div>

							<div class="card-">
								<div class="row">
									<div class="col-sm-6">
										<span>@lang('From')</span>
										<p><b>@lang(optional(optional(optional($listingDetails->user)->profile)->getCountry)->name)</b></p>
									</div>
									<div class="col-sm-6">
										<span>@lang('Member since')</span>
										<p><b>@lang(optional($listingDetails->user)->created_at->format('M Y'))</b></p>
									</div>

									<div class="col-sm-6">
										<span>@lang('Mother Tongue')</span>
										<p><b>@lang(optional(optional($listingDetails->user)->profile)->mother_tongue)</b></p>
									</div>
									<div class="col-sm-6">
										<span>@lang('Known Languages')</span>
										<p>
											<b>
												@if(isset(optional(optional($listingDetails->user)->profile)->known_languages))
													@lang((optional($listingDetails->user)->profile)->known_languages)
												@else
													@lang('No Data Found.')
												@endif
											</b>
										</p>
									</div>

									<div class="col-12">
										<p>@lang(optional(optional($listingDetails->user)->profile)->about_me)</p>
									</div>
								</div>
							</div>
						</div>


						<!-- FAQ -->
						<div class="faq-box mb-5" class="accordion" id="accordionExample">
							<h4>@lang('FAQS')</h4>
							@foreach($listingDetails->faqs as $key => $data)
								<div class="accordion-item">
									<h5 class="accordion-header" id="heading{{$key}}">
										<button class="accordion-button @if( $key != 0 ) collapsed @endif" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{$key}}" aria-expanded="false" aria-controls="collapse{{$key}}">
											@lang($data->faq_title)
										</button>
									</h5>
									<div id="collapse{{$key}}" class="accordion-collapse collapse @if( $key == 0 ) show @endif"
										 aria-labelledby="heading{{$key}}" data-bs-parent="#accordionExample">
										<div class="accordion-body">@lang($data->faq_description)</div>
									</div>
								</div>
							@endforeach
						</div>


						<!-- Requirement ques -->
						<div class="related-tags mb-5 influencer-profile p-0">
							<h4>@lang('Requirement')</h4>
							@foreach ($listingDetails->requirement_ques as $item)
								<div class="edu-box">
									<p class="pb-0 mb-0">@lang($item->requirementsQues)</p>
								</div>
							@endforeach
						</div>

						<!-- reviews -->
						<div class="all-review mb-5">
							<h4>@lang('Reviews') ({{$reviews->count()}})</h4>
							@foreach($reviews as $review)
								<div class="review-box">
									<div class="img-box">
										<img class="img-fluid" src="{{getFile($review->reviewer->profile->driver,$review->reviewer->profile-> profile_picture)}}" alt="user_img" />
									</div>
									<div class="text-box">
										<h5 class="name">{{__(@$review->reviewer->name)}}</h5>
										<p class="date">{{$review->created_at}}</p>
										<div class="rating">

											@for($i=0;$i < $review->ratings;$i++)
												<i class="fas fa-star"></i>
											@endfor

											<span>({{$review->ratings}})</span>
										</div>
										<p class="mt-3">
											{{__($review->comment)}}
										</p>
										@if($review->influencer_id == auth()->user()->id)
											<div class="feedback">
												<p>@lang('Helpful?')</p>

												@if($review->is_helpful == 'yes')
													<button class="helpful" data-value="yes" data-id="{{$review->id}}"><i class="fa-solid fa-thumbs-up"></i> @lang('Yes')</button>
													<button class="helpful" data-value="no" data-id="{{$review->id}}"><i class="fa-light fa-thumbs-down"></i> @lang('No')</button>
												@elseif($review->is_helpful == 'no')
													<button class="helpful" data-value="yes" data-id="{{$review->id}}"><i class="fa-light fa-thumbs-up"></i> @lang('Yes')</button>
													<button class="helpful" data-value="no" data-id="{{$review->id}}"><i class="fa-solid fa-thumbs-down"></i> @lang('No')</button>
												@else
													<button class="helpful" data-value="yes" data-id="{{$review->id}}"><i class="fa-light fa-thumbs-up"></i> @lang('Yes')</button>
													<button class="helpful" data-value="no" data-id="{{$review->id}}"><i class="fa-light fa-thumbs-down"></i> @lang('No')</button>
												@endif
											</div>
										@endif
									</div>
								</div>
							@endforeach
						</div>

						<!-- related tags -->
						<div class="related-tags mb-5">
							<h4>@lang('Related Tags')</h4>
							@foreach(explode(',',$listingDetails->tag) as $key => $tagItem)
								<a href="javascript:void(0)">@lang($tagItem)</a>
							@endforeach
						</div>


						<div class="recommended">
							<h4>@lang('Recommended For You') ({{$recommendedCount}})</h4>
							<div class="row g-4">
								@foreach($recommendedLists as $item)
									<div class="col-md-5">
										<div class="listing-box">
											<div class="img-box">
												<img src="{{getFile($item->driver,$item->image)}}" class="img-fluid" alt="gig_img" />
											</div>
											<div class="text-box">
												<div class="author">
													<div class="author-img">
														{!! $item->user->profilePicture() !!}

													</div>
													<div class="author-info">
														<a href="{{route('influencer.profile',optional($item->user)->username)}}" class="name">{{@$item->user->name}}</a>
														<span>{{__(@$seller_type)}}</span>
													</div>
												</div>
												<a href="{{route('user.listing.details',['slug'=>$item->title,'id'=>$item->id])}}" class="title">{{__($item->title)}}</a>
												<div class="d-flex justify-content-between">
													<p class="rating"><i class="fas fa-star"></i> <span> {{@$item->review->avg('ratings')}} </span></p>
													<p class="price">@lang('Starting at')  <span>{{$basic->currency_symbol}}{{__($item->firstPackage())}}</span></p>
												</div>
											</div>
										</div>
									</div>
								@endforeach

							</div>
						</div>
					</div>

					<!-- side bar start -->
					<div class="col-lg-1"></div>
					<div class="col-lg-4">
						<div class="side-bar">
							<div class="side-box">
								<ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
									@foreach($listingDetails->package as $key=>$package)
										<li class="nav-item" role="presentation">
											<button class="nav-link {{$key == 0 ? 'active':''}}" id="pills-{{$package['package_name']}}-tab" data-bs-toggle="pill" data-bs-target="#pills-{{$package['package_name']}}" type="button" role="tab" aria-controls="pills-{{$package['package_name']}}" aria-selected="{{ $key == 0 ? 'true' : 'false' }}">
												{{$package['package_name']}}
											</button>
										</li>
									@endforeach

								</ul>
								<div class="tab-content" id="pills-tabContent">
									@foreach($listingDetails->package as $key=>$package)
										<div class="tab-pane fade{{$key == 0 ? 'show active':''}}" id="pills-{{$package['package_name']}}" role="tabpanel" aria-labelledby="pills-{{$package['package_name']}}-tab">
											<h4>{{basicControl()->currency_symbol}} {{$package['package_price']}}</h4>
											<p> {{$package['package_desc']??''}} </p>
											<h5>@lang('What\'s Included')</h5>
											<ul>
												<li><i class="fad fa-rotate"></i>  {{__($package['revision'])}} @lang("revisions")</li>
												<li><i class="fad fa-clock"></i> @lang('Delivery within') {{__($package['delivery'])}} @lang("day\'s")</li>

											</ul>
											@if($listingDetails->user_id != auth()->user()->id)

												<button type="button" data-id="{{$listingDetails->id}}" data-package_name="{{__($package['package_name'])}}" data-amount="{{__($package['package_price'])}}" data-influencer="{{__($listingDetails->user->name)}}" data-user_id="{{auth()->user()->id}}" data-influencer_id="{{$listingDetails->user->id}}" class="btn-custom w-100 continue "  data-bs-toggle="modal" data-bs-target="#staticBackdrop">
													@lang('Continue')
												</button>
											@endif
										</div>
									@endforeach

								</div>
							</div>
						</div>
					</div>

				</div>
			</div>
		</div>
	</section>

	<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content ">
				<div class="modal-header">
					<h5 class="modal-title title" id="exampleModalLabel"></h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>

				<form method="post" action="{{route('user.listing.order.store')}}" enctype="multipart/form-data">
					@csrf
					<div class="modal-body">
						<div class="form-box">
							<div class="row">
								<input type="hidden" name="id">
								<input type="hidden" name="user_id">
								<input type="hidden" name="influencer_id">
								<input type="hidden" name="package_name">
								<div class="input-box col-lg-6">
									<label for="influencer" >@lang('Influencer')</label>
									<input id="influencer" name="influencer" class="form-control" value="" readonly>
									@if($errors->has('influencer'))
										<div class="error text-danger">@lang($errors->first('influencer')) </div>
									@endif
								</div>

								<div class="input-box col-lg-6">
									<label for="amount">@lang('Amount')</label>
									<div class="input-group mb-3">
										<input id="amount" type="text" name="amount"  class="form-control" readonly>
										<span class="input-group-text" id="basic-addon2">{{__($basic->base_currency)}}</span>
									</div>
									@if($errors->has('amount'))
										<div class="error text-danger">@lang($errors->first('amount')) </div>
									@endif
								</div>
							</div>

							<div class="row mb-2">
								<div class="input-box col-lg-6">
									<label for="payment" >@lang('Choose Payment')</label>
									<select id="payment" class="form-select js-example-basic-multiple-limit" name="payment_type">
										<option value="1">@lang('Payment Gateway')</option>
										<option value="2">@lang('Wallet')</option>
									</select>

									@if($errors->has('payment_type'))
										<div class="error text-danger">@lang($errors->first('payment_type')) </div>
									@endif
								</div>
								<div class="input-box col-lg-6">
									<label for="date">@lang('Delivery Date')</label>
									<input class="form-control flatpickr_date" type="text" id="date" value="{{@request()->from_date}}" name="delivery_date" placeholder="@lang('From Date')" autocomplete="off"/>

									@if($errors->has('delivery_date'))
										<div class="error text-danger">@lang($errors->first('delivery_date')) </div>
									@endif
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-primary">@lang('Order Confirm')</button>
					</div>

				</form>
			</div>
		</div>
	</div>



	<div class="modal fade" id="messageModal" tabindex="-1" aria-labelledby="messageModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="messageModalLabel">@lang('Contact with Influencer')</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<form action="{{route('user.proposer.message')}}" method="POST">
					@csrf
					<div class="modal-body">
						<input type="hidden" class="form-control" name="sender_id">
						<input type="hidden" class="form-control" name="receiver_id">
						<input type="hidden" class="form-control" name="listing_id">

						<div class="input-box col-lg-12">
							<label for="message">@lang('Message')</label>
							<div class="input-group mb-3">
								<textarea class="form-control" name="message" rows="2" cols="10" placeholder="@lang('write something ...')"></textarea>

							</div>
							@if($errors->has('message'))
								<div class="error text-danger">@lang($errors->first('message')) </div>
							@endif
						</div>

					</div>
					<div class="modal-footer">

						<button type="submit" class="btn btn-primary">@lang('Send')</button>
					</div>
				</form>

			</div>
		</div>
	</div>
@endsection

@push('css-lib')
	<link rel="stylesheet" href="{{asset($themeTrue.'css/flatpickr.min.css')}}">
	<link rel="stylesheet" href="{{asset($themeTrue.'css/fancybox.css')}}"/>
@endpush

@push('extra-js')
	<script src="{{asset($themeTrue.'js/flatpickr.js')}}"></script>
	<script src="{{asset($themeTrue.'js/fancybox.umd.js')}}"></script>
@endpush
@push('extra_scripts')
	<script src="{{asset($themeTrue.'js/fancybox.umd.js')}}"></script>
@endpush
@push('script')

	@if($errors->has('influencer') || $errors->has('amount') || $errors->has('payment_type') || $errors->has('delivery_date'))
		<script defer>
			var myModal = new bootstrap.Modal(document.getElementById("staticBackdrop"), {});
			document.onreadystatechange = function () {
				myModal.show();
			};
		</script>
	@endif

	@if($errors->has('influencer') || $errors->has('amount') || $errors->has('payment_type') || $errors->has('delivery_date'))
		<script defer>
			var myModal = new bootstrap.Modal(document.getElementById("staticBackdrop"), {});
			document.onreadystatechange = function () {
				myModal.show();
			};
		</script>
	@endif

	<script>

		$('.continue').on('click',function (){
			let listing_id = $(this).attr('data-id');
			let user_id = $(this).attr('data-user_id');
			let influencer_id = $(this).attr('data-influencer_id');
			let influencer = $(this).attr('data-influencer');
			let package_name = $(this).attr('data-package_name');
			let amount = $(this).attr('data-amount');
			let modal = $('#staticBackdrop');

			modal.find('.title').text("Package : " + package_name);
			modal.find('[name="id"]').val(listing_id);
			modal.find('[name="user_id"]').val(user_id);
			modal.find('[name="influencer_id"]').val(influencer_id);
			modal.find('[name="influencer"]').val(influencer);
			modal.find('[name="package_name"]').val(package_name);
			modal.find('[name="amount"]').val(amount);

		});

		$(document).ready(function (){
			$(".flatpickr_date").flatpickr({
				minDate: "today",
				altInput: true,
				altFormat: "d/m/y",
				dateFormat: "Y-m-d",
			});
		});

		$('.message').on('click',function(){
			let modal = $('#messageModal');
			modal.find('input[name="sender_id"]').val($(this).attr('data-sender_id'));
			modal.find('input[name="receiver_id"]').val($(this).attr('data-receiver_id'));
			modal.find('input[name="listing_id"]').val($(this).attr('data-listing_id'));
		})

		$('.helpful').on('click',function (){
			var is_helpful = $(this).attr('data-value');
			var review_id = $(this).data('id');

			$.ajax({
				url: '{{ route('user.isHelpful') }}',
				type: 'GET',
				data: { is_helpful: is_helpful, review_id: review_id },
				success: function (response) {
					if (response.is_helpful === 'yes') {
						$('.helpful[data-value="yes"][data-id="' + review_id + '"]').html('<i class="fa-solid fa-thumbs-up"></i> @lang('Yes')');

						$('.helpful[data-value="no"][data-id="' + review_id + '"]').html('<i class="fa-light fa-thumbs-down"></i> @lang('No')');
					}
					else if (response.is_helpful === 'no') {
						$('.helpful[data-value="yes"][data-id="' + review_id + '"]').html('<i class="fa-light fa-thumbs-up"></i> @lang('Yes')');
						$('.helpful[data-value="no"][data-id="' + review_id + '"]').html('<i class="fa-solid fa-thumbs-down"></i> @lang('No')');
					}

				},
				error: function (xhr, status, error) {
					console.error(xhr.responseText);
				}
			});

		});

	</script>

@endpush
