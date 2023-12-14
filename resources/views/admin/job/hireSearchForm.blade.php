<div class="row">
	<div class="col-md-2">
		<div class="form-group">
			<input placeholder="@lang('Client ')" name="client" value="" type="text" class="form-control form-control-sm">
		</div>
	</div>

	<div class="col-md-2">
		<div class="form-group">
			<input placeholder="@lang('Proposer')" name="proposer" value="" type="text" class="form-control form-control-sm">
		</div>
	</div>
	<div class="col-md-2">
		<div class="form-group">
			<select name="project_type" class="form-control form-control-sm">
				<option value="">@lang('Project Type')</option>
				<option
					value="1" {{ isset($search['project_type']) && $search['project_type'] == 1 ? 'selected' : '' }}> @lang('Milestone') </option>
				<option
					value="0" {{ isset($search['project_type']) && $search['project_type'] == 0 ? 'selected' : '' }}> @lang('Project Wise') </option>
			</select>
		</div>
	</div>

	<div class="col-md-2">
		<div class="form-group">
			<select name="payment_type" class="form-control form-control-sm">
				<option value="">@lang('Payment Type')</option>
				<option
					value="1" {{ isset($search['payment_type']) && $search['payment_type'] == 1 ? 'selected' : '' }}> @lang('Hourly') </option>
				<option
					value="0" {{ isset($search['payment_type']) && $search['payment_type'] == 0 ? 'selected' : '' }}> @lang('Fixed') </option>
			</select>
		</div>
	</div>


	<div class="col-md-2">
		<div class="form-group">
			<select name="status" class="form-control form-control-sm">
				<option value="">@lang('All Status')</option>
				<option
					value="1" {{ isset($search['status']) && $search['status'] == 1 ? 'selected' : '' }}> @lang('Hired') </option>
				<option
					value="0" {{ isset($search['status']) && $search['status'] == 0 ? 'selected' : '' }}> @lang('Dismissed') </option>
			</select>
		</div>
	</div>


	<div class="col-md-2">
		<div class="form-group">
			<button type="submit" class="btn btn-primary btn-sm btn-block">@lang('Search')</button>
		</div>
	</div>
</div>
