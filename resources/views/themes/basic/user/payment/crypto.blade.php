@extends($theme.'layouts.user')
@section('title')
	{{ 'Pay with '.optional($deposit->gateway)->name ?? '' }}
@endsection
@section('content')
<div class="col-xl-9">
	<div class="main-content">
		<section class="section">
			<div class="section-header">
				<h1>{{ __('Pay with ').__(optional($deposit->gateway)->name) }}</h1>
				<div class="section-header-breadcrumb">
					<div class="breadcrumb-item active">
						<a href="{{ route('user.dashboard') }}">@lang('Dashboard')</a>
					</div>
					<div class="breadcrumb-item">{{ __('Pay with ').__(optional($deposit->gateway)->name) }}</div>
				</div>
			</div>
			<div class="row justify-content-center">
				<div class="col-md-5">
					<div class="card card-primary shadow">
						<div class="card-header">@lang('Payment Preview')</div>
						<div class="card-body text-center">
							<h4 class="text-color"> @lang('PLEASE SEND EXACTLY') <span class="text-success"> {{ getAmount($data->amount) }}</span> {{ __($data->currency) }}</h4>
							<h5>@lang('TO') <span class="text-success"> {{ __($data->sendto) }}</span></h5>
							<img src="{{ $data->img }}">
							<h4 class="text-color bold">@lang('SCAN TO SEND')</h4>
						</div>
					</div>
				</div>
			</div>
		</section>
	</div>
</div>
@endsection

