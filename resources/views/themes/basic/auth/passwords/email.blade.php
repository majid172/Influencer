@extends($theme.'layouts.app')
@section('title',__('Recover Password'))

@section('content')
	<!-- Account -->
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
							<form action="{{ route('password.email') }}" method="post">
								@csrf
								<div class="row g-4">
									<div class="col-12">
										<h4>@lang('Recover Password')</h4>
									</div>
									<div class="input-box col-12">
										<input type="email" name="email" class="form-control" placeholder="@lang('Email address')"/>
										<div class="text-danger">
											@error('email') @lang($message) @enderror
										</div>
									</div>

									<div class="input-box col-12">
										<button type="submit" class="btn-custom w-100">@lang('Send Link')</button>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- Account -->
@endsection

