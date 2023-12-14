@extends('admin.layouts.master')
@section('page_title',__('Listing list'))

@section('content')
	<div class="main-content">
		<section class="section">
			<div class="section-header">
				<h1>@lang('Listing List')</h1>
				<div class="section-header-breadcrumb">
					<div class="breadcrumb-item active">
						<a href="{{route('admin.home')}}">@lang('Dashboard')</a>
					</div>
					<div class="breadcrumb-item">@lang('Listing List')</div>
				</div>
			</div>

			<div class="row">
				<div class="container-fluid" id="container-wrapper">
					<div class="row">
						<div class="col-lg-12">
							<div class="card mb-4 card-primary shadow-sm">
								<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
									<h6 class="m-0 font-weight-bold text-primary">@lang('Search')</h6>
								</div>
								<div class="card-body">
									<form action="{{ route('admin.listing.search') }}" method="get">
										@include('admin.listing.searchForm')
									</form>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-12">
							<div class="card card-primary shadow">
								<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
									<h6 class="m-0 font-weight-bold text-primary">@lang('Lisatings List')</h6>
		
								</div>
		
								<div class="card-body">
									<div class="table-responsive">
										<table class="table table-striped table-hover align-items-center ">
											<thead>
											<tr>
												<th>@lang('SL')</th>
												<th>@lang('Title')</th>
												<th>@lang('Influencer')</th>
												<th>@lang('Category')</th>
												<th>@lang('SubCategory')</th>
												<th>@lang('Status')</th>
												<th>@lang('Action')</th>
											</tr>
											</thead>
											<tbody>
											@forelse($lists as $key => $list)
												<tr>
													<td data-label="@lang('SL')">{{++$key}}</td>
													<td data-label="@lang('Title')">{{Str::limit($list->title,30)}}</td>
													<td data-label="@lang('Influencer')">
														<a href="{{ route('user.edit', $list->user_id)}}"
															class="text-decoration-none">
															 <div class="d-lg-flex d-block align-items-center ">
																 <div class="rounded-circle mr-2 w-40px" >
																	 {!! optional($list->user)->profilePicture() !!}
																 </div>
																 <div class="d-inline-flex d-lg-block align-items-center">
																	 <p class="text-dark mb-0 font-16 font-weight-medium">{{Str::limit(optional($list->user)->name?? __('N/A'),20)}}</p>
																	 <span
																		 class="text-muted font-14 ml-1">{{ '@'.optional($list->user)->username?? __('N/A')}}</span>
																 </div>
															 </div>
														 </a>
														
													<td data-label="@lang('Category')">{{__(optional(optional($list->category)->details)->name)}}</td>
													<td data-label="@lang('SubCategory')">{{__(optional(optional($list->subCategory)->details)->name)}}</td>
		
													<td data-label="@lang('Status')">
														@if($list->status == 0)
															<span class="badge badge-primary">@lang('Inactive')</span>
														@elseif($list->status == 1)
															<span class="badge badge-success">@lang('Active')</span>
														@endif
													</td>
													<td data-label="@lang('Action')">
														<button type="button" class="btn btn-sm btn-outline-primary details" data-toggle="modal" data-target="#exampleModal"data-title="{{__($list->title)}}" data-influencer="{{__($list->user->name)}}" data-category="{{__(optional(optional($list->category)->details)->name)}}" data-subcategory="{{__(optional(optional($list->subcategory)->details)->name)}}" data-package="{{json_encode($list->package)}}" data-extra_services="{{json_encode($list->extra_services)}}" data-requirement_ques="{{json_encode($list->requirement_ques)}}" data-tag="{{(json_encode($list->tag))}}" data-description="{{strip_tags($list->description) }}" >
															<i class="fas fa-eye pr-1"></i>@lang('Details')
														</button>
		
														@if($list->status == 0)
															<button type="button"  class=" btn btn-sm btn-outline-success approve" data-toggle="modal" data-target="#approveModal" data-route="{{route('admin.listing.approve',$list->id)}}">
																<i class="fas fa-toggle-on pr-1"></i>@lang('Active')
															</button>
														@else
															<button type="button"  class="btn btn-sm btn-outline-danger cancel" data-toggle="modal" data-target="#approveModal" data-route="{{route('admin.listing.approve',$list->id)}}">
																<i class="fas fa-toggle-off pr-1"></i>@lang('Inactive')
															</button>
														@endif
		
		
													</td>
												</tr>
											@empty
												<tr>
													<th colspan="100%" class="text-center">
														<img src="{{asset('assets/global/no-data.png')}}" alt="@lang('no-data')" class="no-data-img">
														<br>
														@lang('No data found')</th>
												</tr>
		
											@endforelse
											</tbody>
										</table>
									</div>
		
									<div class="card-footer">
										{{ $lists->links() }}
									</div>
								</div>
		
							</div>
						</div>
					</div>
				</div>
			</div>

		</section>
	</div>

	<div class="modal fade" id="approveModal" tabindex="-1" role="dialog" aria-labelledby="approveModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="approveModalLabel">@lang('Listing action')</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form action="" method="post" class="route">
					@csrf

					<div class="modal-body">
						<p>@lang('Are you want to approve ?')</p>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('No')</button>
						<button type="submit" class="btn btn-primary">@lang('Yes')</button>
					</div>
				</form>

			</div>
		</div>
	</div>

	{{-- Details  modal --}}
	<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
		  <div class="modal-content">
			<div class="modal-header">
			  <h5 class="modal-title text-primary" id="exampleModalLabel" > @lang('Details ')</h5>
			  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			  </button>
			</div>
			<div class="modal-body ">
				<ul class="list-group list-group-flush">
					<li class="list-group-item d-flex justify-content-between flex-wrap">
						<span class="font-weight-bold">@lang('Title')</span>
						<span class="title"></span>
					</li>
					<li class="list-group-item d-flex justify-content-between flex-wrap">
						<span class="font-weight-bold">@lang('Category')</span>
						<span class="category"></span>
					</li>
					<li class="list-group-item d-flex justify-content-between flex-wrap">
						<span class="font-weight-bold">@lang('SubCategory')</span>
						<span class="subCategory"></span>
					</li>
					<li class="list-group-item d-flex justify-content-between flex-wrap">
						<span class="font-weight-bold">@lang('Packages')</span>
						<ol class="package"></ol>
					</li>
					<li class="list-group-item d-flex justify-content-between flex-wrap">
						<span class="font-weight-bold">@lang('Extra Services')</span>
						<ul class="services"></ul>
					</li>
					<li class="list-group-item d-flex justify-content-between flex-wrap">
						<span class="font-weight-bold">@lang('Requirements')</span>
						<ul class="requirement"></ul>
					</li>
					<li class="list-group-item d-flex justify-content-between flex-wrap">
						<span class="font-weight-bold">@lang('Tags')</span>
						<span class="tags"></span>
					</li>
					<li class="list-group-item d-flex justify-content-between flex-wrap">
						<span class="font-weight-bold">@lang('Description')</span>
						<span class="description"></span>
					</li>

				  </ul>
			</div>
			<div class="modal-footer">
			  <button type="button" class="btn btn-primary" data-dismiss="modal">@lang('Close')</button>

			</div>
		  </div>
		</div>
	  </div>
