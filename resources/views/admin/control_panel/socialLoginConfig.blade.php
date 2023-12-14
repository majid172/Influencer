@extends('admin.layouts.master')
@section('page_title', __('Social Login Configuration'))

@section('content')
<div class="main-content">
	<section class="section">
		<div class="section-header">
			<h1>@lang('Social Login Configuration')</h1>
			<div class="section-header-breadcrumb">
				<div class="breadcrumb-item active">
					<a href="{{ route('settings') }}">@lang('Settings')</a>
				</div>
				<div class="breadcrumb-item">@lang('Social Login Configuration')</div>
			</div>
		</div>

		<div class="section-body">
			<div class="row mt-sm-4">
				<div class="col-12 col-md-4 col-lg-3">
					@include('admin.control_panel.components.sidebar', ['settings' => config('generalsettings.settings'), 'suffix' => 'Settings'])
				</div>
				<div class="col-12 col-md-8 col-lg-9">
					<div class="container-fluid" id="container-wrapper">
						<div class="row justify-content-md-center">
							<div class="col-lg-12">
								<div class="card mb-4 card-primary shadow">
									<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
										<h6 class="m-0 font-weight-bold text-primary">@lang('Social Login Configuration')</h6>
									</div>
									<div class="card-body py-5">
										<div class="row justify-content-md-center">
											<div class="col-lg-10">
												<div class="card mb-4 shadow">
													<div class="card-body">
														<div class="row justify-content-between align-items-center">
															<div class="col-md-3"><img src="{{ asset('assets/upload/socialLogin/google.png') }}" class="w-25"></div>
															<div class="col-md-6">@lang('Sign In your account with Google, It\'s easy & simple.')</div>
															<div class="col-md-3"><a href="{{ route('google.login.control') }}" class="btn btn-sm btn-primary" target="_blank">@lang('Configuration')</a></div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="row justify-content-md-center">
											<div class="col-lg-10">
												<div class="card mb-4 shadow">
													<div class="card-body">
														<div class="row justify-content-between align-items-center">
															<div class="col-md-3"><img src="{{ asset('assets/upload/socialLogin/facebook.png') }}" class="w-25"></div>
															<div class="col-md-6">@lang('Sign In your account with Facebook, It\'s easy & simple.')</div>
															<div class="col-md-3"><a href="{{ route('facebook.login.control') }}" class="btn btn-sm btn-primary" target="_blank">@lang('Configuration')</a></div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="row justify-content-md-center">
											<div class="col-lg-10">
												<div class="card mb-4 shadow">
													<div class="card-body">
														<div class="row justify-content-between align-items-center">
															<div class="col-md-3"><img src="{{ asset('assets/upload/socialLogin/github.png') }}" class="w-25"></div>
															<div class="col-md-6">@lang('Sign In your account with GitHub, It\'s easy & simple.')</div>
															<div class="col-md-3"><a href="{{ route('github.login.control') }}" class="btn btn-sm btn-primary" target="_blank">@lang('Configuration')</a></div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="row justify-content-md-center">
											<div class="col-lg-10">
												<div class="card mb-4 shadow">
													<div class="card-body">
														<div class="row justify-content-between align-items-center">
															<div class="col-md-3"><img src="{{ asset('assets/upload/socialLogin/twitter.png') }}" class="w-25"></div>
															<div class="col-md-6">@lang('Sign In your account with Twitter, It\'s easy & simple.')</div>
															<div class="col-md-3"><a href="{{ route('twitter.login.control') }}" class="btn btn-sm btn-primary" target="_blank">@lang('Configuration')</a></div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="row justify-content-md-center">
											<div class="col-lg-10">
												<div class="card mb-4 shadow">
													<div class="card-body">
														<div class="row justify-content-between align-items-center">
															<div class="col-md-3"><img src="{{ asset('assets/upload/socialLogin/linkedin.png') }}" class="w-25"></div>
															<div class="col-md-6">@lang('Sign In your account with LinkedIn, It\'s easy & simple.')</div>
															<div class="col-md-3"><a href="{{ route('linkedin.login.control') }}" class="btn btn-sm btn-primary" target="_blank">@lang('Configuration')</a></div>
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
				</div>
			</div>
		</div>
	</section>
</div>
@endsection

