<div class="row">
	<div class="col-md-3">
		<div class="form-group">
			<input placeholder="@lang('Title')" name="title" value="{{ isset($search['title']) ? $search['title'] : '' }}" type="text" class="form-control form-control-sm">
		</div>
	</div>

	<div class="col-md-2">
		<div class="form-group">
			<select name="category" class="form-control">
				<option value="">@lang('Categories')</option>
				@foreach($categories as $category)
					<option value="{{$category->id}}">{{optional($category->details)->name}}</option>
				@endforeach
			</select>
		</div>
	</div>
	<div class="col-md-3">
		<div class="form-group">
			<select name="subcategory" class="form-control">
				<option value="">@lang('Subcategories')</option>
				@foreach($subcategories as $subcategory)
					<option value="{{$subcategory->id}}">{{$subcategory->details->name }}</option>
				@endforeach
			</select>
		</div>
	</div>

	<div class="col-md-2">
		<div class="form-group search-currency-dropdown">
			<select name="status" class="form-control form-control-sm">
				<option value="">@lang('All Status')</option>
				<option value="0" {{ isset($search['status']) && $search['status'] == '0' ? 'selected' : '' }}>@lang('Pending')</option>
				<option value="1" {{ isset($search['status']) && $search['status'] == '1' ? 'selected' : '' }}>@lang('Accepted')</option>
				
			</select>
		</div>
	</div>
	<div class="col-md-2">
		<div class="form-group">
			<button type="submit" class="btn btn-primary btn-sm btn-block"><i
				class="fas fa-search"></i> @lang('Search')</button>
		</div>
	</div>
</div>
