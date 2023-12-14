<div class="card-box skills mt-4">
	<div class="d-flex">
		<h4>@lang('Language')</h4>
		<button class="btn-action-icon bg-primary mx-2 mb-3" data-bs-toggle="modal" data-bs-target="#languageModal">
			<i class="fal fa-plus"></i>
		</button>
	</div>
	<div class="d-flex">
		<p>@lang('Mother Tongue') : {{__($userProfile->mother_tongue)}}</p>

	</div>

	<div class="d-flex">
		<p>@lang('Known Language') </p>

	</div>
	@forelse (explode(',',$userProfile->known_languages) as $key=>$known_language)
		<span><li>{{__($known_language)}} </li> </span>
	@empty

	@endforelse

</div>



<div class="modal fade" id="languageModal" tabindex="-1" aria-labelledby="languageModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="languageModalLabel">@lang('Languages')</h5>
				<button type="button" class="close-btn" data-bs-dismiss="modal" aria-label="Close">
					<i class="fal fa-times"></i>
				</button>
			</div>
			<div class="modal-body">
				<div class="form-box mt-4">
					<form action="{{ route('user.language.info') }}" method="post" enctype="multipart/form-data">
						@csrf
						<div class="row g-4">
							<div class="input-box col-md-12">
								<label for="mother_tongue">@lang('Mother Tongue')</label>
								<select class="js-example-basic-multiple-limit form-control" name="mother_tongue" aria-label="Default select example">
									<option value="" selected disabled>@lang('Select One')</option>
									@foreach(config('languages')['langCodeWithoutFlag'] as $key => $item)
										<option value="{{$item}}" @if($item == old('mother_tongue',$userProfile->mother_tongue)) selected @endif>{{$item}}</option>
									@endforeach
								</select>
								@error('mother_tongue')
								<span class="text-danger">@lang($message)</span>
								@enderror
							</div>
							<div class="input-box col-md-12">
								<label for="known_languages">@lang('Known Languages')</label>
								<select type="text" class="js-example-basic-multiple-limit form-control" name="known_languages[]"
										placeholder="@lang('Enter Your Known Languages')" id="known_languages" multiple
										data-live-search="true">

									@foreach(config('languages')['langCodeWithoutFlag'] as $key => $item)
										<option value="{{$item}}"
												@if(is_array($array_of_knownLanguage))
													@if((in_array($item,$array_of_knownLanguage)))
														selected
											@endif
											@endif>{{$item}}
										</option>
									@endforeach
								</select>
								@error('known_languages')
								<span class="text-danger">@lang($message)</span>
								@enderror
							</div>

							<div class="input-box col-12">
								<button type="submit" class="btn-custom">@lang('Update')</button>
							</div>
						</div>
					</form>
				</div>
			</div>

		</div>
	</div>
</div>


@push('script')
	@if($errors->has('mother_tongue') || $errors->has('known_languages'))
		<script defer>
			var myModal = new bootstrap.Modal(document.getElementById("designationModal"), {});
			document.onreadystatechange = function () {
				myModal.show();
			};
		</script>
	@endif
@endpush
