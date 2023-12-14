@extends($theme.'layouts.app')
@section('title',__('Sign In'))

@section('content')
	<section class="login-section">
		<div class="container">
			<div class="row justify-content-center align-items-end">
				<div class="col-lg-7">
					<div class="img-box">
						@if(isset($signIn['sign-in'][0]) && $login = $signIn['sign-in'][0])
							<img src="{{getFile(optional($login->media)->driver,@$login->templateMedia()->image)}}"
								 alt="@lang('login img')"/>
						@endif
					</div>
				</div>

				<div class="col-lg-5">
					<div class="form-wrapper">
						<div class="form-box">
							<form action="{{ route('login') }}" method="post">
								@csrf
								<div class="row g-4">
									@if(isset($signIn['sign-in'][0]) && $signIn = $signIn['sign-in'][0])
										<div class="col-12">
											<h4>@lang(@$signIn['description']->title)</h4>
										</div>
									@endif
									<input type="hidden" name="timezone" class="timeZone" value="">
									<div class="input-box col-12">
										<input type="text" name="identity" value="{{ old('identity') }}"
											   class="form-control" @error('username') is-invalid
											   @enderror @error('email') is-invalid
											   @enderror placeholder="@lang('Username or Email')"/>
										<div class="text-danger">
											@error('username') @lang($message) @enderror
											@error('email') @lang($message) @enderror
										</div>
									</div>

									<div class="input-box col-12">
										<input type="password" name="password" class="form-control"
											   @error('password') is-invalid @enderror placeholder="@lang('Password')"/>
										<div class="text-danger">
											@error('password') @lang($message) @enderror
										</div>
									</div>
										@if((basicControl()->manual_reCaptcha_status == 1) && (basicControl()->reCaptcha_status_login	== 1))
											<div class="input-box mb-4">
												<input type="text" tabindex="2" class="form-control @error('captcha') is-invalid @enderror" name="captcha" id="captcha" autocomplete="off"
													   placeholder="@lang('Enter captcha code')" required>
												@error('captcha')
												<span class="invalid-feedback">{{ $message }}</span>
												@enderror
											</div>

											<div class="mb-4">
												<div class="input-group input-group-merge d-flex justify-content-between" data-hs-validation-validate-class>
													<img src="{{route('captcha').'?rand='. rand()}}" id='captcha_image'>
													<a class="input-group-append input-group-text"
													   href='javascript: refreshCaptcha();'>
														<i class="fas fa-sync  "></i>
													</a>
												</div>
											</div>
										@endif

									@if(basicControl()->reCaptcha_status_login && basicControl()->google_reCaptcha_status)
										<div class="form-group">
											{!! NoCaptcha::renderJs() !!}
											{!! NoCaptcha::display() !!}
											@error('g-recaptcha-response')
											<div class="text-danger mt-1 mb-1">@lang($message)</div>
											@enderror
										</div>
									@endif


										<div class="col-12">
										<div class="links">
											<div class="form-check">
												<input class="form-check-input" type="checkbox"
													   id="flexCheckDefault"/>
												<label class="form-check-label"
													   for="flexCheckDefault">@lang('Remember Me')</label>
											</div>
											@if (Route::has('password.request'))
												<a href="{{ route('password.request') }}">@lang('Forgot Password')?</a>
											@endif
										</div>
									</div>

								</div>

								<button class="btn-custom w-100">@lang('Sign In')</button>

								<div class="bottom d-flex justify-content-between">
									<span>@lang("Don't have an account?")</span>
									<a href="{{ route('register') }}">@lang('Create account')</a>
								</div>

							</form>


							<div class="divider"><span>@lang('or sign in with')</span></div>
							<div class="social-links">
								@if(basicControl()->google_status_login)
									<a href="{{ route('social.oauth', 'google') }}" class="google">
										<i class="fab fa-google"></i>
									</a>
								@endif
								@if(basicControl()->facebook_status_login)
									<a href="{{ route('social.oauth', 'facebook') }}" class="facebook">
										<i class="fab fa-facebook-f"></i>
									</a>
								@endif
								@if(basicControl()->github_status_login)
									<a href="{{ route('social.oauth', 'github') }}" class="github">
										<i class="fab fa-github"></i>
									</a>
								@endif
								@if(basicControl()->linkedin_status_login)
									<a href="{{ route('social.oauth', 'linkedin') }}" class="linkedin">
										<i class="fab fa-linkedin-in"></i>
									</a>
								@endif
								@if(basicControl()->twitter_status_login)
									<a href="{{ route('social.oauth', 'twitter') }}" class="twitter">
										<i class="fab fa-twitter"></i>
									</a>
								@endif
							</div>

						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
@endsection

@push('script')
	<script>
		'use strict';
		function refreshCaptcha(){
			let img = document.images['captcha_image'];
			img.src = img.src.substring(
				0,img.src.lastIndexOf("?")
			)+"?rand="+Math.random()*1000;
		}
	</script>
@endpush
