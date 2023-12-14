<div class="row">
	<div class="col-md-3">
		<div class="form-group">
			<input placeholder="@lang('Title ')" name="title" type="text" class="form-control form-control-sm">
		</div>
	</div>
	<div class="col-md-3">
		<div class="form-group">
			<select name="category_id" class="form-control form-control-sm">
				<option value="">@lang('Category Type')</option>
				@foreach($categories as $category)
					<option value="{{$category->id}}" {{ isset($search['category_id']) && $search['category_id'] == $category->id ? 'selected' : ''}}> {{__(optional($category->details)->name)}} </option>
				@endforeach
			</select>
		</div>
	</div>

	<div class="col-md-2">
		<div class="form-group">
				<select name="job_type" class="form-control form-control-sm">
					<option value="">@lang('Job Type')</option>
					<option value="1" > @lang('Hourly') </option>
					<option value="2"> @lang('Project Wise') </option>
				</select>
		</div>
	</div>

	<div class="col-md-2">
		<div class="form-group">
			<select name="status" class="form-control form-control-sm">
				<option value="">@lang('Status')</option>
				<option value="0" > @lang('Pending') </option>
				<option value="1"> @lang('Approve') </option>
				<option value="2"> @lang('Completed') </option>
			</select>
		</div>
	</div>

	<div class="col-md-2">
		<div class="form-group">
			<button type="submit" class="btn btn-primary btn-sm btn-block">@lang('Search')</button>
		</div>
	</div>
</div>
