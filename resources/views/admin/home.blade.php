@extends('admin.layouts.master')
@section('page_title',__('Dashboard'))

@section('content')
	<div class="main-content">
		<section class="section">
			<div class="section-header">
				<h1>@lang('Admin Dashboard')</h1>
				<div class="section-header-breadcrumb">
					<div class="breadcrumb-item active">
						<a href="{{ route('admin.home') }}">@lang('Dashboard')</a>
					</div>
					<div class="breadcrumb-item">@lang('Admin Dashboard')</div>
				</div>
			</div>


			<!---------- Firebase Notification Allow -------------->
			<div class="row " id="firebase-app" v-if="admin_foreground == '1' || admin_background == '1'">
				<div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 mb-4 mt-0"
					 v-if="notificationPermission == 'default' && !is_notification_skipped" v-cloak>
					<div class="d-flex justify-content-between align-items-start bd-callout bd-callout-warning  shadow">
						<div>
							<i class="fas fa-info-circle mr-2"></i> @lang('Do not miss any single important notification! Allow your
                        browser to get instant push notification')
							<button id="allow-notification" class="btn btn-sm btn-primary mx-2"><i
									class="fa fa-check-circle"></i> @lang('Allow me')</button>
						</div>
						<a href="javascript:void(0)" @click.prevent="skipNotification"><i class="fas fa-times"></i></a>
					</div>
				</div>

				<div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 mb-4 mt-0"
					 v-if="notificationPermission == 'denied' && !is_notification_skipped" v-cloak>
					<div class="d-flex justify-content-between align-items-start bd-callout bd-callout-warning  shadow">
						<div>
							<i class="fas fa-info-circle mr-2"></i> @lang('Please allow your browser to get instant push notification.
                        Allow it from
                        notification setting.')
						</div>
						<a href="javascript:void(0)" @click.prevent="skipNotification"><i class="fas fa-times"></i></a>
					</div>
				</div>
			</div>


			<!---------- User Statistics -------------->
			<div class="row mb-3">
				<div class="col-md-12">
					<h6 class="mb-3 text-darku">@lang('User Statistics')</h6>
				</div>
				<div class="col-lg-3 col-md-6 col-sm-6 col-12">
					<div class="card card-statistic-1 shadow-sm">
						<div class="card-icon bg-primary">
							<i class="fas fa-users"></i>
						</div>
						<div class="card-wrap">
							<div class="card-header">
								<h4>@lang('Total User')</h4>
							</div>
							<div class="card-body">
								{{ (getAmount($userRecord['totalUser']))  }}
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-md-6 col-sm-6 col-12">
					<div class="card card-statistic-1 shadow-sm">
						<div class="card-icon bg-primary">
							<i class="fas fa-user-tie"></i>
						</div>
						<div class="card-wrap">
							<div class="card-header">
								<h4>@lang('Active User')</h4>
							</div>
							<div class="card-body">
								{{ (getAmount($userRecord['activeUser']))  }}
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-md-6 col-sm-6 col-12">
					<div class="card card-statistic-1 shadow-sm">
						<div class="card-icon bg-primary">
							<i class="fas fa-user-check"></i>
						</div>
						<div class="card-wrap">
							<div class="card-header">
								<h4>@lang('Verified User')</h4>
							</div>
							<div class="card-body">
								{{ (getAmount($userRecord['verifiedUser'])) }}
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-md-6 col-sm-6 col-12">
					<div class="card card-statistic-1 shadow-sm">
						<div class="card-icon bg-primary">
							<i class="fas fa-user-plus"></i>
						</div>
						<div class="card-wrap">
							<div class="card-header">
								<h4>@lang('New User')</h4>
							</div>
							<div class="card-body">
								{{ (getAmount($userRecord['todayJoin'])) }}
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="row mb-3">
				<div class="col-md-12">
					<h6 class="mb-3 text-darku">@lang('Job Statistics')</h6>
				</div>
				<div class="col-lg-3 col-md-6 col-sm-6 col-12">
					<div class="card card-statistic-1 shadow-sm">
						<div class="card-icon bg-primary">
							<i class="fab fa-searchengin"></i>
						</div>
						<div class="card-wrap">
							<div class="card-header">
								<h4>@lang('Total Job')</h4>
							</div>
							<div class="card-body">
								{{ $jobs['allJobs'] }}
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-md-6 col-sm-6 col-12">
					<div class="card card-statistic-1 shadow-sm">
						<div class="card-icon bg-primary">
							<i class="fas fa-hourglass-start"></i>

						</div>
						<div class="card-wrap">
							<div class="card-header">
								<h4>@lang('Pending Jobs')</h4>
							</div>
							<div class="card-body">
								{{ $jobs['pendingJobs'] }}
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-md-6 col-sm-6 col-12">
					<div class="card card-statistic-1 shadow-sm">
						<div class="card-icon bg-primary">
							<i class="fas fa-clipboard-list"></i>
						</div>
						<div class="card-wrap">
							<div class="card-header">
								<h4>@lang('Approved Jobs')</h4>
							</div>
							<div class="card-body">
								{{ $jobs['approveJobs'] }}
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-md-6 col-sm-6 col-12">
					<div class="card card-statistic-1 shadow-sm">
						<div class="card-icon bg-primary">
							<i class="fas fa-check-circle"></i>

						</div>
						<div class="card-wrap">
							<div class="card-header">
								<h4>@lang('Completed Jobs')</h4>
							</div>
							<div class="card-body">
								{{ $jobs['completedJobs'] }}
							</div>
						</div>
					</div>
				</div>
			</div>


			<div class="row mb-3">
				<div class="col-md-12">
					<h6 class="mb-3 text-darku">@lang('Listing Order Statistics')</h6>
				</div>
				<div class="col-lg-3 col-md-6 col-sm-6 col-12">
					<div class="card card-statistic-1 shadow-sm">
						<div class="card-icon bg-primary">
							<i class="fab fa-searchengin"></i>
						</div>
						<div class="card-wrap">
							<div class="card-header">
								<h4>@lang('Total Listing')</h4>
							</div>
							<div class="card-body">
								{{ $orders['total'] }}
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-md-6 col-sm-6 col-12">
					<div class="card card-statistic-1 shadow-sm">
						<div class="card-icon bg-primary">
							<i class="fas fa-hourglass-start"></i>

						</div>
						<div class="card-wrap">
							<div class="card-header">
								<h4>@lang('Pending Order')</h4>
							</div>
							<div class="card-body">
								{{ $orders['pending'] }}
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-md-6 col-sm-6 col-12">
					<div class="card card-statistic-1 shadow-sm">
						<div class="card-icon bg-primary">
							<i class="fas fa-clipboard-list"></i>
						</div>
						<div class="card-wrap">
							<div class="card-header">
								<h4>@lang('Approved Order')</h4>
							</div>
							<div class="card-body">
								{{ $orders['approved'] }}
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-md-6 col-sm-6 col-12">
					<div class="card card-statistic-1 shadow-sm">
						<div class="card-icon bg-primary">
							<i class="fas fa-solid fa-check-double"></i>
						</div>
						<div class="card-wrap">
							<div class="card-header">
								<h4>@lang('Done Order')</h4>
							</div>
							<div class="card-body">
								{{ $orders['done'] }}
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-md-6 col-sm-6 col-12">
					<div class="card card-statistic-1 shadow-sm">
						<div class="card-icon bg-primary">
							<i class="fas fa-clipboard-list"></i>
						</div>
						<div class="card-wrap">
							<div class="card-header">
								<h4>@lang('Completed Order')</h4>
							</div>
							<div class="card-body">
								{{ $orders['completed'] }}
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-md-6 col-sm-6 col-12">
					<div class="card card-statistic-1 shadow-sm">
						<div class="card-icon bg-primary">
							<i class="fas fa-times"></i>
						</div>
						<div class="card-wrap">
							<div class="card-header">
								<h4>@lang('Canceled Order')</h4>
							</div>
							<div class="card-body">
								{{ $orders['canceled'] }}
							</div>
						</div>
					</div>
				</div>

			</div>

			<!---------- Transaction Summary -------------->
			<div class="row mb-3">
				<div class="col-md-12">
					<div class="card mb-4 shadow-sm">
						<div class="card-body">
							<h5 class="card-title">@lang('This month transactions summary')</h5>
							<div>
								<canvas id="line-chart" height="80"></canvas>
							</div>
						</div>
					</div>
				</div>
			</div>


			@if($basic->request)
				<!---------- User Request Money Summary -------------->
				<div class="row mb-3">
					<div class="col-md-12">
						<h6 class="mb-3 text-darku">@lang('User Request Money Summary')</h6>
					</div>
					<div class="col-lg-3 col-md-6 col-sm-6 col-12">
						<div class="card card-statistic-1 shadow-sm">
							<div class="card-icon bg-warning img-div">
								<i class="fas fa-calendar-check"></i>
							</div>
							<div class="card-wrap">
								<div class="card-header">
									<h4>@lang('Last 30 Days Request Money')</h4>
								</div>
								<div class="card-body">
									{{ __($basicControl->currency_symbol) }}
									{{ (round($requestMoney['request_money_30_days'], 2)) }}
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-3 col-md-6 col-sm-6 col-12">
						<div class="card card-statistic-1 shadow-sm">
							<div class="card-icon bg-warning">
								<i class="far fa-calendar"></i>
							</div>
							<div class="card-wrap">
								<div class="card-header">
									<h4>@lang("Last 7 Days Request Money")</h4>
								</div>
								<div class="card-body">
									{{ __($basicControl->currency_symbol) }}
									{{ (round($requestMoney['request_money_7_days'], 2)) }}
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-3 col-md-6 col-sm-6 col-12">
						<div class="card card-statistic-1 shadow-sm">
							<div class="card-icon bg-warning">
								<i class="far fa-calendar-alt"></i>
							</div>
							<div class="card-wrap">
								<div class="card-header">
									<h4>@lang("Today Request Money")</h4>
								</div>
								<div class="card-body">
									{{ __($basicControl->currency_symbol) }}
									{{ (round($requestMoney['request_money_today'], 2)) }}
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-3 col-md-6 col-sm-6 col-12">
						<div class="card card-statistic-1 shadow-sm">
							<div class="card-icon bg-warning">
								<i class="fas fa-coins"></i>
							</div>
							<div class="card-wrap">
								<div class="card-header">
									<h4>@lang("Last 30 days Income")</h4>
								</div>
								<div class="card-body">
									{{ __($basicControl->currency_symbol) }}
					{{ (round($requestMoney['request_money_income_30_days'], 2)) }}
								</div>
							</div>
						</div>
					</div>
				</div>
			@endif


			<!---------- Withdraw & Deposit -------------->
			<div class="row mb-3">
				<div class="col-md-8">
					<div class="card mb-4 shadow-sm">
					<div class="card-body">
						<h5 class="card-title">@lang('Withdraw & Deposit')</h5>
						<div>
						<canvas id="line-chart-2" height="120"></canvas>
						</div>
					</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="card mb-4 shadow-sm">
					<div class="card-body">
						<h5 class="card-title">@lang('Gateway Used For Deposit')</h5>
						<div>
						<canvas id="pie-chart-2" height="255"></canvas>
						</div>
					</div>
					</div>
				</div>
			</div>


			<!------------------- Latest User --------------------->
			<div class="row">
				<div class="col-xl-12 col-lg-7">
					<div class="card shadow-sm">
						<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
							<h6 class="m-0 font-weight-bold text-primary">@lang('Latest User')</h6>
							<a class="m-0 float-right btn btn-primary btn-sm" href="{{ route('user-list') }}">@lang('View More') <i class="fas fa-chevron-right"></i></a>
						</div>
						<div class="table-responsive">
							<table class="table table-hover table-striped align-items-center table-flush">
								<thead class="thead-light">
								<tr>
									<th>@lang('Name')</th>
									<th>@lang('Phone')</th>
									<th>@lang('Email')</th>
									<th>@lang('Join date')</th>
									<th>@lang('Status')</th>
									<th>@lang('Last login')</th>
									<th>@lang('Action')</th>
								</tr>
								</thead>
								<tbody>
								@forelse($users as $key => $value)
									<tr>
										<td data-label="@lang('Name')">{{ __($value->name) }}</td>
										<td data-label="@lang('Phone')">{{ __(optional($value->profile)->phone ?? __('N/A')) }}</td>
										<td data-label="@lang('Email')">{{ __($value->email) }}</td>
										<td data-label="@lang('Join date')">{{ __(date('d/m/Y - h:i A',strtotime($value->created_at))) }}</td>
										<td data-label="@lang('Status')">
											@if($value->status)
												<span class="badge badge-success">@lang('Active')</span>
											@else
												<span class="badge badge-warning">@lang('Inactive')</span>
											@endif
										</td>
										<td data-label="@lang('Last login')">{{ (optional($value->profile)->last_login_at) ? __(date('d/m/Y - h:i A',strtotime($value->profile->last_login_at))) : __('N/A') }}</td>
										<td data-label="@lang('Action')">
											<a href="{{ route('user.edit',$value) }}" class="btn btn-sm btn-outline-primary m-1"><i class="fas fa-user-edit"></i> @lang('Edit')</a>
											<a href="{{ route('send.mail.user',$value) }}" class="btn btn-sm btn-outline-primary m-1"><i class="fas fa-envelope"></i> @lang('Send mail')</a>
											<a href="{{ route('user.asLogin',$value) }}" class="btn btn-sm btn-outline-dark"><i class="fas fa-sign-in-alt"></i> @lang('Login')</a>
										</td>
									</tr>
								@empty
									<tr>
										<th colspan="100%" class="text-center">@lang('No data found')</th>
									</tr>
								@endforelse
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>

		</section>
	</div>


	@if($basicControl->is_active_cron_notification)
		<div class="modal fade" id="cron-info" role="dialog">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">
							<i class="fas fa-info-circle"></i>
							@lang('Cron Job Set Up Instruction')
						</h5>
						<button type="button" class="close cron-notification-close" data-dismiss="modal"
								aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="col-md-12">
								<p class="bg-orange text-white p-2">
									<i>@lang('**To sending emails and updating currency rate automatically you need to setup cron job in your server. Make sure your job is running properly. We insist to set the cron job time as minimum as possible.**')</i>
								</p>
							</div>
							<div class="col-md-12 form-group">
								<label><strong>@lang('Command for Email')</strong></label>
								<div class="input-group ">
									<input type="text" class="form-control copyText"
										value="curl -s {{ route('queue.work') }}" disabled>
									<div class="input-group-append">
										<button class="input-group-text bg-primary btn btn-primary text-white copy-btn">
											<i class="fas fa-copy"></i></button>
									</div>
								</div>
							</div>
							<div class="col-md-12 form-group">
								<label><strong>@lang('Command for Currency Rate Update')</strong></label>
								<div class="input-group ">
									<input type="text" class="form-control copyText"
										value="curl -s {{ route('schedule:run') }}"
										disabled>
									<div class="input-group-append">
										<button class="input-group-text bg-primary btn btn-primary text-white copy-btn">
											<i class="fas fa-copy"></i></button>
									</div>
								</div>
							</div>
							<div class="col-md-12 text-center">
								<p class="bg-dark text-white p-2">
									@lang('*To turn off this pop up go to ')
									<a href="{{route('basic.control')}}"
									class="text-orange">@lang('Basic control')</a>
									@lang(' and disable `Cron Set Up Pop Up`.*')
								</p>
							</div>

							<div class="col-md-12">
								<p class="text-muted"><span class="text-secondary font-weight-bold">@lang('N.B'):</span>
									@lang('If you are unable to set up cron job, Here is a video tutorial for you')
									<a href="https://www.youtube.com/watch?v=wuvTRT2ety0" target="_blank"><i
											class="fab fa-youtube"></i> @lang('Click Here') </a>
								</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	@endif

@endsection


@push('extra_scripts')
	<script src="{{ asset('assets/dashboard/js/Chart.min.js') }}"></script>
@endpush

@section('scripts')
	<script>
		'use strict';
		$(document).ready(function(){
		new Chart(document.getElementById("line-chart"), {
			type: 'line',
			data: {
				labels: {!! json_encode($labels) !!},
				datasets: [
						@if($basic->deposit)
					{
						data: @json($dataDeposit),
						label: "Deposit",
						borderColor: "#33d9b2",
						fill: false
					},
						@endif
					{
						data: @json($dataTransfer),
						label: "Transfer",
						borderColor: "#007bff",
						fill: false
					},

						@if($basic->payout)
					{
						data: {!! json_encode($dataPayout) !!},
						label: "Payout",
						borderColor: "#05c46b",
						fill: false
					},
						@endif
				]
			}
		});

		new Chart(document.getElementById("line-chart-2"), {
			type: 'bar',
			data: {
				labels:  {!! json_encode($yearLabels) !!},
				datasets: [
					{
						data: {!! json_encode($yearDeposit) !!},
						label: "Deposit",
						borderColor: "#8e44ad",
						backgroundColor: "#8e44ad",
					},
					{
						data: {!! json_encode($yearPayout) !!},
						label: "Withdraw",
						borderColor: "#4455ad",
						backgroundColor: "#4455ad",
					},
				]
			}
		});

		new Chart(document.getElementById("pie-chart-2"), {
			type: 'pie',
			data: {
				labels: {!! json_encode($paymentMethodeLabel) !!},
				datasets: [{
					backgroundColor: ["#1abc9c", "#2ecc71", "#3498db", "#9b59b6", "#34495e", "#16a085", "#27ae60", "#2980b9", "#8e44ad", "#2c3e50",
						"#f1c40f", "#e67e22", "#e74c3c", "#ecf0f1", "#95a5a6", "#f39c12", "#d35400", "#c0392b", "#bdc3c7", "#7f8c8d",
						"#55efc4", "#81ecec", "#74b9ff", "#a29bfe", "#dfe6e9",
					],
					data: {!! json_encode($paymentMethodeData) !!},
				}]
			},
			options: {
				tooltips: {
					callbacks: {
						label: function (tooltipItems, data) {
							return data.labels[tooltipItems.index] + ': ' + data.datasets[0].data[tooltipItems.index] + " {{ __($basicControl->base_currency_code) }}";
						}
					}
				}
			}
		});
		});

		$(document).ready(function () {
			let isActiveCronNotification = '{{ $basicControl->is_active_cron_notification }}';
			if (isActiveCronNotification == 1)
				$('#cron-info').modal('show');
			$(document).on('click', '.copy-btn', function () {
				var _this = $(this)[0];
				var copyText = $(this).parents('.input-group-append').siblings('input');
				$(copyText).prop('disabled', false);
				copyText.select();
				document.execCommand("copy");
				$(copyText).prop('disabled', true);
				$(this).text('Coppied');
				setTimeout(function () {
					$(_this).text('');
					$(_this).html('<i class="fas fa-copy"></i>');
				}, 500)
			});
		})
	</script>
@endsection


<!-- for firebase notification -->
@if($firebaseNotify)
	@push('extra_scripts')
		<script type="module">

			import {initializeApp} from "https://www.gstatic.com/firebasejs/9.17.1/firebase-app.js";
			import {
				getMessaging,
				getToken,
				onMessage
			} from "https://www.gstatic.com/firebasejs/9.17.1/firebase-messaging.js";

			const firebaseConfig = {
				apiKey: "{{$firebaseNotify->api_key}}",
				authDomain: "{{$firebaseNotify->auth_domain}}",
				projectId: "{{$firebaseNotify->project_id}}",
				storageBucket: "{{$firebaseNotify->storage_bucket}}",
				messagingSenderId: "{{$firebaseNotify->messaging_sender_id}}",
				appId: "{{$firebaseNotify->app_id}}",
				measurementId: "{{$firebaseNotify->measurement_id}}"
			};

			const app = initializeApp(firebaseConfig);
			const messaging = getMessaging(app);
			if ('serviceWorker' in navigator) {
				navigator.serviceWorker.register('{{ getProjectDirectory() }}' + `/firebase-messaging-sw.js`, {scope: './'}).then(function (registration) {
						requestPermissionAndGenerateToken(registration);
					}
				).catch(function (error) {
				});
			} else {
			}

			onMessage(messaging, (payload) => {
				if (payload.data.foreground || parseInt(payload.data.foreground) == 1) {
					const title = payload.notification.title;
					const options = {
						body: payload.notification.body,
						icon: payload.notification.icon,
					};
					new Notification(title, options);
				}
			});

			function requestPermissionAndGenerateToken(registration) {
				document.addEventListener("click", function (event) {
					if (event.target.id == 'allow-notification') {
						Notification.requestPermission().then((permission) => {
							if (permission === 'granted') {
								getToken(messaging, {
									serviceWorkerRegistration: registration,
									vapidKey: "{{$firebaseNotify->vapid_key}}"
								})
									.then((token) => {
										$.ajax({
											url: "{{ route('admin.save.token') }}",
											method: "post",
											data: {
												token: token,
											},
											success: function (res) {

											}
										});
										window.newApp.notificationPermission = 'granted';
									});
							} else {
								window.newApp.notificationPermission = 'denied';
							}
						});
					}
				});
			}
		</script>

		<script>
			window.newApp = new Vue({
				el: "#firebase-app",
				data: {
					admin_foreground: '',
					admin_background: '',
					notificationPermission: Notification.permission,
					is_notification_skipped: sessionStorage.getItem('is_notification_skipped') == '1'
				},
				mounted() {
					this.admin_foreground = "{{$firebaseNotify->admin_foreground}}";
					this.admin_background = "{{$firebaseNotify->admin_background}}";
				},
				methods: {
					skipNotification() {
						sessionStorage.setItem('is_notification_skipped', '1');
						this.is_notification_skipped = true;
					}
				}
			});
		</script>
	@endpush
@endif
