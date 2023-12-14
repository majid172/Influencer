@extends($theme.'layouts.user')
@section('title',__('Escrow List'))
@section('content')
	<div class="col-xl-9 col-lg-8 col-md-12">


			<div class="row mb-3">
				<div class="container-fluid" id="container-wrapper">
					<div class="row justify-content-md-center">
						<div class="col-md-6">
							<div class="card shadow card-primary mb-4">
								<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
									<h6 class="m-0 font-weight-bold text-primary">@lang('Send Money') {{$escrow->budget}} {{basicControl()->base_currency}}</h6>
								</div>
								<div class="card-body">
									<form action="{{ route('transfer.initialize') }}" method="post">
										@csrf
										<div class="form-group">
											<input type="hidden" name="escrow_id" value="{{$escrow_id}}" class="escrow_id">
										</div>

										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<label for="recipient">@lang('Recipient email or username')</label>
													<input type="text" name="recipient" id="recipient"
														   placeholder="@lang('Please enter valid email or username')" autocomplete="off"
														   value="{{ __($receiver) }}"
														   class="form-control @error('recipient') is-invalid @enderror">
													<div class="invalid-feedback">
														@error('recipient') @lang($message) @enderror
													</div>
													<div class="valid-feedback"></div>
												</div>

											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label for="amount">@lang('Amount')</label>
													<input type="text" id="amount" value="{{ old('amount') }}" name="amount"
														   placeholder="@lang('0.00')"
														   class="form-control @error('amount') is-invalid @enderror"
														   autocomplete="off">
													<div class="invalid-feedback">
														@error('amount') @lang($message) @enderror
													</div>
													<div class="valid-feedback"></div>
												</div>
											</div>
										</div>

										<div class="form-group">
											<label for="note">@lang('Note')</label>
											<textarea name="note" rows="5" class="form-control form-control-sm"></textarea>
										</div>
										<button type="submit" id="submit" class="btn btn-primary btn-sm btn-block mt-2"
												disabled>@lang('Send Money')</button>
									</form>
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="card shadow card-primary mb-4">
								<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
									<h6 class="m-0 font-weight-bold text-primary">@lang('Transaction Details')</h6>
								</div>
								<div class="card-body showCharge">
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

		</section>
	</div>
@endsection

@section('scripts')
	<script>
		'use strict';
		$(document).ready(function () {
			$('[data-toggle="tooltip"]').tooltip()
			// let recipientField = $('#recipient');
			let amountField = $('#amount');
			let recipientStatus = false;
			let amountStatus = false;

			function clearMessage(fieldId) {
				$(fieldId).removeClass('is-valid')
				$(fieldId).removeClass('is-invalid')
				$(fieldId).closest('div').find(".invalid-feedback").html('');
				$(fieldId).closest('div').find(".is-valid").html('');
			}

			// $(document).on('input', "#recipient", function (e) {
			// 	let recipient = $(recipientField).val();
			// 	if (recipient === '') {
			// 		clearMessage(recipientField)
			// 	}
			// 	if (recipient.length >= 4) {
			// 		checkRecipient();
			// 	}
			// });

			$(document).on('change, input', "#amount, #charge_from, #currency", function (e) {
				e.preventDefault();
				let amount = amountField.val();
				let currency_id = 1;
				let currency_code = 'USD';
				let currency_type = 1;

				// let transaction_type_id = 1; //transfer
				let charge_from = 1;

				if (!isNaN(amount) && amount > 0) {

					let fraction = amount.split('.')[1];
					let limit = "{{config('basic.fraction_number')}}";
					if (fraction && fraction.length > limit) {
						amount = (Math.floor(amount * Math.pow(10, limit)) / Math.pow(10, limit)).toFixed(limit);
						amountField.val(amount);
					}
					checkAmount(amount, currency_id, charge_from, currency_code);
				} else {
					clearMessage(amountField);
					$('.showCharge').html('');
				}

			});

			

			function checkAmount(amount, currency_id, charge_from, currency_code) {
				$.ajax({
					method: "GET",
					url: "{{ route('transfer.checkAmount') }}",
					dataType: "json",
					data: {
						'amount': amount,
						'currency_id': currency_id,
						'charge_from': charge_from,
					}
				})
					.done(function (response) {
						let amountField = $('#amount');
						if (response.status) {
							clearMessage(amountField)
							$(amountField).addClass('is-valid')
							$(amountField).closest('div').find(".valid-feedback").html(response.message)
							amountStatus = true;
							submitButton()
							showCharge(response, currency_code)
						} else {
							amountStatus = false;
							submitButton()
							$('.showCharge').html('')
							clearMessage(amountField)
							$(amountField).addClass('is-invalid')
							$(amountField).closest('div').find(".invalid-feedback").html(response.message);
						}
					});
			}

			function isEmail(email) {
				let regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
				return regex.test(email);
			}

			function submitButton() {
				if (amountStatus) {
					$("#submit").removeAttr("disabled");
				} else {
					$("#submit").attr("disabled", true);
				}
			}

			function showCharge(response, currency_code) {
				let txnDetails = `
			<ul class="list-group">
				<li class="list-group-item d-flex justify-content-between">
					<span>{{ __('Available Balance') }}</span>
					<span class="text-success"> ${response.balance} ${currency_code}</span>
				</li>
				<li class="list-group-item d-flex justify-content-between">
					<span>{{ __('Transfer Charge') }}</span>
					<span class="text-danger">  ${response.charge} ${currency_code}</span>
				</li>
				<li class="list-group-item d-flex justify-content-between">
					<span>{{ __('Payable Amount') }}</span>
					<span class="text-info"> ${response.transfer_amount} ${currency_code}</span>
				</li>
				<li class="list-group-item d-flex justify-content-between">
					<span>{{ __('Receiver will received') }}</span>
					<span class="text-info"> ${response.received_amount} ${currency_code}</span>
				</li>
				<li class="list-group-item d-flex justify-content-between">
					<span>{{ __('Remaining Balance') }}</span>
					<span class="text-primary"> ${response.remaining_balance} ${currency_code}</span>
				</li>

			</ul>
			`;
				$('.showCharge').html(txnDetails);
			}
		});
	</script>
@endsection
