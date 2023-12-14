@extends($theme.'layouts.app')
@section('title',__('Add Fund'))
@section('content')

	<section class="checkout-section">
		<div class="overlay">
			<div class="container">
				<form action="{{ route('fund.initialize') }}" method="post">
					@csrf
				<div class="row g-4 g-lg-5">
					<div class="col-lg-8">
						<div class="form-box">
							<h5>@lang('Select Payment Method')</h5>
							<div class="payment-section">
								<ul class="payment-container-list list-unstyled">
									@foreach($methods as $key=>$method)
									<li class="item paymentCheck">
										<input class="form-check-input" type="radio" name="methodId"
											    id="{{$key}}" value="{{ $method->id }}" {{ old('methodId') == $method->id || $key == 0 ? ' checked' : ''}}>
										<label class="form-check-label" for="{{$key}}">
											<div class="image-area">
												<img src="{{getFile($method->driver,$method->image)}}" alt="gateway_img">
											</div>
											<div class="content-area">
												<h5>{{__($method->name)}}</h5>

											</div>
										</label>

									</li>
									@endforeach

								</ul>
							</div>

						</div>

					</div>

					<!-- side bar start -->
					<div class="col-lg-4">
						<div class="side-bar">
							<div class="side-box">
								<div class="transfer-details-section balance">
									<ul class="transfer-list list-unstyled border-top-0">
										<li class="item title">
											<h6>@lang('Transfer details')</h6>
										</li>
										<li class="item">
											<span>@lang('Amount')</span>
											<span>
												<div class="input-group">
													<input type="text" id="amount" name="amount" placeholder="@lang('0.00')" class="form-control @error('amount') is-invalid @enderror"
														   autocomplete="off">
													<div class="input-group-prepend">
														<span class="form-control">{{config('basic.base_currency')}}</span>
													</div>
												</div>
												<div class="invalid-feedback">
													@error('amount') @lang($message) @enderror
												</div>
												<div class="valid-feedback"></div>
											</span>

										</li>

									</ul>
									<button type="submit" class="btn btn-custom w-100">@lang('confirm and continue')</button>
								</div>
							</div>
						</div>
					</div>

				</div>
				</form>
			</div>
		</div>

	</section>
@endsection

@push('script')
	<script>
		'use strict'
		$(document).on('click','.paymentCheck',function(){
			let amountText = $('.amount').text();
			let amount = parseFloat(amountText);
			let currency_code = "{{config('basic.base_currency')}}";
			let methodId = $("input[type='radio'][name='methodId']:checked").val();
			if(!isNaN(amount) && amount > 0)
			{
				checkAmount(amount, methodId, currency_code)

			}
		});
		function checkAmount(amount,methodId,currency_code)
		{
			$.ajax({
				method:"GET",
				url: "{{ route('deposit.checkAmount') }}",
				dataType: "json",
				data: {
					'amount': amount,
					'methodId': methodId,
				}
			})
				.done(function (response){
					showCharge(response,currency_code);
				});
		}
		function showCharge(response,currency_code){
			let txnDetails = `<ul class="transfer-list">
										<li class="item title">
											<h6>{{__('Transfer Details')}}</h6>
										</li>
										<li class="item">
											<span>{{__('You send exactly')}}</span>
											<h5>${response.amount} ${currency_code}</h5>
										</li>

										<li class="item">
											<span>{{__('Charge  (inclueded)')}}</span>
											<span>${response.charge} ${currency_code}</span>
										</li>

										<li class="item">
											<span>{{__('Payable Amount')}}</span>
											<span>${response.payable_amount} ${currency_code}</span>
										</li>
										`;
			$('.balance').html(txnDetails);
		}
	</script>

@endpush


