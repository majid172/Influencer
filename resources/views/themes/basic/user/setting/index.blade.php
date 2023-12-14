@extends($theme.'layouts.user')
@section('page_title',__('Settings'))

@section('content')
	<div class="main-content">
		<section class="section">
			<div class="section-header">
				<h1>@lang('Settings')</h1>
				<div class="section-header-breadcrumb">
					<div class="breadcrumb-item active">
						<a href="{{ route('user.dashboard') }}">@lang('Dashboard')</a>
					</div>
					<div class="breadcrumb-item">@lang('Settings')</div>
				</div>
			</div>
			<div class="row mb-3">
				<div class="container-fluid" id="container-wrapper">
					<div class="row justify-content-md-center">
						<div class="col-md-6">
							<div class="card mb-4 card-primary shadow">
								<div
									class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
									<h6 class="m-0 font-weight-bold text-primary">@lang('Settings')</h6>
								</div>
								<div class="card-body">
									<form action="{{ route('user.setting') }}" method="post"
										  enctype="multipart/form-data">
										@csrf
										<div class="row">
											@if(basicControl()->store == 1)
												<div class="col-md-6">
													<div class="form-group">
														<label for="Store Currency">@lang('Store Currency')</label>
														<select name="currency"
																class="form-control form-control-sm @error('currency') is-invalid @enderror"
																id="currency" required>
															<option disabled selected>@lang('Select Currency')</option>
															@forelse($currencies as $currency)
																<option
																	value="{{$currency->id}}"
																	{{\Illuminate\Support\Facades\Auth::user()->store_currency_id == $currency->id ? 'selected':''}} data-code="{{$currency->code}}">{{$currency->code}}
																	- {{$currency->name}}</option>
															@empty
															@endforelse
														</select>
														<div class="invalid-feedback">
															@error('currency') @lang($message) @enderror
														</div>
													</div>
												</div>
											@endif
											@if(basicControl()->qr_payment == 1)
												<div class="col-md-6">
													<div class="form-group">
														<label for="QR Code Currency">@lang('QR Code Currency')</label>
														<select name="qr_currency_id"
																class="form-control form-control-sm @error('qr_currency_id') is-invalid @enderror"
																id="currency" required>
															<option disabled selected>@lang('Select Currency')</option>
															@forelse($currencies as $currency)
																<option
																	value="{{$currency->id}}"
																	{{\Illuminate\Support\Facades\Auth::user()->qr_currency_id == $currency->id ? 'selected':''}} data-code="{{$currency->code}}">{{$currency->code}}
																	- {{$currency->name}}</option>
															@empty
															@endforelse
														</select>
														<div class="invalid-feedback">
															@error('qr_currency_id') @lang($message) @enderror
														</div>
													</div>
												</div>
											@endif
										</div>
										<button type="submit"
												class="btn btn-primary btn-sm btn-block">@lang('Update')</button>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
	</div>
@endsection

