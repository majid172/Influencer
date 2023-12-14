<!-- Sidebar -->
<div class="col-xl-3 col-lg-4 col-md-12">
	<div class="d-flex d-lg-none justify-content-end">
		<button class="btn-custom-outline" onclick="toggleUserSideBar('userSidebar')">
			<i class="fa-light fa-bars"></i>
			@lang("Menu")
		</button>
	</div>
	<div class="sidebar-wrapper" id="userSidebar">
		<button class="btn-custom d-lg-none close-btn  " onclick="toggleUserSideBar('userSidebar')">
			<i class="fa-light fa-times"></i>
			@lang("close")
		</button>
		<div class="cover">
			<div class="img">
				<img src="{{auth()->user()->coverPicture()}}" alt="@lang('user cover img')" class="img-fluid"/>
			</div>
		</div>

		<div class="profile">
			<div class="img">

				 {!! auth()->user()->profilePicture() !!}
				<i title="Away" aria-hidden="true" class="online position-absolute fa fa-circle text-success"></i>
			</div>
			<div class="">
				<h5 class="name">
					{{auth()->user()->name}}
					@if(auth()->user()->is_verified == 1)
						<i class="fas fa-check-circle" aria-hidden="true"></i>
					@endif
				</h5>
				<span>@lang('@'){{auth()->user()->username}}</span>
			</div>
		</div>


		<ul class="menu-links">
			<li>
				<a href="{{route('user.dashboard')}}" class="{{menuActive('user.dashboard')}}">
					<i class="fa-light fa-house"></i>@lang('Dashboard')
				</a>
			</li>
			<li>
				<a href="{{route('user.profile')}}" class="{{menuActive('user.profile')}}">
					<i class="fal fa-user-edit"></i>@lang('Profile')
				</a>
			</li>


			@if (auth()->user()->is_influencer == 1)

				<li>
					<a href="{{route('user.myproposal.list')}}" class="{{menuActive('user.myproposal.list')}}">
						<i class="fa-brands fa-creative-commons-nd"></i>@lang('Proposals')
					</a>
				</li>

			@elseif (auth()->user()->is_client == 1)
				<li>
					<a href="{{route('user.jobs.list')}}" class="{{menuActive('user.jobs.list')}}"><i
							class="fal fa-clipboard-list"></i>@lang('Jobs List')</a>
				</li>

				<li>
					<a href="{{route('user.job.send_offer')}}" class="{{menuActive('user.job.send_offer')}}">
						<i class="fa-brands fa-creative-commons-nd"></i>@lang('Send Offers')
					</a>
				</li>
			@endif
			@if(auth()->user()->is_influencer == 1)
			<li>
				<a href="{{route('user.receive.invite')}}" class="{{menuActive('user.receive.invite')}}">
					<i class="fa-brands fa-creative-commons-nd"></i>@lang('Job Invitation')
				</a>
			</li>
			@endif

			@if(auth()->user()->is_client == 1)
				<li>
					<a href="{{route('user.hire.freelancer')}}" class="{{menuActive('user.hire.freelancer')}}">
						<i class="fa-light fa-user-clock"></i>@lang('Hire Freelancer')
					</a>
				</li>

			@elseif(auth()->user()->is_influencer == 1)
				<li>
					<a href="{{route('user.job.order')}}" class="{{menuActive('user.job.order')}}">
						<i class="fal fa-tags"></i>@lang('Job Orders')
					</a>
				</li>

			@endif

			<li>
				<a href="{{route('user.listing.list')}}" class="{{menuActive('user.listing.list')}}"><i
						class="fal fa-clipboard-list"></i>@lang('Listings')</a>
			</li>

			<li>
				<a href="{{route('user.listing.order.list')}}" class="{{menuActive('user.listing.order.list')}}">
					<i class="fal fa-tags"></i>@lang('Listing Orders')
				</a>
			</li>

			@if(auth()->user()->is_client == 1)
				<li>
					<a href="{{route('fund.index')}}" class="{{menuActive('fund.initialize')}}">
						<i class="fa-light fa-wallet"></i>@lang('Fund Lists')
					</a>
				</li>
			@endif

{{--	payout request		--}}
			<li>
				<a href="{{route('payout.request')}}" class="{{menuActive('payout.request')}}">
					<i class="fal fa-hand-holding-usd"></i>@lang('Payout Request')
				</a>
			</li>
			<li>
				<a href="{{route('payout.index')}}" class="{{menuActive('payout.index')}}">
					<i class="fal fa-file-spreadsheet"></i>@lang('Payout List')
				</a>
			</li>
{{--	end payout		--}}

			<li>
				<a href="{{route('user.transaction')}}" class="{{menuActive('user.transaction')}}">
					<i class="fal fa-file-spreadsheet"></i>@lang('Transactions')
				</a>
			</li>

			<li>
				<a href="{{route('user.message')}}"><i class="fal fa-comments-alt"></i>@lang('Messages')</a>
			</li>

			<li>
				<a href="{{route('user.ticket.list')}}"
				   class="{{menuActive(['user.ticket.list', 'user.ticket.create', 'user.ticket.view*'])}}">
					<i class="fa-light fa-ticket"></i>@lang('Support Ticket')
				</a>
			</li>

			<li>
				<a href="{{route('user.report')}}"><i class="fal fa-chart-pie"></i>@lang('Reports')</a>
			</li>

		</ul>
	</div>
</div>

