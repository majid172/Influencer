@extends($theme.'layouts.user')
@section('title', trans('Message'))
@section('content')

	<div class="col-xl-9 col-lg-8 col-md-6" id="messenger" v-cloak>
		<div class="dashboard-content">
			<div class="dashboard-title">
				<h5>@lang('MESSAGES')</h5>
			</div>
			<div class="message-wrapper">
				<div class="row g-md-0">

					<div class="col-md-4">
						<div class="messages-box">
							<div
								:class="(contact.id === selectedContactId) ? 'new message' : 'message'"
								v-if="contacts"
								v-for="contact in contacts"
								@click="selectContact(contact)"
							>
								<div
									:class="(onlineFriends.find(user=>user.id===contact.id)) ? 'active img-box position-relative' : 'img-box position-relative'">
									<img :src="contact.image" class="img-fluid"/>
									<span
										class="unread v-cloak position-absolute top-0 start-100 translate-middle badge rounded-pill bg-info"
										v-if="contact.unread"
									>
									@{{ contact.unread }}
								</span>
								</div>

								<div class="text-box">
									<a href="javascript:void(0)">
										<p class="name" v-cloak>
											@{{ `${contact.name}` }}
											<span class="time"
												  v-if="onlineFriends.find(user=>user.id === contact.id) && contact.chat_last_seen != null"
												  v-cloak></span>
											<span class="time" v-else v-cloak>
											@{{ contact.chat_last_seen }}
										</span>
										</p>
										<p v-if="contact.chat_last_message.message == null" v-cloak>
											@lang('Sent an image')
										</p>
										<p v-else v-cloak>@{{ contact.chat_last_message.message }}</p>
									</a>
								</div>
							</div>
							<div class="message justify-content-center"
								 v-if="contacts.length === 0">
								<p class="py-5 text-danger font14">@lang('No member available for chat.')</p>
							</div>
						</div>
					</div>

					<div class="col-md-8" @mousedown="selectContact(selectedContact)">
						<div class="inbox-wrapper">
							<!-- top bar -->
							<div class="top-bar" v-if="selectedContact">
								<div>
									<img class="user img-fluid" :src="selectedContact.image"/>
									<span class="name" v-cloak>@{{ `${selectedContact.name}` }}</span>
								</div>
								<div>
									<button class="info-btn" id="infoBtn">
										<i class="fal fa-info-circle"></i>
									</button>
								</div>
							</div>
							<div class="top-bar" v-if="selectedContact == null">
								<div>
									<button class="info-btn">
										<i class="fas fa-comments-alt"></i>
									</button>
									<span
										class="name">{{config('basic.site_title')}} @lang('Messenger')</span>
								</div>
							</div>

							<!-- chats -->
							<div class="chats" v-if="selectedContact">
								<div v-for="message in messages"
									 :class="`${message.receiver_id == selectedContactId ? 'chat-box this-side' : 'chat-box opposite-side'}`"
									 :key="message.id"
								>
									<div
										class="img"
										v-if="message.receiver_id != selectedContactId"
									>
										<img
											class="img-fluid"
											:src="message.sender_image"
										/>
									</div>

									<div class="text-wrapper">
										<div class="text" v-if="message.message">
											<p v-cloak>@{{ message.message }}</p>
										</div>
										<div class="fileimg" v-if="message.fileImage">
											<a :href="message.fileImage" data-fancybox="gallery">
												<img :src="message.fileImage" width="50px" height="50px">
											</a>
										</div>
										<span class="time" v-cloak>@{{ message.sent_at }}</span>
									</div>
									<div class="img"
										 v-if="message.receiver_id == selectedContactId">
										<img
											class="img-fluid"
											:src="message.sender_image"
										/>
									</div>
								</div>


								<div v-if="typingFriend.fullname" class="typing-show">
									<div class="img">
										<img class="img-fluid" :src="selectedContact.image"
										/>
										<div class="typing is-typing-active is-typing-init">
											<span class="typing__bullet"></span>
											<span class="typing__bullet"></span>
											<span class="typing__bullet"></span>
										</div>
									</div>
								</div>
							</div>
							<div class="chats d-flex justify-content-center align-items-center"
								 v-if="selectedContact == null">
								<div class="chat-box text-danger font14">
									@lang('Please select a member to chat.')
								</div>
							</div>

							<div class="typing-area" v-if="selectedContact">

								<div class="img-preview" v-if="file.name">
									<button class="delete" @click="removeImage">
										<i class="fal fa-times"></i>
									</button>
									<img
										id="attachment"
										:src="photo"
										class="img-fluid"
									/>
									<div class="img-info">
										<span class="name" v-cloak>@{{file.name}}</span>
										<br/>
										<span class="size"
											  v-cloak>@{{parseFloat(file.size/1024).toFixed(2)}} @lang('KB')</span>
									</div>
								</div>

								<div class="input-group">
									<div>
										<button
											class="upload-img send-file-btn"
										>
											<i class="fal fa-paperclip text-white me-2"></i>
											<input class="form-control"
												   id="upload"
												   accept="image/*"
												   type="file"
												   @change="handleFileUpload( $event )"
											/>
										</button>
										<span class="text-danger file"></span>
									</div>
									<textarea
										v-model="message"
										@keydown.enter.prevent="sendMessage"
										
										@mousedown="selectContact(selectedContact)"
										cols="30" rows="10"
										class="form-control"
										placeholder="@lang('Type your message...')"></textarea>
									<button @click="sendMessage" class="submit-btn text-white">
										<i class="fal fa-paper-plane"></i>
									</button>
								</div>
								<small class="text-danger" v-if="errors.file" v-cloak>@{{ errors.file[0] }}</small>
							</div>


							<div class="side-profile" id="sideProfile" v-if="selectedContact">
								<button id="closeProfile">
									<i class="fal fa-times"></i>
								</button>
								<div class="img-box">
									<img
										class="img-fluid"
										:src="selectedContact.image"
									/>
								</div>
								<div class="mb-4">
									<h5 v-cloak>@{{ `${selectedContact.name}` }}</h5>
									<p v-cloak>@lang('Age'): @{{ `${selectedContact.age}` }}</p>
									<p v-cloak>@lang('height'): @{{ selectedContact.height }} @lang('feet')</p>
									<p v-cloak>@lang('Mother Tongue'): @{{ selectedContact.mother_tongue }}</p>
								</div>
								<a :href="gotoProfile" @click="viewProfile(selectedContact.id)" target="_blank">
									<button class="btn-flower2">
										@lang('view full profile')
									</button>
								</a>
							</div>

							<audio id="myAudio">
								<source src="{{asset('assets/global/sound.mp3')}}" type="audio/mpeg">
							</audio>

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

