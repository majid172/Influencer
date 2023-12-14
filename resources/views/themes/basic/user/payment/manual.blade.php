@extends($theme.'layouts.user')
@section('title')
	{{ 'Pay with '.optional($deposit->gateway)->name ?? '' }}
@endsection

@section('content')
	<div class="col-xl-9 col-lg-8 col-md-12">
		<div class="card-box ">
			<div class="row ">
				<div class="col-md-12">
					<h4 class="title text-center">{{trans('Please follow the instruction below')}}</h4>
					<p class="text-center mt-2 ">{{trans('You have requested to deposit')}} <b
							class="text--base">{{getAmount($deposit->amount)}}
							{{basicControl()->base_currency}}</b> , {{trans('Please pay')}}
						<b class="text--base">{{getAmount($deposit->payable_amount)}} {{$deposit->payment_method_currency}}</b> {{trans('for successful payment')}}
					</p>
					<p class=" mt-2 ">
						<?php echo optional($deposit->gateway)->note; ?>
					</p>

					<div class="form-box">
						<form action="{{route('addFund.fromSubmit',$deposit->utr)}}" method="post"
							  enctype="multipart/form-data"
							  class="form-row  preview-form">
							@csrf
							@if(optional($deposit->gateway)->parameters)
								@foreach($deposit->gateway->parameters as $k => $v)
									@if($v->type == "text")
										<div class="col-md-12 mt-2">
											<div class="input-box  ">
												<label>{{trans($v->field_level)}} @if($v->validation == 'required')
														<span class="text--danger">*</span>
													@endif </label>
												<input type="text" name="{{$k}}"
													   class="form-control bg-transparent"
													   @if($v->validation == "required") required @endif>
												@if ($errors->has($k))
													<span
														class="text--danger">{{ trans($errors->first($k)) }}</span>
												@endif
											</div>
										</div>
									@elseif($v->type == "textarea")
										<div class="col-md-12 mt-2">
											<div class=input-box>
												<label>{{trans($v->field_level)}} @if($v->validation == 'required')
														<span class="text--danger">*</span>
													@endif </label>
												<textarea name="{{$k}}" class="form-control bg-transparent"
														  rows="3"
														  @if($v->validation == "required") required @endif></textarea>
												@if ($errors->has($k))
													<span
														class="text--danger">{{ trans($errors->first($k)) }}</span>
												@endif
											</div>
										</div>
									@elseif($v->type == "file")
										<div class="col-md-12 mt-2">
											<div class="input-box">
												<label>{{trans($v->field_level)}} @if($v->validation == 'required')--}}
													<span class="text--danger">*</span>
													@endif </label>
												<div class="image-input">
													<label for="image-upload" id="image-label">
														<i class="fa-regular fa-upload"></i>
													</label>
													<input type="file" name="{{$k}}" placeholder="@lang('Choose image')" id="profile_image" @if($v->validation == "required") required @endif>
													<img class="w-100 preview-profile_image" id="profile_image_preview_container"
														 src="{{ getFile(config('location.default')) }}"
														 alt="@lang('Upload Image')">
												</div>
												@error('image')
												<span class="text-danger">@lang($message)</span>
												@enderror
											</div>

										</div>
									@endif
								@endforeach
							@endif
							<div class="col-md-12 ">
								<div class="input-box">
									<button type="submit" class="btn-custom w-100 mt-3">
										<span>@lang('Confirm Now')</span>
									</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>

	@push('css-lib')
		<link rel="stylesheet" href="{{asset($themeTrue.'css/bootstrap-fileinput.css')}}">
	@endpush

	@push('extra-js')
		<script src="{{asset($themeTrue.'js/bootstrap-fileinput.js')}}"></script>
		<script src="{{ asset($themeTrue.'js/image-uploader.js') }}"></script>
		<script>

			$('#profile_image').change(function () {
				let reader = new FileReader();
				reader.onload = (e) => {
					$('#profile_image_preview_container').attr('src', e.target.result);
				}
				reader.readAsDataURL(this.files[0]);
			});
		</script>
	@endpush
@endsection
