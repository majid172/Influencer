@extends($theme.'layouts.user')
@section('title',__('Dashboard'))

@section('content')
	<div class="col-xl-9 col-lg-8 col-md-12">
		<div class="row g-4">
			<!--- Firebase Notification Allow --->
			<div class="col-12 align-items-end" id="firebase-app">
				<div class="card-box p-0">
					<div v-if="user_foreground == '1' || user_background == '1'">
						<div v-if="notificationPermission == 'default' && !is_notification_skipped" v-cloak>
							<div class="media align-items-center d-flex justify-content-between alert alert-warn mb-4">
								<div class="d-flex flex-row align-items-center">
									<i class="fas fa-info-circle me-1"></i>
									@lang('Do not miss any single important notification! Allow your browser to get instant push notification')
									<button class="btn btn-action text-white ms-1" id="allow-notification"><i class="fa-regular fa-circle-check text-white font16 me-0"></i> @lang('Allow me')</button>
								</div>
								<button class="close-btn pt-1" @click.prevent="skipNotification"><i class="fas fa-times"></i>
								</button>
							</div>
						</div>
					</div>
					<div v-if="notificationPermission == 'denied' && !is_notification_skipped" v-cloak>
						<div class="media align-items-center d-flex justify-content-between alert alert-warn mb-4">
							<div><i class="fas fa-info-circle mr-2"></i>
								@lang('Please allow your browser to get instant push notification.Allow it from
									notification setting.')
							</div>
							<button class="close-btn pt-1" @click.prevent="skipNotification"><i class="fas fa-times"></i>
							</button>
						</div>
					</div>
				</div>
			</div>

			<div class="col-12">
				<div class="card-box p-0">
					<div class="row align-items-end">
						<div class="col-lg-7">
							<div class="p-4">
								<h5 class="text-primary ">@lang('Welcome') @lang(auth()->user()->name)! 🎉</h5>
								@if(auth()->user()->is_client == 1)
									<a href="{{route('user.job.create')}}" class="btn-custom">@lang('Create Job')</a>
								@else
									<a href="{{route('user.listing.create')}}" class="btn-custom">@lang('Create Listing')</a>
								@endif
							</div>
						</div>
						<div class="col-lg-5 text-center text-sm-left d-none d-lg-block">
							<div class="text-right">
								<img src="{{asset($themeTrue.'images/dashboard-man-with-pc.png')}}"
									 height="140" alt="View Badge User"
									 data-app-dark-img="{{asset($themeTrue.'images/dashboard-man-with-pc.png')}}"
									 data-app-light-img="{{asset($themeTrue.'images/dashboard-man-with-pc.png')}}" />
							</div>
						</div>
					</div>
				</div>
			</div>

			@if (auth()->user()->is_client)
				<div class="col-lg-4 col-md-12 col-sm-6">
					<div class="card-box">
						<div class="d-flex justify-content-between">
							<h4> {{$jobProposal}} </h4>
							<i class="fa-light fa-chart-network"></i>
						</div>
						<p class="mb-0">@lang('Total Job Proposal')</p>
					</div>
				</div>

			@endif
			<div class="col-lg-4 col-md-12 col-sm-6">
				<div class="card-box">
					<div class="d-flex justify-content-between">
						<h4>{{$basic->currency_symbol}}{{getAmount($user->balance)}}</h4>
						<i class="fa-light fa-chart-network"></i>
					</div>
					<p class="mb-0">@lang('Earnings')</p>
				</div>
			</div>
			<div class="col-lg-4 col-md-12 col-sm-6">
				<div class="card-box">
					<div class="d-flex justify-content-between">
						<h4>{{$basic->currency_symbol}}{{getAmount($avg_selling)}}</h4>
						<i class="fa-light fa-chart-mixed"></i>
					</div>
					<p class="mb-0">@lang('Avg. selling price')</p>
				</div>
			</div>

			@if(auth()->user()->is_influencer == 1)
				<div class="col-lg-4 col-md-12 col-sm-6">
					<div class="card-box">
						<div class="d-flex justify-content-between">
							<h4> {{$active_orders->count()}}</h4>
							<i class="fa-brands fa-creative-commons-nd"></i>
						</div>
						<p class="mb-0">@lang('Active Listing Orders')</p>
					</div>
				</div>

				<div class="col-lg-4 col-md-12 col-sm-6">
					<div class="card-box">
						<div class="d-flex justify-content-between">
							<h4> {{$complete_order->count()}}</h4>
							<i class="fa-regular fa-check-circle"></i>
						</div>
						<p class="mb-0">@lang('Completed Listing Orders ')</p>
					</div>
				</div>

				<div class="col-lg-4 col-md-12 col-sm-6">
					<div class="card-box">
						<div class="d-flex justify-content-between">
							<h4> {{$cancel_order->count()}}</h4>
							<i class="fa-regular fa-ban"></i>
						</div>
						<p class="mb-0">@lang('Cancel Orders')</p>
					</div>
				</div>
				<div class="col-lg-4 col-md-12 col-sm-6">
					<div class="card-box">
						<div class="d-flex justify-content-between">
							<h4> {{$complete_job}}</h4>
							<i class="fa-regular fa-check-circle"></i>
						</div>
						<p class="mb-0">@lang('Completed Jobs')</p>
					</div>
				</div>

			@endif
			<div class="col-lg-6 col-sm-6 col-md-12">
				<div class="card-box">
					<div class="d-flex justify-content-between">
						<div class="listing_chart" id="transaction"></div>
					</div>
				</div>
			</div>

			<div class="col-lg-6 col-sm-6 col-md-12">
				<div class="card-box">
					<div class="d-flex justify-content-between">
						<div class="listing_chart" id="listing_chart"></div>
					</div>
				</div>
			</div>

			<div class="col-lg-12 col-sm-12 col-md-12">
				<div class="card-box ">

					<div id="reportrange" class=" px-2 py-2 cursor-pointer mb-3 text-end">
						<i class="fa fa-calendar"></i>&nbsp;
						<span></span> <i class="fa fa-caret-down"></i>
					</div>

					<div class="" id="transaction_chartId">

						<div class="listing_chart" id="trx_chartId"></div>
					</div>
				</div>
			</div>

		</div>
	</div>


@endsection

@push('style')
	<link rel="stylesheet" href="{{asset($themeTrue.'css/daterangepicker.css')}}" />
@endpush
@push('extra_scripts')
	<script src="{{asset($themeTrue.'js/moment.js')}}"></script>
	<script src="{{asset($themeTrue.'js/daterangepicker.min.js')}}"></script>
	<script src="{{asset($themeTrue.'js/apexcharts.min.js')}}"></script>

	<script type="text/javascript">

		$(document).ready(function () {
			$(function() {
				var start = moment().subtract(29, 'days');
				var end = moment();

				function callback(start, end) {

					$('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
					getTranctionData(start, end)
				}
				$('#reportrange').daterangepicker({
					startDate: start,
					endDate: end,
					ranges: {
						'Today': [moment(), moment()],
						'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
						'Last 7 Days': [moment().subtract(6, 'days'), moment()],
						'Last 30 Days': [moment().subtract(29, 'days'), moment()],
						'This Month': [moment().startOf('month'), moment().endOf('month')],
						'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
					}

				}, callback);

				callback(start, end);

			});

			function getTranctionData(start, end) {
				const requestData = {
					start: new Date(start),
					end: new Date(end)
				};
				$.ajax({
					url: "{{route('user.transaction.chart')}}",
					method: 'GET',
					data: requestData,
					success: function(response) {
						transactionChart(response)
					},
					error: function(error) {
						console.error('Error:', error);
					}
				});
			}

			function transactionChart(data) {
				var options = {
					series: [{
						name: 'Transfer',
						data: data.dataTransfer
					},
						{
							name:'Payout',
							data:  data.dataPayout
						}],

					chart: {
						height: 300,
						width:900,
						type: 'area'
					},
					dataLabels: {
						enabled: false
					},
					title:{
						text:'Transactions'
					},
					stroke: {
						curve: 'smooth'
					},
					xaxis: {
						type: 'date',
						categories:  data.labels
					},
					tooltip: {
						x: {
							format: 'dd/MM/yy'
						},
					},
				};

				var chart = new ApexCharts(document.querySelector("#trx_chartId"), options);
				chart.render();

			}
		})

	</script>


@endpush


@section('scripts')

	<script>
		'use strict';
		$(document).ready(function () {

			var sendingValues = @json($sendingValues);
			var receivingValues = @json($receivingValues);
			var dateReceiving = @json($dateReceiving);
			var transfer = @json($dataTransfer);

		//	transaction
			var options = {
				series: [{
					name: 'Send Amount',
					data: sendingValues
				},
					{
						name:'Receive Amount',
						data:receivingValues,
					}],

				chart: {
					height: 240,
					width:500,
					type: 'area'
				},
				dataLabels: {
					enabled: false
				},
				title:{
					text:'Send or Received Amount'
				},
				stroke: {
					curve: 'smooth'
				},
				xaxis: {
					type: 'date',
					categories: dateReceiving
				},
				tooltip: {
					x: {
						format: 'dd/MM/yy'
					},
				},
			};

			var chart = new ApexCharts(document.querySelector("#transaction"), options);
			chart.render();

		//	listing chart
			var orderChartData = @json($orderChart);
			var active = orderChartData.activeOrdersCount;
			var complete = orderChartData.completeOrdersCount;
			var cancel = orderChartData.canceledOrdersCount;

			if (active === 0 && complete === 0 && cancel === 0) {
				document.querySelector("#listing_chart").innerHTML = "<h5>No Listing Order data available</h5>";

			} else {
				var options = {
					series: [active, complete, cancel],
					chart: {
						width: 400,
						type: 'donut',
					},
					labels: ["Active ", "Complete", "Cancel"],
					plotOptions: {
						pie: {
							startAngle: -90,
							endAngle: 270
						}
					},
					dataLabels: {
						enabled: false
					},
					fill: {
						type: 'gradient',
					},
					legend: {
						formatter: function (val, opts) {
							return val + " - " + opts.w.globals.series[opts.seriesIndex]
						}
					},
					title: {
						text: 'Listing Order Chart'
					},
					responsive: [{
						breakpoint: 480,
						options: {
							chart: {
								width: 200
							},
							legend: {
								position: 'bottom'
							}
						}
					}]
				};

			var chart = new ApexCharts(document.querySelector("#listing_chart"), options);
			chart.render();
			}
		});
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
											url: "{{ route('user.save.token') }}",
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
					user_foreground: '',
					user_background: '',
					notificationPermission: Notification.permission,
					is_notification_skipped: sessionStorage.getItem('is_notification_skipped') == '1'
				},
				mounted() {
					this.user_foreground = "{{$firebaseNotify->user_foreground}}";
					this.user_background = "{{$firebaseNotify->user_background}}";
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