@endsection
@push('scripts')
	 <script src="{{asset('assets/global/js/laravel-echo.common.min.js')}}"></script>
	<script>
		"use strict";

		let messenger = new Vue({
			el: "#messenger",
			data: {
				contacts: [],
				selectedContactId: 0,
				selectedContact: null,
				messages: [],
				message: '',
				file: '',
				photo: '',
				myProfile: [],
				gotoProfile: '',
				onlineFriends: [],
				typingFriend: {},
				typingClock: null,
				errors: {},
			},
			mounted() {
				this.wsConnection();
				this.contact();
				this.listenUser();
				this.checkActiveInactive();
				let contact = JSON.parse(sessionStorage.getItem('currentChatBox'));
				if (contact) {
					this.selectContact(contact);
				}
			},
			watch: {
				contact(contact) {
					this.scrollToBottom();
				},
				messages(messages) {
					this.scrollToBottom();
				}
			},
			methods: {
				handleFileUpload(event) {
					if (event.target.files[0].size > 3145728) {
						Notiflix.Notify.Failure("@lang('Image should be less than 3MB!')");
					} else {
						this.file = event.target.files[0];
						this.photo = URL.createObjectURL(event.target.files[0]);
					}
				},
				removeImage() {
					this.file = '';
					this.photo = '';
				},
				contact() {
					axios.get("{{ route('user.chat.contact') }}")
						.then(response => {
							this.contacts = response.data;
						});
				},
				selectContact(contact) {
					this.deletePushNotification(contact.id);
					this.updateUnreadCount(contact.id, 1);
					axios.get('single/member/messages/' + contact.id)
						.then(response => {
							this.selectedContact = contact;
							this.myProfile = response.data[response.data.length - 1];
							this.selectedContactId = contact.id;
							this.messages = response.data.filter(ownProfile => ownProfile.id !== this.myProfile.id);

							sessionStorage.setItem('currentChatBox', JSON.stringify(contact));
						});
				},
				deletePushNotification(id) {
					axios.post('delete/pushnotification/' + id)
						.then(response => {
						});
				},
				viewProfile(id) {
					let profileLink = '{{route('user.member.profile.show','userId')}}'
					profileLink = profileLink.replace(/\/[^\/]*$/, '/' + id)
					this.gotoProfile = profileLink;
				},
				sendMessage() {
					var _this = this;
					if (this.message === '' && this.file === '') {
						Notiflix.Notify.Failure("@lang('Can\'t send empty message')");
						return;
					}
					let formData = new FormData();
					formData.append('file', this.file);
					formData.append('message', this.message);
					formData.append('receiver_id', this.selectedContactId);

					const headers = {'Content-Type': 'multipart/form-data'};
					axios.post("{{route('user.chat.send-message')}}", formData, {headers})
						.then(function (res) {
							_this.message = '';
							_this.file = '';
							_this.messages.push(res.data);
							_this.updateUnreadCount(res.data.receiver_id, null, res.data);
							_this.contact();
						})
						.catch(error => this.errors = error.response.data.errors);
				},
				scrollToBottom() {
					setTimeout(() => {
						let messagesContainer = this.$el.querySelector(".chats");
						messagesContainer.scrollTop = messagesContainer.scrollHeight;
					}, 10);
				},
				wsConnection() {
					window.Echo = new Echo({
						broadcaster: 'pusher',
						key: '{{ config("broadcasting.connections.pusher.key") }}',
						cluster: '{{ config("broadcasting.connections.pusher.options.cluster") }}',
						forceTLS: true,
						authEndpoint: '{{ url('/') }}/broadcasting/auth'
					});
				},
				listenUser() {
					let _this = this;
					window.Echo.private('user.chat.{{ auth()->id() }}')
						.listen('ChatEvent', (e) => {
							if (e.message.sender_id == _this.selectedContactId) {
								_this.messages.push(e.message);
							}
							_this.updateUnreadCount(e.message.sender_id, 0, e.message);
							_this.contact();
							var x = document.getElementById("myAudio");
							x.play();
						})
						.listenForWhisper('typing', (e) => {
							if (e.user.id == this.selectedContactId) {
								this.typingFriend = e.user;
								this.scrollToBottom();
								if (this.typingClock) clearTimeout();
								this.typingClock = setTimeout(() => {
									this.typingFriend = {};
								}, 5000);
							}
						});
				},
				checkActiveInactive() {
					Echo.join('user.activeInactive')
						.here((users) => {
							this.onlineFriends = users;
						})
						.joining((user) => {
							this.onlineFriends.push(user);
						})
						.leaving((user) => {
							this.onlineFriends.splice(this.onlineFriends.indexOf(user), 1);
							axios.put('chat/leaving/time/' + user.id)
								.then(response => {
									this.contact();
								});
						});
				},
				onTyping() {
					Echo.private('user.chat.' + this.selectedContactId).whisper('typing', {
						user: this.myProfile
					});
				},
				updateUnreadCount(contactId, reset, lastSentMessage = null) {
					this.contacts = this.contacts.map((single) => {
						if (single.id == contactId) {
							if (lastSentMessage != null) {
								if (lastSentMessage.fileImage != null) {
									single.chat_last_message.message = "@lang('Sent an image')";
								} else {
									single.chat_last_message.message = lastSentMessage.message;
								}
							}
							check(reset);
							return single;
						}

						function check(reset = null) {
							if (reset == 1) {
								single.unread = 0;
							} else if (reset == 0) {
								single.unread = single.unread + 1;
							}
						}

						return single;
					})
				}
			}
		});


		$(document).on('click', '#infoBtn', function () {
			document.getElementById("sideProfile").classList.toggle("active");
		})
		$(document).on('click', '#closeProfile', function () {
			document.getElementById("sideProfile").classList.toggle("active");
		})

	</script>
@endpush
