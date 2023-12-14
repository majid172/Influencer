@extends($theme.'layouts.app')
@section('title',__('SMS Verification'))

@section('content')
	<!-- SMS section -->
	<section class="login-section recover-password">
		<div class="container">
			<div class="row justify-content-center align-items-end">
				<div class="col-lg-5">
					<div class="form-wrapper">
						<div class="form-box">
							<form action="{{ route('user.smsVerify') }}" method="post">
								@csrf
								<div class="row g-4">
									<div class="col-12">
										<h4>@lang('SMS Verification')</h4>
									</div>
									<div class="input-box col-12">
										<input type="text" name="code" class="form-control" placeholder="@lang('Code')"/>
										<div class="text-danger">
											@error('code') @lang($message) @enderror
											@error('error') @lang($message) @enderror
										</div>
									</div>
									<div class="input-box col-12">
										<button type="submit" class="btn-custom w-100">@lang('Submit')</button>
									 </div>
								</div>
								@if (Route::has('user.resendCode'))
									<div class="bottom">
										<p>
											@lang("Didn't get Code? Click to") <a href="{{route('user.resendCode')}}?type=phone">@lang("Resend code")</a>
										</p>
										@error('resend')
											<p class="text-danger mt-1">@lang($message)</p>
										@enderror
									</div>
								@endif
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
@endsection
