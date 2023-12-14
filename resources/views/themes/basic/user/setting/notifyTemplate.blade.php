@extends($theme.'layouts.user')
@section('page_title',__('Notification List'))

@section('content')
	<div class="col-xl-9 col-lg-8 col-md-12">
		<h4>@lang('Push Notification List')</h4>
		<div class="row g-4">
			<div class="col-12">
				<div class="card-box notification-list">
					<ul class="list-unstyled">
						<form role="form" method="POST" action="{{route('user.update.setting.notify')}}"
						enctype="multipart/form-data">
							@csrf
							@method('put')
							@forelse($templates as $key => $item)
								<li>
									<label class="form-check-label" for={{$key.'pushNotification'}}> @lang($item->name)</label>
									<div class="form-check form-switch">
										<input class="form-check-input"
											name="access[]"
											value="{{$item->template_key}}"
											type="checkbox"
											role="switch"
											id={{$key.'pushNotification'}}
											@if(in_array($item->template_key, auth()->user()->notify_active_template??[])) checked
											@endif
										/>
									</div>
								</li>
							@empty
								<li>@lang('No Data Found')</li>
							@endforelse
								<button type="submit" class="btn btn-primary btn-sm btn-block">@lang('Save Changes')</button>
						</form>
					</ul>
				</div>
			</div>
		</div>
	</div>
@endsection

