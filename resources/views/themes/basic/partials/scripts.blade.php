<script src="{{asset($themeTrue.'js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset($themeTrue.'js/jquery-3.6.0.min.js')}}"></script>
<script src="{{asset($themeTrue.'js/owl.carousel.min.js')}}"></script>
<script src="{{asset($themeTrue.'js/select2.min.js')}}"></script>
<script src="{{asset($themeTrue.'js/socialSharing.js')}}"></script>
<script src="{{asset($themeTrue.'js/range-slider.min.js')}}"></script>

@stack('extra-js')

<script src="{{asset('assets/global/js/notiflix-aio-2.7.0.min.js')}}"></script>
<script src="{{asset('assets/global/js/pusher.min.js')}}"></script>
<script src="{{asset('assets/global/js/vue.min.js')}}"></script>
<script src="{{asset('assets/global/js/axios.min.js')}}"></script>

<script src="{{asset($themeTrue.'js/script.js')}}"></script>

@stack('scripts')
@auth
<script>
	'use strict';
	window.Laravel = <?php echo json_encode([
		'csrfToken' => csrf_token(),
	]); ?>;
	var module = {};

	let pushNotificationArea = new Vue({
		el: "#pushNotificationArea",
		data: {
			items: [],
		},
		mounted() {
			this.getNotifications();
			this.pushNewItem();
		},
		methods: {
			getNotifications() {
				let app = this;
				axios.get("{{ route('push.notification.show') }}")
					.then(function (res) {
						app.items = res.data;
					})
			},
			readAt(id, link) {
				let app = this;
				let url = "{{ route('push.notification.readAt', 0) }}";
				url = url.replace(/.$/, id);
				axios.get(url)
					.then(function (res) {
						if (res.status) {
							app.getNotifications();
							if (link != '#') {
								window.location.href = link
							}
						}
					})
			},
			readAll() {
				let app = this;
				let url = "{{ route('push.notification.readAll') }}";
				axios.get(url)
					.then(function (res) {
						if (res.status) {
							app.items = [];
						}
					})
			},
			pushNewItem() {
				let app = this;
				// Pusher.logToConsole = true;
				let pusher = new Pusher("{{ env('PUSHER_APP_KEY') }}", {
					encrypted: true,
					cluster: "{{ env('PUSHER_APP_CLUSTER') }}"
				});
				let channel = pusher.subscribe('user-notification.' + "{{ Auth::id() }}");
				channel.bind('App\\Events\\UserNotification', function (data) {
					app.items.unshift(data.message);
				});
				channel.bind('App\\Events\\UpdateUserNotification', function (data) {
					app.getNotifications();
				});
			}
		}
	});
</script>

@endauth
@include('plugins')

@stack('extra_scripts')

