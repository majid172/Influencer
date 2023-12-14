@extends($theme.'layouts.user')
@section('title',__('Send Payout Request'))
@section('content')
<div class="col-xl-9 col-lg-8 col-md-12 change-passwordontent">
	<div class="checkout-section payout-request">
		<div class="row g-4">
			<div class="col-lg-8">
				<form action="{{ route('payout.request') }}" method="post">
					<div class="payment-box">
						<div class="payment-options">
							@csrf
							<div class="row g-2 mb-2">
								@foreach($payoutMethods as $key => $value)
									<div class="col-3 col-md-4 col-lg-3">
										<input type="radio" class="btn-check" name="methodId" id="{{ $key }}" value="{{ $value->id }}" {{ old('methodId') == $value->id ? ' checked' : ''}}/>
										<label class="btn btn-primary" for="{{ $key }}">
											<img class="img-fluid" src="{{ getFile($value->driver,$value->logo) }}">
											<i class="fa-regular fa-check"></i>
										</label>
									</div>
								@endforeach
							</div>
						</div>
						<div class="input-group">
							<input type="text" name="amount" value="{{ old('amount') }}" class="form-control @error('amount') is-invalid @enderror" placeholder="@lang('Enter Amount')">
							<button class="btn-custom btn-sm" type="submit">@lang('Submit')</button>
						</div>
					</div>
				</form>
			</div>

			<div class="col-lg-4">
				<div class="side-bar">
					<div class="side-box">
						<h6 class="">@lang('Details')</h6>
						<div class="d-flex align-items-center justify-content-center">
							<div class="no_data" id="no_data">
								<img src="{{asset($themeTrue.'images/no-data.png')}}" class="img-fluid no-data-img" alt="img" />
								<p class="text-center">@lang('Empty Details')</p>
							</div>
						</div>

						<div class="showCharge d-none">
							<ul class="list-unstyled">
								<li class="d-flex justify-content-between align-items-center">
									<span>@lang('Fixed charge')</span>
									<span class="text-danger" id="fixed_charge"></span>
								</li>
								<li class="d-flex justify-content-between align-items-center">
									<span>@lang('Percentage charge')</span><span class="text-danger"
																				 id="percentage_charge"></span>
								</li>
								<li class="d-flex justify-content-between align-items-center">
									<span>@lang('Min limit')</span>
									<span class="text-info" id="min_limit"></span>
								</li>
								<li class="d-flex justify-content-between align-items-center">
									<span>@lang('Max limit')</span>
									<span class="text-info" id="max_limit"></span>
								</li>

								@if(auth()->user()->is_influencer)
									<li class="d-flex justify-content-between align-items-center">
										<span>@lang('Seller Charge')</span>
										<span class="text-info" id="seller_charge"></span>
									</li>
								@endif

							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

@endsection

@section('scripts')
    <script>
        'use strict';
        $(document).ready(function () {
            $(document).on('input', 'input[name="amount"]', function () {
                let limit = '{{ $baseControl->fraction_number }}';
                let amount = $(this).val();

                let fraction = amount.split('.')[1];
                if (fraction && fraction.length > limit) {
                    amount = (Math.floor(amount * Math.pow(10, limit)) / Math.pow(10, limit)).toFixed(limit);
                    $(this).val(amount);
                }
            });

            $(document).on('change', "input[type=radio][name=methodId]", function (e) {
                let methodId = this.value;

                $.ajax({
                    method: "GET",
                    url: "{{ route('payout.checkLimit') }}",
                    dataType: "json",
                    data: {'methodId': methodId}
                })
                    .done(function (response) {
                        let amountField = $('#amount');
                        if (response.status) {
                            $('.showCharge').removeClass('d-none');
                            $('#fixed_charge').html(response.fixed_charge + ' ' + response.currency_code);
                            $('#percentage_charge').html(response.percentage_charge + ' ' + response.currency_code);
                            $('#min_limit').html(parseFloat(response.min_limit).toFixed(response.currency_limit) + ' ' + response.currency_code);
                            $('#max_limit').html(parseFloat(response.max_limit).toFixed(response.currency_limit) + ' ' + response.currency_code);
                            $('#seller_charge').html(parseFloat(response.charge_by_seller)+ ' ' + '%');
							$('#no_data').hide();
                        } else {
                            $('.showCharge').addClass('d-none');
							$('#no_data').show();
                        }
                    });
            });
        });
    </script>
@endsection
