@extends('admin.layouts.master')
@section('page_title', __('LinkedIn Login Control'))

@section('content')
	<div class="main-content">
		<section class="section">
			<div class="section-header">
				<h1>@lang('LinkedIn Login Control')</h1>
				<div class="section-header-breadcrumb">
					<div class="breadcrumb-item active">
						<a href="{{ route('settings') }}">@lang('Settings')</a>
					</div>
					<div class="breadcrumb-item active">
						<a href="{{ route('social.login.config') }}">@lang('Social Login')</a>
					</div>

					<div class="breadcrumb-item">@lang('LinkedIn Login Control')</div>
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
											@lang("To login with a LinkedIn account in this system, we need to have a") <a href="https://linkedin.com/" target="_blank">@lang('LinkedIn account')</a> @lang(". This LinkedIn account will help us to create an account with the LinkedIn developers account. In the developer console, we can grant access to create the LinkedIn Client ID and Client secret.")
											<br><br>
											@lang("Get your free 'Client ID' and 'Client secrets' from here")
											<a href="https://developer.linkedin.com/" target="_blank">@lang('LinkedIn Developers Account') <i class="fas fa-external-link-alt"></i></a>
											@lang(", After creating the LinkedIn account credentials. Now you have to put the 'Client ID' and 'Client secrets' below with your original LinkedIn cloud dev credentials.")
										</div>
									</div>
								</div>

								<div class="col-lg-12">
									<div class="card mb-4 card-primary shadow">
										<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
											<h6 class="m-0 font-weight-bold text-primary">@lang('LinkedIn Login Control')</h6>
										</div>
										<div class="card-body">
											<div class="row justify-content-center">
												<div class="col-md-10">
													<form action="{{ route('linkedin.login.control') }}" method="post">
														@csrf
														<div class="row">
															<div class="col-md-12">
																<div class="form-group">
																	<label for="LINKEDIN_CLIENT_ID">@lang('Client Id')</label>
																	<input type="text" name="LINKEDIN_CLIENT_ID" value="{{ old('LINKEDIN_CLIENT_ID',env('LINKEDIN_CLIENT_ID')) }}" placeholder="@lang('Client Id')"
																		class="form-control @error('LINKEDIN_CLIENT_ID') is-invalid @enderror">
																	<div class="invalid-feedback">@error('LINKEDIN_CLIENT_ID') @lang($message) @enderror</div>
																</div>
															</div>
															<div class="col-md-12">
																<div class="form-group">
																	<label for="LINKEDIN_CLIENT_SECRET">@lang('Client Secret')</label>
																	<input type="text" name="LINKEDIN_CLIENT_SECRET" value="{{ old('LINKEDIN_CLIENT_SECRET',env('LINKEDIN_CLIENT_SECRET')) }}" placeholder="@lang('Client Secret')"
																		class="form-control @error('LINKEDIN_CLIENT_SECRET') is-invalid @enderror">
																	<div class="invalid-feedback">@error('LINKEDIN_CLIENT_SECRET') @lang($message) @enderror</div>
																</div>
															</div>

															<div class="col-md-6">
																<div class="form-group">
																	<label>@lang('Login Status')</label>
																	<div class="selectgroup w-100">
																		<label class="selectgroup-item">
																			<input type="radio" name="linkedin_status_login" value="0"
																				class="selectgroup-input" {{ old('linkedin_status_login', $basicControl->linkedin_status_login) == 0 ? 'checked' : ''}}>
																			<span class="selectgroup-button">@lang('OFF')</span>
																		</label>
																		<label class="selectgroup-item">
																			<input type="radio" name="linkedin_status_login" value="1"
																				class="selectgroup-input" {{ old('linkedin_status_login', $basicControl->linkedin_status_login) == 1 ? 'checked' : ''}}>
																			<span class="selectgroup-button">@lang('ON')</span>
																		</label>
																	</div>
																	@error('linkedin_status_login')
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
																			<input type="radio" name="linkedin_status_registration" value="0"
																				class="selectgroup-input" {{ old('linkedin_status_registration', $basicControl->linkedin_status_registration) == 0 ? 'checked' : ''}}>
																			<span class="selectgroup-button">@lang('OFF')</span>
																		</label>
																		<label class="selectgroup-item">
																			<input type="radio" name="linkedin_status_registration" value="1"
																				class="selectgroup-input" {{ old('linkedin_status_registration', $basicControl->linkedin_status_registration) == 1 ? 'checked' : ''}}>
																			<span class="selectgroup-button">@lang('ON')</span>
																		</label>
																	</div>
																	@error('linkedin_status_registration')
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
