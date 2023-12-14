@extends($theme.'layouts.user')
@section('page_title',__('2 Step Security'))

@section('content')

<div class="col-lg-8 col-md-6">
	<div class="row g-4">
		<div class="col-12">
			<h3 class="mb-0">@lang('2 FA Security')</h3>
		</div>
		<div class="col-lg-6">
			<div class="card-box">
				<form>
					@if (auth()->user()->two_fa)
						<h5>@lang('Two Factor Authenticator')</h5>
						<div class="input-box">
							<div class="input-group append">
								<input type="text" value="{{ $previousCode }}"
									   class="form-control"
									   id="referralURL" readonly>
								<button class="btn-custom py-0 copytext" type="button"
										id="copyBoard"
										onclick="copyFunction()"><i
										class="fa fa-copy"></i> @lang('Copy')
								</button>
							</div>
						</div>
						<div class="form-group mx-auto text-center my-3">
							<img class="mx-auto w-30" src="{{ $previousQR }}">
						</div>

						<div class="form-group mx-auto text-center mt-3">
							<a href="javascript:void(0)" class="btn-custom"
							   data-bs-toggle="modal"
							   data-bs-target="#disableModal">@lang('Disable Two Factor Authenticator')</a>
						</div>
					@else
						<h5>@lang('Two Factor Authenticator')</h5>
						<div class="input-box">
							<div class="input-group append">
								<input type="text" value="{{ $secret }}" class="form-control"
									   id="referralURL" readonly>
								<button class="btn-modify py-0 px-2 copytext" type="button"
										id="copyBoard"
										onclick="copyFunction()"><i
										class="fa fa-copy"></i> @lang('Copy')
								</button>
							</div>
						</div>
						<div class="form-group mx-auto text-center mt-5">
							<img class="w-30 mx-auto" src="{{ $qrCodeUrl }}">
						</div>

						<div class="form-group mx-auto text-center mt-3">
							<a href="javascript:void(0)"
							   class="btn-custom mt-3 w-100" data-bs-toggle="modal"
							   data-bs-target="#enableModal">@lang('Enable Two Factor Authenticator')</a>
						</div>

					@endif
				</form>
			</div>
		</div>
		<div class="col-lg-6">
			<div class="card-box">
				<h5 class="card-title">@lang('Google Authenticator')</h5>
				<h6 class="text-uppercase my-3">@lang('Use Google Authenticator to Scan the QR code  or use the code')</h6>
				<p class="p-3">@lang('Google Authenticator is a multifactor app for mobile devices. It generates timed codes used during the 2-step verification process. To use Google Authenticator, install the Google Authenticator application on your mobile device.')</p>
				<div class="text-end">
					<a class="btn-custom"
					   href="https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2&hl=en"
					   target="_blank">@lang('Download App')</a>
				</div>
			</div>
		</div>

	</div>
</div>

	@push('load-modal')
		<div class="modal fade" id="enableModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered modal-md">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="editModalLabel">@lang('Verify Your OTP')</h5>
						<button type="button" class="close-btn" data-bs-dismiss="modal" aria-label="Close">
							<i class="fal fa-times"></i>
						</button>
					</div>
					<form action="{{route('user.twoStepEnable')}}" method="POST">
						@csrf
						<div class="modal-body">
							<div class="row g-4">
								<input type="hidden" name="key" value="{{$secret}}">
								<div class="input-box col-12">
									<input class="form-control" type="text" name="code"
										   placeholder="@lang('Enter Google Authenticator Code')"/>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn-custom btn2"
									data-bs-dismiss="modal">@lang('Close')</button>
							<button type="submit" class="btn-custom">@lang('Verify')</button>
						</div>
					</form>
				</div>
			</div>
		</div>

		<div class="modal fade" id="disableModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered modal-md">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="editModalLabel">@lang('Verify Your OTP to Disable')</h5>
						<button type="button" class="close-btn" data-bs-dismiss="modal" aria-label="Close">
							<i class="fal fa-times"></i>
						</button>
					</div>
					<form action="{{route('user.twoStepDisable')}}" method="POST">
						@csrf
						<div class="modal-body">
							<div class="row g-4">
								<div class="input-box col-12">
									<input class="form-control" type="text" name="code"
										   placeholder="@lang('Enter Google Authenticator Code')"/>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn-custom btn2"
									data-bs-dismiss="modal">@lang('Close')</button>
							<button type="submit" class="btn-custom">@lang('Verify')</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	@endpush
@endsection
@section('scripts')
	<script>
		function copyFunction() {
			var copyText = document.getElementById("referralURL");
			copyText.select();
			copyText.setSelectionRange(0, 99999);
			document.execCommand("copy");
			Notiflix.Notify.Success(`Copied: ${copyText.value}`);
		}
	</script>
	@if ($errors->any())
		@php
			$collection = collect($errors->all());
			$errors = $collection->unique();
		@endphp
		<script>
			"use strict";
			@foreach ($errors as $error)
			Notiflix.Notify.Failure("{{ trans($error) }}");
			@endforeach
		</script>
	@endif
@endsection

