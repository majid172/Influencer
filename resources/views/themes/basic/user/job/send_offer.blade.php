@extends($theme.'layouts.user')
@section('title',__('Job Offer'))
@section('content')

	@if($offer_count > 0)
	<div class="col-xl-9 col-lg-8 col-md-12 change-password" id="data-wrapper">
		@include($theme.'infinite.send_offer_iteration')
	</div>
	@else
	<div class="job-box text-center">
		<img src="{{asset($themeTrue.'images/no-data.png')}}" alt="@lang('no-data')" class="no-data-img"> <br>
		<p class="text-center">@lang('No data found')</p>
	</div>
@endif
		<div class="auto-load text-center d-none">
			<svg version="1.1" id="L9" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
				 x="0px" y="0px" height="60" viewBox="0 0 100 100" enable-background="new 0 0 0 0" xml:space="preserve">
				<path fill="#000"
					  d="M73,50c0-12.7-10.3-23-23-23S27,37.3,27,50 M30.9,50c0-10.5,8.5-19.1,19.1-19.1S69.1,39.5,69.1,50">
					<animateTransform attributeName="transform" attributeType="XML" type="rotate" dur="1s"
									  from="0 50 50" to="360 50 50" repeatCount="indefinite" />
				</path>
			</svg>
		</div>
@endsection

@push('scripts')
	<script>
		var PAGE_ROUTE = "{{ route('user.job.send_offer') }}";
		var page = 1;

		$(window).scroll(function() {

			if ($(window).scrollTop() + $(window).height() >= $(document).height() - 500) {
				page++;
				infiniteLoadMore(page);
			}
		});

		function infiniteLoadMore(page) {
			$.ajax({
				url: PAGE_ROUTE,
				data: { page: page },
				dataType: "html",
				type: "get",
				beforeSend: function() {
					$('.auto-load').show();
				}
			})
				.done(function(response) {
					let data = JSON.parse(response);
					if (!data.html) {
						$('.auto-load').html('<div class="card-box">We don\'t have more data to display</div>');
						return;
					}
					$('.auto-load').hide();
					$("#data-wrapper").append(data.html);
				})
				.fail(function(jqXHR, textStatus, errorThrown) {
				});
		}
	</script>
@endpush
