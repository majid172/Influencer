@extends($theme.'layouts.user')
@section('title', __("Ticket# "). __($ticket->ticket))

@section('content')
	<div class="col-xl-9 col-lg-8 col-md-12">
		<h4>{{__("Ticket# "). __($ticket->ticket)}}</h4>
		<div class="message-wrapper">
			<div class="row g-lg-0">
				<div class="col-lg-12">
					<div class="inbox-wrapper">
						<!-- top bar -->
						<div class="top-bar">
							<div class="d-flex align-items-center">
								<h5 class="mb-0">
									@if($ticket->status == 0)
										<span class="badge bg-success">@lang('Open')</span>
									@elseif($ticket->status == 1)
										<span class="badge bg-primary">@lang('Answered')</span>
									@elseif($ticket->status == 2)
										<span class="badge bg-warning">@lang('Replied')</span>
									@elseif($ticket->status == 3)
										<span class="badge bg-secondary">@lang('Closed')</span>
									@endif

									[{{trans('Ticket#'). $ticket->ticket }}] {{ $ticket->subject }}
								</h5>
							</div>
							<div>
								<button class="info-btn text-white" id="infoBtn"
									data-bs-toggle="modal"
									data-bs-target="#closeTicketModal">
									<i class="fa-sharp fa-regular fa-circle-xmark text-white"></i> {{trans('Close')}}
								</button>
							</div>
						</div>


						<!-- chats -->
						@if(count($ticket->messages) > 0)
							<div class="chats">
								@foreach($ticket->messages as $item)
									@if($item->admin_id == null)
										<div class="chat-box this-side">
											<div class="text-wrapper">
												<p class="name">@lang(optional($ticket->user)->username)</p>
												<div class="text">
													<p>{{$item->message}}</p>
												</div>
												<div class="file">
													@if(0 < count($item->attachments))
														@foreach($item->attachments as $k=> $image)
															<a href="{{route('user.ticket.download',encrypt($image->id))}}" class="attachment me-2">
																<i class="fal fa-file"></i> <span>@lang('File') {{++$k}}</span>
															</a>
														@endforeach
													@endif
												</div>
												<span class="time">{{dateTime($item->created_at, 'd M, y h:i A')}}</span>
											</div>
											<div class="img">
												<img class="img-fluid" src="{{getFile(optional(optional($ticket->user)->profile)->driver,optional(optional($ticket->user)->profile)->profile_picture)}}" alt="@lang('user image')" />
											</div>
										</div>
									@else
										<div class="chat-box opposite-side">
											<div class="img">
												<img class="img-fluid" src="{{ getFile(optional($item->admin->profile)->driver,optional($item->admin->profile)->profile_picture)}}" alt="@lang('admin image')" />
											</div>
											<div class="text-wrapper">
												<p class="name">@lang(optional($item->admin)->name)</p>
												<div class="text">
													<p>{{$item->message}}</p>
												</div>
												<div class="file">
													@if(0 < count($item->attachments))
														@foreach($item->attachments as $k=> $image)
															<a href="{{route('user.ticket.download',encrypt($image->id))}}">
																<i class="fal fa-file"></i> <span>@lang('File') {{++$k}}</span>
															</a>
														@endforeach
													@endif
												</div>
												<span class="time">{{dateTime($item->created_at, 'd M, y h:i A')}}</span>
											</div>
										</div>
									@endif
								@endforeach
							</div>
						@endif


						<!-- typing area -->
						<form action="{{ route('user.ticket.reply', $ticket->id)}}" method="post" enctype="multipart/form-data">
							@csrf
							@method('PUT')
							<div class="typing-area">
								<div class="input-group">
									<div>
										<button class="upload-img send-file-btn">
											<i class="fal fa-paperclip" aria-hidden="true"></i>
											<input
												class="form-control"
												name="attachments[]"
												id="upload"
												type="file"
												multiple
												placeholder="@lang('Upload File')"
												onchange="previewImage('attachment')"
											/>
										</button>
									</div>
									<textarea name="message" cols="30" rows="10" class="form-control" placeholder="@lang('Type Here...')">{{old('message')}}</textarea>
									<button class="submit-btn text-white" type="submit" name="replayTicket" value="1">
										<i class="fal fa-paper-plane" aria-hidden="true"></i>
									</button>
								</div>
								@error('message')
									<span class="text-danger">{{trans($message)}}</span>
								@enderror
								<p class="name text-danger select-files-count mt-1 mb-0"></p>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>


    <div class="modal fade" id="closeTicketModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" action="{{ route('user.ticket.reply', $ticket->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title text-danger"> @lang('Confirmation !')</h5>
						<button type="button" class="close-btn" data-bs-dismiss="modal" aria-label="Close">
							<i class="fal fa-times"></i>
						</button>
                    </div>
                    <div class="modal-body">
                        <p>@lang('Are you want to close ticket')?</p>
                    </div>
                    <div class="modal-footer">
						<button type="button" class="btn btn-danger" data-bs-dismiss="modal">@lang('Close')</button>
                  		<button type="submit" class="btn-custom" name="replayTicket" value="2">@lang("Confirm")</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection



@section('scripts')
    <script>
        'use strict';
        $(document).ready(function () {
            $(document).on('change', '#upload', function () {
                let fileCount = $(this)[0].files.length;
                $('.select-files-count').text(fileCount + ' file(s) selected')
            });
        });
    </script>

	@if ($errors->any())
		@php
			$collection = collect($errors->all());
			$errors = $collection->unique();
		@endphp
		<script>
			"use strict";
			@foreach ($errors as $error)
				Notiflix.Notify.Failure("{{ trans($error) }}");
			@endforeach
		</script>
	@endif
@endsection


