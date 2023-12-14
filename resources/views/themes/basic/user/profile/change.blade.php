@extends($theme.'layouts.user')
@section('title',__('Change Password'))

@section('content')
	<div class="col-xl-9 col-lg-8 col-md-6 change-password">
		<h4>@lang('Change Password')</h4>
		<div class="form-wrapper">
			<div class="form-box">
				<form action="{{ route('user.change.password') }}" method="post">
					@csrf
					<div class="row g-4">
						<div class="input-box col-12">
							<label for="currentPassword">@lang('Current password')</label>
							<input type="password" name="currentPassword" value="{{ old('currentPassword') }}"
								placeholder="@lang('Enter your current password')"
								class="form-control @error('currentPassword') is-invalid @enderror">
							<div class="invalid-feedback">@error('currentPassword') @lang($message) @enderror</div>
						</div>
						<div class="input-box col-12">
							<label for="password">@lang('New Password')</label>
							<input type="password" name="password" value="{{ old('password') }}"
								placeholder="@lang('Enter new password')"
								class="form-control @error('password') is-invalid @enderror">
							<div class="invalid-feedback">@error('password') @lang($message) @enderror</div>
						</div>
						<div class="input-box col-12">
							<label for="password_confirmation">@lang('Repeat New Password')</label>
							<input type="password" name="password_confirmation" value="{{ old('password_confirmation') }}"
								placeholder="@lang('Repeat new password')"
								class="form-control @error('password_confirmation') is-invalid @enderror">
							<div class="invalid-feedback">@error('password_confirmation') @lang($message) @enderror</div>
						</div>
						<div class="input-box col-12">
							<button type="submit" class="btn-custom">@lang('Submit')</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
@endsection