@endsection

@section('scripts')
	<script>
		'use strict'
		$(document).ready(function () {
			$('.approve').on('click',function(){
				let url = $(this).data('route');
				$('.route').attr('action',url);

			});
			$('.cancel').on('click',function (){
				let url = $(this).data('route');
				$('.route').attr('action',url);
			});
		});

		$('.details').on('click',function(){
			let title = $(this).data('title');
			let packages = $(this).data('package');
			let extra_services = $(this).data('extra_services');
			let requirement_ques = $(this).data('requirement_ques');
			let tags = $(this).data('tag');

			let modal = $('#exampleModal');
			let packageHtml = modal.find('.package');
			let extraServiceHtml = modal.find('.services');
			let requirementsHtml = modal.find('.requirement');

			//clear previous data
			packageHtml.empty();
			extraServiceHtml.empty();
			requirementsHtml.empty();

			$.each(packages, function (key,pack){
				$('<li>').text(pack.package_name + " " + "(Revision : " + pack.revision + ", Delivery : " + pack.delivery + " days" + ", Price : "+ pack.package_price + " USD )" ).appendTo(packageHtml);
			});

			$.each(extra_services,function (key,service){
				$('<li>').text("Extra Service: " + service.extra_title).appendTo(extraServiceHtml);
				$('<li>').text("Ex. Service Price: " + " $"+service.extra_price ).appendTo(extraServiceHtml);
			});
			$.each(requirement_ques,function (key,req){
				$('<li>').text(req.requirementsQues ).appendTo(requirementsHtml);
			})

			modal.find('.title').text(title);
			modal.find('.category').text($(this).attr('data-category'));
			modal.find('.subCategory').text($(this).attr('data-subCategory'));
			modal.find('.tags').text(tags);
			modal.find('.description').text($(this).data('description'));

		});
	</script>
@endsection
