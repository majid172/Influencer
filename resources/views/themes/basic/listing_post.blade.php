@foreach ($listings as $item)
	<div class="col-lg-3 col-md-6">
		<div class="listing-box">
			<div class="img-box">
				<img src="{{$item->cardImage}}" class="img-fluid" alt="@lang('listing img')"/>
			</div>
			<div class="text-box">
				<div class="author">
					<div class="author-img">
						{!! $item->user->profilePicture() !!}
					</div>
					<div class="author-info">
						<a href="{{route('influencer.profile', optional($item->user)->username)}}"
						   class="name" target="_blank">@lang(__(optional($item->user)->name))</a>
						<span>{{__(optional(optional($item->user)->profile)->seller_type)}}</span>
					</div>
				</div>
				<a href="{{route('user.listing.details',[slug($item->title), $item->id])}}"
				   class="title">
					@lang(\Illuminate\Support\Str::limit($item->title,50))
				</a>
				<div class="d-flex justify-content-between">
					<p class="rating"><i class="fas fa-star"></i>
						<span>  {{@$item->review->avg('ratings')}} </span> (@lang('Sell')
						: {{$item->total_sell}})</p>
					<p class="price">@lang('starting at'): <span>
											{{basicControl()->currency_symbol}} {{$item->firstPackage()}}
										</span></p>
				</div>
			</div>
		</div>
	</div>
@endforeach
