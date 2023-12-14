@extends($theme.'layouts.app')
@section('title',__('Reset Password'))

@section('content')
	<section class="login-section recover-password">
		<div class="container">
			<div class="row justify-content-center align-items-end">
				<div class="col-lg-5">
					<div class="form-wrapper">
						<div class="form-box">
							@if (session('status'))
								<div class="alert alert-success alert-dismissible fade show w-100" role="alert">
									{{ __(session('status')) }}
									<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
								</div>
							@endif
							<form action="{{ route('password.update') }}" method="post">
								@csrf
								<div class="row g-4">
									<div class="col-12">
										<h4>@lang('Reset Password')</h4>
									</div>
									<input type="hidden" name="token" value="{{ $token }}">
									<input type="hidden" name="email" value="{{ $email ?? old('email') }}">

									<div class="input-box col-12">
										<input type="password" name="password"
										   class="form-control" @error('username') is-invalid @enderror @error('email') is-invalid @enderror
										   placeholder="@lang('New Password')"/>
										<div class="text-danger">
											@error('password') @lang($message) @enderror
										</div>
									</div>

									<div class="input-box col-12">
										<input type="password" name="password_confirmation" class="form-control" id="password_confirmation"
											   placeholder="@lang('Confirm New Password')"/>
										<div class="text-danger">
											@error('password_confirmation') @lang($message) @enderror
										</div>
									</div>

									<div class="input-box col-12">
										<button type="submit" class="btn-custom w-100">@lang('Reset Password')</button>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
@endsection


