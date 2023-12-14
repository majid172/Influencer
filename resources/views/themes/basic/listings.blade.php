@extends($theme.'layouts.app')
@section('title', trans('Influencer Listings'))

@section('content')

	<section class="listing-filter">
		<div class="container">
			<form action="#" method="get">
				@csrf
				<div class="row g-4 align-items-center">
					<div class="col-lg-6">
						<div class="row g-4">
							<div class="input-box col-xl-4 col-md-4">
								<select class="js-example-basic-single form-control category " id="category_id"
										name="categories">
									<option value="" selected disabled>@lang('Select a Category')</option>
									@foreach($categories as $category)
										<option value="{{$category->id}}">{{__(optional($category->details)->name)}}</option>
									@endforeach
								</select>

							</div>
							<div class="input-box col-xl-3 col-md-4">
								<select class="js-example-basic-single form-control sort" name="sort">
									<option value="" selected disabled>@lang('Sort by')</option>
									<option value="1">@lang('Best Selling')</option>

								</select>
							</div>
						</div>
					</div>

					<div class="col-12 mt-4">
						<div class="d-md-flex justify-content-between align-items-center">
							<div class="result-info">
								<p class="mb-md-0"
								   id="listing_count">{{$listings->count()}} @lang('services available')</p>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</section>

	<section class="listing-section">
		<div class="container">
			@if($listings->count() >0)
			<div class="row g-4" id="append_row">
				@include($theme.'listing_post')
			</div>
			@else
				<div class="">
					<div class="img-box text-center pt-3">
						<img src="{{asset($themeTrue.'images/no-data.png')}}" class="img-fluid no-data-img" alt="img" />
					</div>
					<div class="text-box">
						<h4 class="text-center">@lang('No Data Found')</h4>
					</div>
				</div>
			@endif

				<!-- Data Loader -->
				<div class="auto-load text-center d-none" >
					<svg version="1.1" id="L9" xmlns="http://www.w3.org/2000/svg"
						 xmlns:xlink="http://www.w3.org/1999/xlink"
						 x="0px" y="0px" height="60" viewBox="0 0 100 100" enable-background="new 0 0 0 0"
						 xml:space="preserve">
							<path fill="#000"
								  d="M73,50c0-12.7-10.3-23-23-23S27,37.3,27,50 M30.9,50c0-10.5,8.5-19.1,19.1-19.1S69.1,39.5,69.1,50">
								<animateTransform attributeName="transform" attributeType="XML" type="rotate" dur="1s"
												  from="0 50 50" to="360 50 50" repeatCount="indefinite"/>
							</path>
						</svg>
				</div>
		</div>
	</section>
@endsection

@push('script')
	<script>

		$(".js-example-basic-single").select2();

		$('#category_id').on('change', function () {
			var category = $(this).val();
			$.ajax({
				type: "POST",
				url: "{{route('user.get.subcategory')}}",
				data: {
					category: category,
					_token: '{{csrf_token()}}'
				},
				dataType: 'json',
				success: function (data) {
					var html = '';
					if (data.error) {
						$("#subCategoryId").empty();
						html += `<option value="" selected disabled>${data.error}</option>`;
						$(".subCategoryHtml").html(html);
					} else {
						$("#subCategoryId").empty();
						html += `<option value="" selected disabled>@lang('Select Sub Category')</option>`;
						$.each(data, function (index, item) {
							html += `<option value="${item.id}">${item.details.name}</option>`;
							$(".subCategoryHtml").html(html);
						});
					}
				}
			});
		});


		$('.category,.sort').on('change', function () {
			let category_id = $('.category').val();
			let sort = $('.sort').val();
			$.ajax({
				url: "{{route('filter.listing')}}",
				type: "GET",
				data: {
					category_id: category_id,
					sort: sort
				},
				success: function (response) {
					let listingArray = response;
					$('#listing_count').html(listingArray.length + ' ' + 'services available');
					$('#append_row').html('');

					if(listingArray.length >0)
					{
						listingArray.forEach(function (item, index) {

							let truncatedTitle = item.title.length > 50 ? item.title.substring(0, 50) + '...' : item.title;
							let markUp = `<div class="col-lg-3 col-md-6">
						<div class="listing-box">
							<div class="img-box">
								<img src="${item.cardImage}" class="img-fluid" alt="" />
							</div>
							<div class="text-box">
								<div class="author">
									<div class="author-img">
										${item.user_img}
									</div>
									<div class="author-info">
										<a href="${item.user_profile}" class="name" target="_blank">${item.user.name}</a>
										<span>${item.seller_type}</span>
									</div>
								</div>
								<a href="${item.route}" class="title">${truncatedTitle}</a>

						<div class="d-flex justify-content-between">
							<p class="rating"><i class="fas fa-star"></i> <span> ${item.ratings}</span> (@lang('Sell') ${item.total_sell})</p>
							<p class="price"><span>@lang('$')${item.firstValue}</span></p>
								</div>
							</div>
						</div>
					</div>`;

							$('#append_row').append(markUp);
						})
					}
					else{
						let markUp = ` <div class="">
									<div class="img-box text-center pt-3">
										<img src="{{asset($themeTrue.'images/no-data.png')}}" class="img-fluid no-data-img" alt="img" />
									</div>
									<div class="text-box">
										<h4 class="text-center">@lang('No Data Found')</h4>
									</div>
								</div>`;

						$('#append_row').append(markUp);
					}


				},
				error: function (xhr, status, error) {
					console.error(error);
				}
			});
		})

	</script>


	<script>
		var PAGE_ROUTE = "{{ route('allListings') }}";
		var page = 1;

		$(window).scroll(function () {

			if ($(window).scrollTop() + $(window).height() >= $(document).height() - 950) {
				page++;
				infiniteLoadMore(page);
			}
		});

		function infiniteLoadMore(page) {
			$.ajax({
				url: PAGE_ROUTE,
				data: {page: page},
				dataType: "html",
				type: "get",
				beforeSend: function () {
					$('.auto-load').show();
				}
			})
				.done(function (response) {
					let data = JSON.parse(response);
					if (!data.html) {
						$('.auto-load').html('<div class="mt-5">@lang("We don\'t have more data to display")</div>');
						return;
					}

					$('.auto-load').hide();
					$("#append_row").append(data.html);
				})
				.fail(function (jqXHR, textStatus, errorThrown) {
				});
		}
	</script>
@endpush
