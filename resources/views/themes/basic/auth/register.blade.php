@extends($theme.'layouts.app')
@section('title',__('Sign Up'))

@section('content')
	<!-- Account -->
	<section class="login-section register">
		<div class="container">
			<div class="row justify-content-center align-items-end">
				<div class="col-lg-6">
					@if(isset($signUp['sign-up'][0]) && $signUp = $signUp['sign-up'][0])
						<div class="form-wrapper">
							<div class="text-center">
								<div class="nav nav-pills" id="pills-tab" role="tablist">
									<button class="btn-custom active" id="pills-influencer-tab" data-bs-toggle="pill"
										data-bs-target="#pills-influencer" type="button" role="tab"
										aria-controls="pills-influencer" aria-selected="true">
										@lang($signUp['description']->button_one_name)
									</button>
									<button class="btn-custom" id="pills-client-tab" data-bs-toggle="pill"
										data-bs-target="#pills-client" type="button" role="tab" aria-controls="pills-client"
										aria-selected="false">
										@lang($signUp['description']->button_two_name)
									</button>
								</div>
							</div>


							<div class="form-box">
								<div class="tab-content" id="pills-tabContent">

                  					<!---influencer--->
									<div class="tab-pane fade show active" id="pills-influencer" role="tabpanel"
										aria-labelledby="pills-influencer-tab">
										<div class="mb-4">
											<h4>@lang($signUp['description']->title_one)</h4>
										</div>
										<form action="{{ route('register') }}" method="post">
											@csrf
											<div class="row g-3">
												@if($referral)
													<div class="input-box col-lg-12">
														<input type="text" name="referral" value="{{ old('referral',$referral) }}"
															class="form-control" placeholder="@lang('Enter Referral Username')"/>
														<div class="text-danger">@error('referral') @lang($message) @enderror</div>
													</div>
												@endif

												<input type="hidden" class="form-control" name="is_influencer" value="1"/>
												<input type="hidden" name="timezone" class="timeZone" value="">

												<div class="input-box col-lg-12">
													<input type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="@lang('Enter Full Name')"/>
													<div class="text-danger">@error('name') @lang($message) @enderror</div>
												</div>
												<div class="input-box col-lg-12">
													<input type="email" name="email" value="{{ old('email') }}" class="form-control" placeholder="@lang('Enter Email')"/>
													<div class="text-danger">@error('email') @lang($message) @enderror</div>
												</div>
												<div class="input-box col-lg-12">
													<input type="text" name="username" value="{{ old('username') }}" class="form-control" placeholder="@lang('Enter Username')"/>
													<div class="text-danger">@error('username') @lang($message) @enderror</div>
												</div>
												<div class="input-box col-lg-12">
													<div class="row g-2">
														<div class="col-6">
															<span class="" id="basic-addon1">
																<select name="phone_code" class="form-select country_code">
																@foreach($countries as $value)
																		<option value="{{$value['phone_code']}}"
																				data-name="{{$value['name']}}"
																				data-code="{{$value['code']}}"
																			{{$country_code == $value['code'] ? 'selected' : ''}}>
																		{{ __($value['phone_code']) }} <strong> ({{ __($value['name']) }})</strong>
																	</option>
																@endforeach
																</select>
															</span>
														</div>
														<div class="col-6">
															<input type="text" name="phone" value="{{old('phone')}}" class="form-control"
															   placeholder="@lang('Your Phone Number')"
															   aria-label="Username" aria-describedby="basic-addon1">
														</div>
													</div>
													@error('phone')
													<p class="text-danger mt-1">@lang($message)</p>
													@enderror
												</div>
												<div class="input-box col-lg-12">
													<input type="password" name="password" value="{{ old('password') }}" class="form-control" placeholder="@lang('Password')"/>
													<div class="text-danger">@error('password') @lang($message) @enderror</div>
												</div>
												<div class="input-box col-lg-12">
													<input type="password" name="password_confirmation" class="form-control" placeholder="@lang('Re-type Password')"/>
												</div>

													@if((basicControl()->manual_reCaptcha_status == 1) && (basicControl()->reCaptcha_status_registration	== 1))
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
																<a class="input-group-append input-group-text text-white"
																   href='javascript: refreshCaptcha();'>
																	<i class="fal fa-sync"></i>
																</a>
															</div>
														</div>
													@endif

												@if(basicControl()->reCaptcha_status_registration && basicControl()->google_reCaptcha_status)
													<div class="form-group">
														{!! NoCaptcha::renderJs() !!}
														{!! NoCaptcha::display() !!}
														@error('g-recaptcha-response')
														<div class="text-danger">@lang($message)</div>
														@enderror
													</div>
												@endif


											</div>

											<button type="submit" class="btn-custom w-100">@lang('Sign Up')</button>

											<div class="bottom">
												@lang('Already have an account?')
												<a href="{{ route('login') }}">@lang('Login here')</a>
											</div>
										</form>

										<div class="divider"><span>@lang('or sign in with')</span></div>
										<div class="social-links">
											@if(basicControl()->google_status_registration)
												<a href="{{ route('social.oauth', 'google') }}" class="google">
													<i class="fab fa-google"></i>
												</a>
											@endif
											@if(basicControl()->facebook_status_registration)
												<a href="{{ route('social.oauth', 'facebook') }}" class="facebook">
													<i class="fab fa-facebook-f"></i>
												</a>
											@endif
											@if(basicControl()->github_status_registration)
												<a href="{{ route('social.oauth', 'github') }}" class="github">
													<i class="fab fa-github"></i>
												</a>
											@endif
											@if(basicControl()->linkedin_status_registration)
												<a href="{{ route('social.oauth', 'linkedin') }}" class="linkedin">
													<i class="fab fa-linkedin-in"></i>
												</a>
											@endif
											@if(basicControl()->twitter_status_registration)
												<a href="{{ route('social.oauth', 'twitter') }}" class="twitter">
													<i class="fab fa-twitter"></i>
												</a>
											@endif
										</div>
									</div>


                  					<!---client--->
									<div class="tab-pane fade" id="pills-client" role="tabpanel"
										aria-labelledby="pills-client-tab">
										<div class="mb-4">
											<h4>@lang($signUp['description']->title_two)</h4>
										</div>
										<form action="{{ route('register') }}" method="post">
											@csrf
											<div class="row g-3">
												@if($referral)
													<div class="input-box col-lg-12">
														<input type="text" name="referral" value="{{ old('referral',$referral) }}"
															class="form-control" placeholder="@lang('Enter Referral Username')"/>
														<div class="text-danger">@error('referral') @lang($message) @enderror</div>
													</div>
												@endif

												<input type="hidden" class="form-control" name="is_client" value="1"/>
												<input type="hidden" name="timezone" class="timeZone" value="">

												<div class="input-box col-lg-12">
													<input type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="@lang('Enter Full Name')"/>
													<div class="text-danger">@error('name') @lang($message) @enderror</div>
												</div>
												<div class="input-box col-lg-12">
													<input type="email" name="email" value="{{ old('email') }}" class="form-control" placeholder="@lang('Enter Email')"/>
													<div class="text-danger">@error('email') @lang($message) @enderror</div>
												</div>
												<div class="input-box col-lg-12">
													<input type="text" name="username" value="{{ old('username') }}" class="form-control" placeholder="@lang('Enter Username')"/>
													<div class="text-danger">@error('username') @lang($message) @enderror</div>
												</div>
												<div class="input-box col-lg-12">
													<div class="row g-2">
														<div class="col-6">
															<span class="" id="basic-addon1">
																<select name="phone_code" class="form-select country_code">
																@foreach($countries as $value)
																		<option value="{{$value['phone_code']}}"
																				data-name="{{$value['name']}}"
																				data-code="{{$value['code']}}"
																			{{$country_code == $value['code'] ? 'selected' : ''}}>
																		{{ __($value['phone_code']) }} <strong> ({{ __($value['name']) }})</strong>
																	</option>
																@endforeach
																</select>
															</span>
														</div>
														<div class="col-6">
															<input type="text" name="phone" value="{{old('phone')}}" class="form-control"
															   placeholder="@lang('Your Phone Number')"
															   aria-label="Username" aria-describedby="basic-addon1">
														</div>
													</div>
													@error('phone')
													<p class="text-danger mt-1">@lang($message)</p>
													@enderror
												</div>
												<div class="input-box col-lg-12">
													<input type="password" name="password" value="{{ old('password') }}" class="form-control" placeholder="@lang('Password')"/>
													<div class="text-danger">@error('password') @lang($message) @enderror</div>
												</div>
												<div class="input-box col-lg-12">
													<input type="password" name="password_confirmation" class="form-control" placeholder="@lang('Re-type Password')"/>
												</div>
												@if(basicControl()->reCaptcha_status_registration &&  basicControl()->google_reCaptcha_status)

													<div class="form-group">
														{!! NoCaptcha::renderJs() !!}
														{!! NoCaptcha::display() !!}
														@error('g-recaptcha-response')
															<div class="text-danger">@lang($message)</div>
														@enderror
													</div>
												@endif

												<div class="col-12">
													<div class="links">
														<div class="form-check">
															<input class="form-check-input" type="checkbox" value=""
																id="flexCheckDefault" />
															<label class="form-check-label" for="flexCheckDefault">
																@lang('I Agree with the Terms & conditions')
															</label>
														</div>
													</div>
												</div>
											</div>

											<button type="submit" class="btn-custom w-100">@lang('Sign Up')</button>

											<div class="bottom">
												@lang('Already have an account?')
												<a href="{{ route('login') }}">@lang('Login here')</a>
											</div>
										</form>

										<div class="divider"><span>@lang('or sign in with')</span></div>
										<div class="social-links">
											@if(basicControl()->google_status_registration)
												<a href="{{ route('social.oauth', 'google') }}" class="google">
													<i class="fab fa-google"></i>
												</a>
											@endif
											@if(basicControl()->facebook_status_registration)
												<a href="{{ route('social.oauth', 'facebook') }}" class="facebook">
													<i class="fab fa-facebook-f"></i>
												</a>
											@endif
											@if(basicControl()->github_status_registration)
												<a href="{{ route('social.oauth', 'github') }}" class="github">
													<i class="fab fa-github"></i>
												</a>
											@endif
											@if(basicControl()->linkedin_status_registration)
												<a href="{{ route('social.oauth', 'linkedin') }}" class="linkedin">
													<i class="fab fa-linkedin-in"></i>
												</a>
											@endif
											@if(basicControl()->twitter_status_registration)
												<a href="{{ route('social.oauth', 'twitter') }}" class="twitter">
													<i class="fab fa-twitter"></i>
												</a>
											@endif
										</div>
									</div>

								</div>
							</div>
						</div>
					@endif
				</div>
			</div>
		</div>
	</section>
	<!-- Account -->
@endsection


@push('script')
	<script>
		"use strict";

		function refreshCaptcha(){
			let img = document.images['captcha_image'];
			img.src = img.src.substring(
				0,img.src.lastIndexOf("?")
			)+"?rand="+Math.random()*1000;
		}

		$(document).ready(function () {
			$(document).on('change', ".country_code", function () {
			});
		})

		var getTimeZone = Intl.DateTimeFormat().resolvedOptions().timeZone;
		$('.timeZone').val(getTimeZone);
	</script>
@endpush
