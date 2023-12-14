<div class="row">
	<div class="col-md-3">
		<div class="form-group">
			<input placeholder="@lang('Package')" name="package" value="{{ isset($search['package']) ? $search['package'] : '' }}" type="text" class="form-control form-control-sm">
		</div>
	</div>

	<div class="col-md-3">
		<div class="form-group">
			<input placeholder="@lang('Order Number')" name="order_no" value="{{ isset($search['order_no']) ? $search['order_no'] : '' }}" type="text" class="form-control form-control-sm">
		</div>
	</div>

	<div class="col-md-3">
		<div class="form-group search-currency-dropdown">
			<select name="status" class="form-control form-control-sm">
				<option value="">@lang('All Status')</option>
				<option value="0" {{ isset($search['status']) && $search['status'] == '0' ? 'selected' : '' }}>@lang('Pending')</option>
				<option value="1" {{ isset($search['status']) && $search['status'] == '1' ? 'selected' : '' }}>@lang('Accepted')</option>
				<option value="2" {{ isset($search['status']) && $search['status'] == '2' ? 'selected' : '' }}>@lang('Done')</option>
				<option value="3" {{ isset($search['status']) && $search['status'] == '3' ? 'selected' : '' }}>@lang('Completed')</option>

			</select>
		</div>
	</div>
	<div class="col-md-3">
		<div class="form-group">
			<button type="submit" class="btn btn-primary btn-sm btn-block"><i
				class="fas fa-search"></i> @lang('Search')</button>
		</div>
	</div>
</div>
