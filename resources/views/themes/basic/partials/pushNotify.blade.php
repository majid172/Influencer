<div class="notification-panel" id="pushNotificationArea">
	<button class="dropdown-toggle">
		<i class="fal fa-bell"></i>
		<span class="count" v-cloak>@{{items.length}}</span>
	</button>
	<ul class="notification-dropdown">
        <div class="dropdown-box" v-if="items.length > 0">
			<li>
				<a v-for="(item, index) in items" @click.prevent="readAt(item.id, item.description.link)" class="dropdown-item" href="javascript:void(0)">
					<i class="fal fa-bell"></i>
					<div class="text">
						<p v-cloak v-html="item.description.text"></p>
						<span class="time" v-cloak>@{{ item.formatted_date }}</span>
					</div>
				</a>
			</li>
		</div>

        <div class="clear-all fixed-bottom">
            <a href="javascript:void(0)" v-if="items.length == 0">@lang('You have no notifications')</a>
            <a href="javascript:void(0)" v-if="items.length > 0" @click.prevent="readAll">@lang('Clear all')</a>
        </div>
	</ul>
</div>
