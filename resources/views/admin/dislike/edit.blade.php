@extends('admin.layouts.master')

@section('title')
	@lang('Edit Dislike Reason')
@endsection

@section('content')
	<div class="main-content">
		<section class="section">
			<div class="section-header">
				<h1>@lang("Dislike reason ")</h1>
				<div class="section-header-breadcrumb">
					<div class="breadcrumb-item active"><a href="{{ route('admin.home') }}">@lang("Dashboard")</a></div>
					<div class="breadcrumb-item"><a href="{{route('admin.jobs.dislike.reason')}}">@lang("Dislike List")</a></div>
					<div class="breadcrumb-item">@lang("Edit reason")</div>
				</div>
			</div>
			<div class="card mb-4 card-primary shadow-sm">
				<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
					<h5>@lang("Edit Skill")</h5>
				</div>
				<div class="card-body">
					<div class="media mb-4 justify-content-end">
						<a href="{{route('admin.jobs.dislike.reason')}}" class="btn btn-sm  btn-primary mr-2">
							<span><i class="fas fa-arrow-left"></i> @lang('Back')</span>
						</a>
					</div>

					<div class="tab-content mt-2" id="myTabContent">
						<form method="post" action="{{route('admin.jobs.dislike.update',$reason->id)}}" class="mt-4" enctype="multipart/form-data">
								@csrf

								<div class="row">
									<div class="col-sm-12 col-md-6 mb-3">
										<label for="name">@lang('Reason')</label> <span class="text-danger">*</span>
										<input type="text" name="reason" class="form-control" value="{{__($reason->reasons)}}" placeholder="@lang('Enter reason ')">
									</div>

									<div class="col-sm-12 col-md-6 mb-3">
										<div class="form-group">
											<label>@lang('Status')</label>
											<div class="selectgroup w-100">
												<label class="selectgroup-item">
													<input type="radio" name="status" value="1"
														class="selectgroup-input" {{ ($reason->status == 1) ? 'checked' : ''}}>
													<span class="selectgroup-button">@lang('ON')</span>
												</label>
												<label class="selectgroup-item">
													<input type="radio" name="status" value="0" class="selectgroup-input" {{ ($reason->status == 0 )? 'checked' : ''}}>
													<span class="selectgroup-button">@lang('OFF')</span>
												</label>
											</div>
											@error('status')
												<span class="text-danger" role="alert">
													<strong>{{ __($message) }}</strong>
												</span>
											@enderror
										</div>
									</div>
								</div>

								<button type="submit" class="btn waves-effect waves-light btn-rounded btn-primary btn-block mt-3">
									@lang('Save')
								</button>
							</form>
					</div>
				</div>
			</div>
		</section>
	</div>

@endsection

@section('javascripts')

	@if ($errors->any())
		@php
			$collection = collect($errors->all());
			$errors = $collection->unique();
		@endphp
		<script>
			"use strict";
			@foreach ($errors as $error)
			Notiflix.Notify.Failure("{{trans($error)}}");
			@endforeach
		</script>
	@endif
@endsection
