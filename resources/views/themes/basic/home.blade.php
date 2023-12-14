@extends($theme.'layouts.app')
@section('title',trans('Home'))

@section('content')
    @include($theme.'partials.heroBanner')
	@include($theme.'sections.experience')
	@include($theme.'sections.about-us')
    @include($theme.'sections.how-it-work')
    @include($theme.'sections.testimonial')
	@include($theme.'sections.feature')
    @include($theme.'sections.blog')
@endsection
