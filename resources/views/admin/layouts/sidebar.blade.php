<!-- Sidebar -->
<div class="main-sidebar sidebar-style-2 shadow-sm">
	<aside id="sidebar-wrapper">
		<div class="sidebar-brand">
			<a href="{{ route('home') }}">
				<img src="{{ getFile(config('basic.default_file_driver'),config('basic.admin_logo')) }}"
					 class="dashboard-logo"
					 alt="@lang('Logo')">
			</a>
		</div>
		<div class="sidebar-brand sidebar-brand-sm">
			<a href="{{ route('home') }}">
				<img src="{{ getFile(config('basic.default_file_driver'),config('basic.admin_logo')) }}" class="dashboard-logo" alt="@lang('Logo')">
			</a>
		</div>

		<ul class="sidebar-menu">
			<li class="menu-header">@lang('Dashboard')</li>
			<li class="dropdown {{ activeMenu(['admin.home']) }}">
				<a href="{{ route('admin.home') }}" class="nav-link"><i
						class="fas fa-tachometer-alt text-primary"></i><span>@lang('Dashboard')</span></a>
			</li>

			<li class="menu-header">@lang('Manage Listing')</li>
			<li class="dropdown {{activeMenu(['admin.listing.list','admin.listing.order.list','admin.listing.service.fee'])}}">
				<a href="javascript:void(0)" class="nav-link has-dropdown" data-toggle="dropdown">
					<i class="fab fa-searchengin text-info"></i> <span>@lang('Manage Listing')</span>
				</a>
				<ul class="dropdown-menu">
					<li class="{{ activeMenu(['admin.listing.list']) }}">
						<a class="nav-link" href="{{route('admin.listing.list')}}">
							@lang('Listing list')
						</a>
					</li>

					<li class="{{ activeMenu(['admin.listing.order.list']) }}">
						<a class="nav-link" href="{{route('admin.listing.order.list')}}">
							@lang('Order List')
						</a>
					</li>

					<li class="{{ activeMenu(['admin.listing.service.fee']) }}">
						<a class="nav-link" href="{{route('admin.listing.service.fee')}}">
							@lang('Service Fee')
						</a>
					</li>

				</ul>
			</li>


			{{-- JOB  --}}
			<li class="menu-header">@lang('Manage Job')</li>
			<li class="dropdown {{activeMenu(['admin.jobs','admin.jobs.hire','admin.jobs.service.fee'])}}">
				<a href="javascript:void(0)" class="nav-link has-dropdown" data-toggle="dropdown">
					<i class="fab fa-searchengin text-info"></i> <span>@lang('Manage Job')</span>
				</a>
				<ul class="dropdown-menu">
					<li class="{{ activeMenu(['admin.jobs']) }}">
						<a class="nav-link" href="{{route('admin.jobs')}}">
							@lang('Job Lists')
						</a>
					</li>

					<li class="{{ activeMenu(['admin.jobs.hire']) }}">
						<a class="nav-link" href="{{route('admin.jobs.hire')}}">
							@lang('Hiring Lists')
						</a>
					</li>
					<li class="{{ activeMenu(['admin.jobs.service.fee']) }}">
						<a class="nav-link" href="{{ route('admin.jobs.service.fee') }}">
							@lang('Service Fees')
						</a>
					</li>

				</ul>
			</li>

			<li class="menu-header">@lang('User Panel')</li>
			<li class="dropdown {{ activeMenu(['user-list','user.search','inactive.user.search','send.mail.user','inactive.user.list']) }}">
				<a href="javascript:void(0)" class="nav-link has-dropdown" data-toggle="dropdown">
					<i class="fas fa-users text-red"></i> <span>@lang('User Management')</span>
				</a>
				<ul class="dropdown-menu">
					<li class="{{ activeMenu(['user-list','user.search']) }}">
						<a class="nav-link " href="{{ route('user-list') }}">
							@lang('All User')
						</a>
					</li>
					<li class="{{ activeMenu(['inactive.user.list','inactive.user.search']) }}">
						<a class="nav-link" href="{{ route('inactive.user.list') }}">
							@lang('Inactive User')
						</a>
					</li>
					<li class="{{ activeMenu(['send.mail.user']) }}">
						<a class="nav-link" href="{{ route('send.mail.user') }}">
							@lang('Send Mail All User')
						</a>
					</li>
				</ul>
			</li>


			<!--- More --->
			<li class="menu-header">@lang('More Utilities')</li>
			<li class="dropdown {{ activeMenu(['admin.category.index','admin.category.edit', 'admin.category.create', 'admin.subCategory.index','admin.subCategory.edit', 'admin.subCategory.create', 'admin.level.index','admin.level.edit','admin.level.create', 'admin.level.index','admin.level.edit','admin.level.create', 'admin.coupon.index','admin.coupon.edit','admin.coupon.create', 'admin.countryList','admin.countryCreate','admin.countryEdit', 'admin.stateList','admin.stateCreate', 'admin.state.search','admin.stateEdit', 'admin.cityList','admin.cityCreate', 'admin.city.search', 'admin.city.search','admin.cityEdit']) }}">
				<a href="javascript:void(0)" class="nav-link has-dropdown" data-toggle="dropdown">
					<i class="fas fa-list-ul text-info"></i> <span>@lang('Configuration')</span>
				</a>
				<ul class="dropdown-menu">
					<li class="{{ activeMenu(['admin.category.index','admin.category.edit', 'admin.category.create']) }}">
						<a class="nav-link " href="{{ route('admin.category.index') }}">
							@lang('Manage Category')
						</a>
					</li>
					<li class="{{ activeMenu(['admin.subCategory.index','admin.subCategory.edit', 'admin.subCategory.create']) }}">
						<a class="nav-link " href="{{ route('admin.subCategory.index') }}">
							@lang('Manage Sub-Category')
						</a>
					</li>

					<li class="{{ activeMenu(['admin.skill.list','admin.skill.edit', 'admin.skill.store']) }}">
						<a class="nav-link " href="{{ route('admin.skill.list') }}">
							@lang('Manage Skill')
						</a>
					</li>

					<li class="{{ activeMenu(['admin.jobs.dislike.reason']) }}">
						<a class="nav-link " href="{{ route('admin.jobs.dislike.reason') }}">
							@lang('Manage Dislike Reason')
						</a>
					</li>

					<li class="{{ activeMenu(['admin.deadline']) }}">
						<a class="nav-link " href="{{ route('admin.deadline') }}">
							@lang('Manage Deadline')
						</a>
					</li>

					<li class="{{ activeMenu(['admin.level.index','admin.level.edit','admin.level.create']) }}">
						<a class="nav-link" href="{{ route('admin.level.index') }}">
							@lang('Manage Rank Levels')
						</a>
					</li>
				
					<li class="{{ activeMenu(['admin.countryList','admin.countryCreate','admin.countryEdit']) }}">
						<a class="nav-link" href="{{ route('admin.countryList') }}">
							@lang('Manage Country')
						</a>
					</li>
					<li class="{{ activeMenu(['admin.stateList','admin.stateCreate', 'admin.state.search','admin.stateEdit']) }}">
						<a class="nav-link" href="{{ route('admin.stateList') }}">
							@lang('Manage State')
						</a>
					</li>
					<li class="{{ activeMenu(['admin.cityList','admin.cityCreate', 'admin.city.search', 'admin.city.search','admin.cityEdit']) }}">
						<a class="nav-link" href="{{ route('admin.cityList') }}">
							@lang('Manage City')
						</a>
					</li>

					
				</ul>
			</li>

			<!--- Support Tickets --->
			<li class="menu-header">@lang('Support Tickets')</li>
			<li class="dropdown {{ activeMenu(['admin.ticket','admin.ticket.view','admin.ticket.search']) }}">
				<a href="{{ route('admin.ticket') }}" class="nav-link"><i
						class="fas fa-headset text-green"></i><span>@lang('Tickets')</span></a>
			</li>

			<li class="menu-header">@lang('Transactions')</li>
			@if($basic->deposit)
				<li class="dropdown {{ activeMenu(['admin.fund.add.index','admin.fund.add.search']) }}">
					<a href="{{ route('admin.fund.add.index') }}" class="nav-link"><i
							class="fas fa-money-check-alt text-green"></i><span>@lang('Add Fund List')</span></a>
				</li>
			@endif

			@if($basic->payout)
				<li class="dropdown {{ activeMenu(['admin.payout.index','admin.payout.search','payout.details']) }}">
					<a href="{{ route('admin.payout.index') }}" class="nav-link">
						<i class="far fa-money-bill-alt text-info"></i><span>@lang('Withdrawal List')</span></a>
				</li>
			@endif

			<li class="{{ activeMenu(['admin.payment.pending']) }}">
				<a class="nav-link" href="{{route('admin.payment.pending')}}">
					<i class="far fa-money-bill-alt text-success"></i><span>@lang('Payment Request')</span>

				</a>
			</li>
			<li class="{{ activeMenu(['admin.payment.log','admin.payment.search']) }}">
				<a class="nav-link" href="{{route('admin.payment.log')}}">
					<i class="far fa-money-bill-alt text-primary"></i><span>@lang('Payment Log')</span>
				</a>
			</li>

			<li class="dropdown {{ activeMenu(['admin.payout.index','admin.payout.search','payout.details']) }}">
				<a href="{{ route('admin.payout.index') }}" class="nav-link"><i
						class="far fa-money-bill-alt text-info"></i><span>@lang('Withdrawal List')</span></a>
			</li>

			<li class="dropdown {{ activeMenu(['admin.transaction.index','admin.transaction.search']) }}">
				<a href="{{ route('admin.transaction.index') }}" class="nav-link"><i
						class="fas fa-chart-line text-warning"></i><span>@lang('Transaction List')</span></a>
			</li>

			<!--- Manage Settings Panel --->
			<li class="menu-header">@lang('Settings Panel')</li>

			<li class="dropdown {{ activeMenu(['settings','seo.update','plugin.config','tawk.control','google.analytics.control','google.recaptcha.control','fb.messenger.control','service.control','logo.update','breadcrumb.update','seo.update','currency.exchange.api.config','sms.config', 'sms.template.index','sms.template.edit','voucher.settings','basic.control','securityQuestion.index','securityQuestion.create','securityQuestion.edit','pusher.config','notify.template.index','notify.template.edit','language.index','language.create', 'language.edit','language.keyword.edit', 'email.config','email.template.index','email.template.default', 'email.template.edit', 'charge.index', 'charge.edit', 'currency.index', 'currency.create', 'currency.edit', 'charge.chargeEdit', 'google.login.control', 'facebook.login.control', 'github.login.control', 'twitter.login.control', 'linkedin.login.control' ]) }}">
				<a href="{{ route('settings') }}" class="nav-link"><i
						class="fas fa-cog text-primary"></i><span>@lang('Control Panel')</span></a>
			</li>

			<li class="dropdown {{ activeMenu(['payment.methods','edit.payment.methods','admin.deposit.manual.index','admin.deposit.manual.create','admin.deposit.manual.edit']) }}">
				<a href="javascript:void(0)" class="nav-link has-dropdown" data-toggle="dropdown">
					<i class="fas fa-money-check-alt text-success"></i> <span>@lang('Payment Settings')</span>
				</a>
				<ul class="dropdown-menu">
					<li class="{{ activeMenu(['payment.methods','edit.payment.methods']) }}">
						<a class="nav-link" href="{{ route('payment.methods') }}">
							@lang('Payment Methods')
						</a>
					</li>

					<li class="{{ activeMenu(['admin.deposit.manual.index','admin.deposit.manual.create','admin.deposit.manual.edit']) }}">
						<a class="nav-link" href="{{route('admin.deposit.manual.index')}}">
							@lang('Manual Gateway')
						</a>
					</li>

				</ul>
			</li>

			<li class="dropdown {{ activeMenu(['payout.method.list','payout.method.add','payout.method.edit']) }}">
				<a href="javascript:void(0)" class="nav-link has-dropdown" data-toggle="dropdown">
					<i class="fas fa-users-cog text-danger"></i> <span>@lang('Payout Settings')</span>
				</a>
				<ul class="dropdown-menu">
					<li class="{{ activeMenu(['payout.method.list','payout.method.edit']) }}">
						<a class="nav-link" href="{{ route('payout.method.list') }}">
							@lang('Available Methods')
						</a>
					</li>
					<li class="{{ activeMenu(['payout.method.add']) }}">
						<a class="nav-link" href="{{ route('payout.method.add') }}">
							@lang('Add Method')
						</a>
					</li>
				</ul>
			</li>


			<li class="dropdown {{ activeMenu(['template.show']) }}">
				<a href="javascript:void(0)" class="nav-link has-dropdown" data-toggle="dropdown">
					<i class="fas fa-users text-info"></i> <span>@lang('UI Settings')</span>
				</a>
				<ul class="dropdown-menu">
					@foreach(array_diff(array_keys(config('templates')),['message','template_media']) as $name)
						<li class="{{ activeMenu(['template.show'],$name) }}">
							<a class="nav-link" href="{{ route('template.show',$name) }}">
								@lang(ucfirst(kebab2Title($name)))
							</a>
						</li>
					@endforeach
				</ul>
			</li>
			<li class="dropdown {{ activeMenu(['content.index','content.create','content.show']) }}">
				<a href="javascript:void(0)" class="nav-link has-dropdown" data-toggle="dropdown">
					<i class="fas fa-cogs text-dark"></i> <span>@lang('Content Settings')</span>
				</a>
				<ul class="dropdown-menu">
					@foreach(array_diff(array_keys(config('contents')),['message','content_media']) as $name)
						<li class="{{ activeMenu(['content.index','content.create','content.show'],$name) }}">
							<a class="nav-link" href="{{ route('content.index',$name) }}">
								@lang(ucfirst(kebab2Title($name)))
							</a>
						</li>
					@endforeach
				</ul>
			</li>

			<!--- blog --->
			<li class="menu-header">@lang('Manage Blog')</li>
			<li class="dropdown {{activeMenu(['admin.blogCategory','admin.blogCategoryCreate','admin.blogCategoryEdit','admin.blogList','admin.blogCreate','admin.blogEdit'])}}">
				<a href="javascript:void(0)" class="nav-link has-dropdown" data-toggle="dropdown">
					<i class="fas fa-book-reader text-dark"></i> <span>@lang('Manage Blog')</span>
				</a>
				<ul class="dropdown-menu">
					<li class="{{ activeMenu(['admin.blogCategory','admin.blogCategoryCreate','admin.blogCategoryEdit']) }}">
						<a class="nav-link" href="{{route('admin.blogCategory')}}">
							@lang('Blog Category')
						</a>
					</li>
					<li class="{{ activeMenu(['admin.blogList','admin.blogCreate','admin.blogEdit']) }}">
						<a class="nav-link" href="{{ route('admin.blogList') }}">
							@lang('Blog List')
						</a>
					</li>
				</ul>
			</li>

			@foreach(collect(config('generalsettings.settings')) as $key => $setting)
				<li class="dropdown d-none {{ isMenuActive($setting['route']) }}">
					<a href="{{ getRoute($setting['route'], $setting['route_segment'] ?? null) }}"
					   class="{{isMenuActive($setting['route'])}}"><i
							class="{{$setting['icon']}} text-info"></i><span>{{ __(getTitle($key.' '.'Settings')) }}</span></a>
				</li>
			@endforeach


		</ul>

		<div class="mt-4 mb-4 p-3 hide-sidebar-mini">
		</div>
	</aside>
</div>
