@extends($theme.'layouts.app')
@section('title',__('Listing Order'))
@section('content')
	<section class="checkout-section">
		<div class="overlay">
			<div class="container">
				<div class="row g-4 g-lg-5">
					<div class="col-lg-12">
						<div class="form-box">
							<h5>@lang('Package') : {{__($package_name)}}</h5>
							<form method="post" action="" enctype="multipart/form-data">
									<div class="row mb-2">
										<div class="input-box col-lg-6">
											<label for="influencer" >@lang('Influencer')</label>
											<input id="influencer" class="form-control" value="" readonly>
										</div>
										<div class="input-box col-lg-6">
											<label for="amount">@lang('Amount')</label>
											<input id="amount" type="text" value="{{$amount}}" class="form-control" readonly>
										</div>
									</div>

									<div class="row mb-2">
										<div class="input-box col-lg-6">
											<label for="payment" >@lang('Choose Payment')</label>
											<select id="payment" class="form-select js-example-basic-multiple-limit" name="payment">
												<option value="1">@lang('Payment Gateway')</option>
												<option value="2">@lang('Wallet')</option>
											</select>
										</div>
										<div class="input-box col-lg-6">
											<label for="date">@lang('Delivery Date')</label>
											<input id="date" type="date" class="form-control">
										</div>
									</div>

							</form>
						</div>
					</div>


				</div>
			</div>
		</div>
	</section>
@endsection


