<!-- navbar -->
<nav class="navbar navbar-expand-lg fixed-top">
	<div class="container">
		<a class="navbar-brand" href="{{route('home')}}">

			<img src="{{ getFile(config('basic.default_file_driver'),config('basic.logo_image')) }}"
				 alt="{{config('basic.site_title')}}">
		</a>
		<button class="navbar-toggler p-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
				aria-controls="navbarNav"
				aria-expanded="false" aria-label="Toggle navigation">
			<i class="far fa-bars"></i>
		</button>
		<div class="collapse navbar-collapse" id="navbarNav">
			<ul class="navbar-nav">
				<li class="nav-item">
					<a class="nav-link {{Request::routeIs('home') ? 'active' : ''}}" href="{{ route('home') }}">
						@lang('Home')
					</a>
				</li>
				<li class="nav-item">
					<a class="nav-link {{Request::routeIs('influencers') ? 'active' : ''}}"
					   href="{{route('influencers')}}">@lang('Influencers')</a>
				</li>
				<li class="nav-item">
					<a class="nav-link {{Request::routeIs('allListings') ? 'active' : ''}}"
					   href="{{route('allListings')}}">@lang('Listings')</a>
				</li>
				<li class="nav-item">
					<a class="nav-link {{Request::routeIs('jobs') ? 'active' : ''}}"
					   href="{{route('jobs')}}">@lang('Jobs')</a>
				</li>
				<li class="nav-item">
					<a class="nav-link {{Request::routeIs('blog') ? 'active' : ''}}"
					   href="{{route('blog')}}">@lang('Blog')</a>
				</li>
				<li class="nav-item">
					<a class="nav-link {{Request::routeIs('contact') ? 'active' : ''}}"
					   href="{{route('contact')}}">@lang('Contact')</a>
				</li>
			</ul>
		</div>


		<!-- navbar text -->
		<div class="navbar-text">
			<!-- user panel -->
			<!-- inbox/message -->
			@if(!request()->routeIs('user.message'))
				<div class="notification-panel inbox" id="messageArea" v-cloak>
					<button class="dropdown-toggle">
					<i class="fal fa-comment-alt-lines"></i>
					<span class="count">@{{ messages.length }}</span>
					</button>
					<ul class="notification-dropdown">
					<div class="dropdown-box">
						<div class="messages-box">
							<div class="message active" v-for="(message, index) in messages">

								<div class="img-box">
								<img :src="message.sender_image" class="img-fluid" alt="..."/>
								</div>
								<div class="text-box">
								<a href="javascript:void(0)" @click.prevent="readAt(message.id)">
									<p class="name" v-cloak>
										@{{ message.name }}
										<span class="time" v-cloak>@{{ message.time }}</span>
									</p>
									<p v-cloak>@{{ message.message }}</p>
								</a>
								</div>
							</div>
						</div>
					</div>
					<div class="clear-all fixed-bottom">
						 <a href="javascript:void(0)" v-if="messages.length == 0">@lang('You have no messages')</a>
						<a href="javascript:void(0)" v-if="messages.length > 0"
						   @click.prevent="readAll">@lang('Clear All')</a>
					</div>
					</ul>
				</div>
			@endif
			<!-- notification panel -->
			@include($theme.'partials.pushNotify')

			<div class="user-panel">
				<div class="profile">

 					{!! auth()->user()->profilePicture() !!}

				</div>
				<ul class="user-dropdown">

					<li>
						<a href="{{route('user.dashboard')}}"> <i class="fa-light fa-house"></i>@lang('Dashboard')</a>
					</li>

					<li>
						<a href="{{route('user.profile')}}"> <i class="fal fa-user-cog"></i> @lang('Account Settings') </a>
					</li>

					<li>
						<a href="{{route('user.message')}}"> <i class="fal fa-comments-alt"></i> @lang('Messages') </a>
					</li>



					<li>
						<a href="{{route('user.twostep.security')}}" class="{{menuActive('user.twostep.security')}}">
							<i class="fal fa-user-lock"></i>@lang('2 FA Security')
						</a>
					</li>


					<li>
						<a href="{{route('user.list.setting.notify')}}">
							<i class="fa-light fa-bullhorn"></i>@lang('Push Notify Setting')
						</a>
					</li>

					<li>
						<a href="{{ route('logout') }}"
						   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
							<i class="fal fa-sign-out-alt"></i>@lang('Sign Out')
						</a>
						<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
							@csrf
						</form>
					</li>
				</ul>
			</div>
		</div>
	</div>
</nav>


<!-- Start Logout Modal -->
<div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title text-danger pb-2" id="logoutModalLabel">@lang('Confirmation !')</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body logout-body">
				@lang('Are you sure you want to logout?')
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger" data-dismiss="modal">@lang('Cancel')</button>
				<a href="{{ route('logout') }}" type="button" class="btn btn-primary" onclick="event.preventDefault();
			document.getElementById('logout-form').submit();">@lang('Logout')</a>

				<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
					@csrf
				</form>
			</div>
		</div>
	</div>
</div>
<!-- End Logout Modal -->
