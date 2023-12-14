@extends('admin.layouts.master')
@section('page_title', __('Google Login Control'))

@section('content')
	<div class="main-content">
		<section class="section">
			<div class="section-header">
				<h1>@lang('Google Login Control')</h1>
				<div class="section-header-breadcrumb">
					<div class="breadcrumb-item active">
						<a href="{{ route('settings') }}">@lang('Settings')</a>
					</div>
					<div class="breadcrumb-item active">
						<a href="{{ route('social.login.config') }}">@lang('Social Login')</a>
					</div>

					<div class="breadcrumb-item">@lang('Google Login Control')</div>
				</div>
			</div>

			<div class="section-body">
				<div class="row mt-sm-4">
					<div class="col-12 col-md-4 col-lg-3">
						@include('admin.control_panel.components.sidebar', ['settings' => config('generalsettings.social-login'), 'suffix' => ''])
					</div>
					<div class="col-12 col-md-8 col-lg-9">
						<div class="container-fluid" id="container-wrapper">
							<div class="row justify-content-md-center">
								<div class="col-lg-12">
									<div class="card mb-4 card-primary shadow">
										<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
											<h6 class="m-0 font-weight-bold text-primary">@lang('Instructions')</h6>

											<a href="https://www.youtube.com/watch?v=MQszEDuWFeQ" target="_blank" class="btn btn-primary btn-sm  " type="button">
												<span class="btn-label"><i class="fab fa-youtube"></i></span>
												@lang('How to set up it?')
											</a>
										</div>

										<div class="card-body">
											@lang("To login with a Google account in this system, we need to have a") <a href="https://mail.google.com" target="_blank">@lang('gmail email account')</a> @lang(". This gmail account will help us to create an account with the Google developer console. In the developer console, we can grant access to create the Google Client ID and Client secret.")
											<br><br>
											@lang("Get your free 'Client ID' and 'Client secret' from here")
											<a href="https://console.developers.google.com" target="_blank">@lang('Google Developers Console') <i class="fas fa-external-link-alt"></i></a>
											@lang(", After creating the google account credentials. Now you have to put the 'Client ID' and 'Client secret' below with your original google cloud dev credentials.")
											<a href="{{asset($themeTrue.'images/loginWithGoogle.png')}}" target="_blank">@lang('Click here')</a>@lang(' to see demo image.')
										</div>
									</div>
								</div>

								<div class="col-lg-12">
									<div class="card mb-4 card-primary shadow">
										<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
											<h6 class="m-0 font-weight-bold text-primary">@lang('Google Login Control')</h6>
										</div>
										<div class="card-body">
											<div class="row justify-content-center">
												<div class="col-md-10">
													<form action="{{ route('google.login.control') }}" method="post">
														@csrf
														<div class="row">
															<div class="col-md-12">
																<div class="form-group">
																	<label for="GOOGLE_CLIENT_ID">@lang('Client Id')</label>
																	<input type="text" name="GOOGLE_CLIENT_ID" value="{{ old('client_id',env('GOOGLE_CLIENT_ID')) }}" placeholder="@lang('Client Id')"
																		class="form-control @error('GOOGLE_CLIENT_ID') is-invalid @enderror">
																	<div class="invalid-feedback">@error('GOOGLE_CLIENT_ID') @lang($message) @enderror</div>
																</div>
															</div>
															<div class="col-md-12">
																<div class="form-group">
																	<label for="GOOGLE_CLIENT_SECRET">@lang('Client Secret')</label>
																	<input type="text" name="GOOGLE_CLIENT_SECRET" value="{{ old('GOOGLE_CLIENT_SECRET',env('GOOGLE_CLIENT_SECRET')) }}" placeholder="@lang('Client Secret')"
																		class="form-control @error('GOOGLE_CLIENT_SECRET') is-invalid @enderror">
																	<div class="invalid-feedback">@error('GOOGLE_CLIENT_SECRET') @lang($message) @enderror</div>
																</div>
															</div>

															<div class="col-md-6">
																<div class="form-group">
																	<label>@lang('Login Status')</label>
																	<div class="selectgroup w-100">
																		<label class="selectgroup-item">
																			<input type="radio" name="google_status_login" value="0"
																				class="selectgroup-input" {{ old('google_status_login', $basicControl->google_status_login) == 0 ? 'checked' : ''}}>
																			<span class="selectgroup-button">@lang('OFF')</span>
																		</label>
																		<label class="selectgroup-item">
																			<input type="radio" name="google_status_login" value="1"
																				class="selectgroup-input" {{ old('google_status_login', $basicControl->google_status_login) == 1 ? 'checked' : ''}}>
																			<span class="selectgroup-button">@lang('ON')</span>
																		</label>
																	</div>
																	@error('google_status_login')
																		<span class="text-danger" role="alert">
																			<strong>{{ __($message) }}</strong>
																		</span>
																	@enderror
																</div>
															</div>
															<div class="col-md-6">
																<div class="form-group">
																	<label>@lang('Registration Status')</label>
																	<div class="selectgroup w-100">
																		<label class="selectgroup-item">
																			<input type="radio" name="google_status_registration" value="0"
																				class="selectgroup-input" {{ old('google_status_registration', $basicControl->google_status_registration) == 0 ? 'checked' : ''}}>
																			<span class="selectgroup-button">@lang('OFF')</span>
																		</label>
																		<label class="selectgroup-item">
																			<input type="radio" name="google_status_registration" value="1"
																				class="selectgroup-input" {{ old('google_status_registration', $basicControl->google_status_registration) == 1 ? 'checked' : ''}}>
																			<span class="selectgroup-button">@lang('ON')</span>
																		</label>
																	</div>
																	@error('google_status_registration')
																		<span class="text-danger" role="alert">
																			<strong>{{ __($message) }}</strong>
																		</span>
																	@enderror
																</div>
															</div>
														</div>
														<div class="form-group">
															<button type="submit" name="submit" class="btn btn-primary btn-sm btn-block">@lang('Save changes')</button>
														</div>
													</form>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

		</section>
	</div>
@endsection
