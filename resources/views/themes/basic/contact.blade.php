@extends($theme.'layouts.app')
@section('title',trans($title))

@section('content')
    <!-- CONTACT -->
	@if(isset($contact) && $contactUs = $contact)
		<div class="contact-section">
			<div class="container">
				<div class="row g-4">
					<div class="col-lg-5">
						<div class="form-box">
							<form action="{{route('contact.send')}}" method="post">
								@csrf
								<div class="row g-4">
									<div class="input-box col-md-12">
										<input class="form-control" type="text" name="name" value="{{old('name')}}" placeholder="@lang('Full name')"/>
									   @error('name')
											<div class="text-start text-danger">{{$message}}</div>
										@enderror
									</div>
									<div class="input-box col-md-12">
										<input class="form-control" type="email" name="email" value="{{old('email')}}" placeholder="@lang('Email address')"/>
										@error('email')
											<div class="text-start text-danger">{{$message}}</div>
										@enderror
									</div>
									<div class="input-box col-md-12">
										<input class="form-control" type="text" name="subject" value="{{old('subject')}}" placeholder="@lang('Subject')"/>
										@error('subject')
											<div class="text-start text-danger">{{$message}}</div>
										@enderror
									</div>
									<div class="input-box col-md-12">
										<textarea class="form-control" cols="30" rows="3" name="message" placeholder="@lang('Your message')">{{old('message')}}</textarea>
										@error('message')
											<div class="text-start text-danger">{{$message}}</div>
										@enderror
									</div>
									<div class="input-box col-12">
										<button class="btn-custom" type="submit">@lang('submit')</button>
									</div>
								</div>
							</form>
						</div>
					</div>

					<div class="col-lg-1"></div>

					<div class="col-lg-6">
						<div class="header-text">
							<h5>@lang($contact->title)</h5>
							<h3>@lang($contact->sub_title)</h3>
							<p>{!! __($contact->short_description) !!}</p>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="info-box">
									<div class="icon"><img src="{{asset($themeTrue.'images/email.png')}}" alt="@lang('email img')" /></div>
									<div class="text">
										<h4>@lang('Email')</h4>
										<p>@lang($contact->email)</p>
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="info-box">
									<div class="icon"><img src="{{asset($themeTrue.'images/phone.png')}}" alt="@lang('phone img')" /></div>
									<div class="text">
										<h4>@lang('Phone')</h4>
										<p>@lang($contact->phone)</p>
									</div>
								</div>
							</div>
							<div class="col-md-12">
								<div class="info-box">
									<div class="icon"><img src="{{asset($themeTrue.'images/location.png')}}" alt="@lang('location img')" /></div>
									<div class="text">
										<h4>@lang('Location')</h4>
										<p>@lang($contact->location)</p>
									</div>
								</div>
							</div>
						</div>

						@if(isset($contentDetails['social-links']))
							<div class="social-links">
								<h5 class="">@lang('Follow our social media')</h5>
								<div>
									@foreach($contentDetails['social-links'] as $data)
										<a href="{{optional(optional(optional($data->content)->contentMedia)->description)->social_link}}" target="_blank">
											<i class="{{optional(optional(optional($data->content)->contentMedia)->description)->social_icon}}"></i>
										</a>
									@endforeach
								</div>
							</div>
						@endif

					</div>
				</div>
			</div>
		</div>    <!-- /CONTACT -->
    @endif
@endsection
