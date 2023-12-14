@extends($theme.'layouts.user')
@section('title',__('New Ticket'))

@section('content')

<div class="col-lg-8 col-md-6 change-password">
	<h4>@lang('New Ticket')</h4>
	<div class="form-box mt-4">
		<form action="{{route('user.ticket.store')}}" method="post" enctype="multipart/form-data">
			@csrf
			<div class="row g-4">
				<div class="input-box col-md-12">
					<label for="subject">@lang('Subject')</label>
					<input type="text" name="subject" placeholder="@lang('Subject')"
						   value="{{ old('subject') }}"
						   class="form-control @error('subject') is-invalid @enderror">
					<div class="invalid-feedback">
						@error('subject') @lang($message) @enderror
					</div>
					<div class="valid-feedback"></div>
				</div>

				<div class="input-box col-md-12">
					<label for="message">@lang('Message')</label>
					<textarea name="message" rows="5" class="form-control @error('message') is-invalid @enderror" placeholder="@lang('Enter Message')">{{ old('message') }}</textarea>
					<div class="invalid-feedback">
						@error('message') @lang($message) @enderror
					</div>
				</div>
				<div class="input-box col-12">
					<label for="upload">@lang('Choose files')</label>
					<input type="file" id="upload" name="attachments[]" multiple class="form-control">
					<p class="text-danger select-files-count"></p>
					@error('attachments')
						<div class="error text-danger"> @lang($message) </div>
					@enderror
				</div>
				<div class="input-box col-12">
					<button class="btn-custom" type="submit">@lang('Submit Ticket')</button>
				</div>
			</div>
		</form>
	</div>
</div>

@endsection


@section('scripts')
    <script>
        'use strict';
        $(document).ready(function () {
            $(document).on('change', '#upload', function () {
                var fileCount = $(this)[0].files.length;
                $('.select-files-count').text(fileCount + ' file(s) selected');
            });
        });
    </script>
@endsection
