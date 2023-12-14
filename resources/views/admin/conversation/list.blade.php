@extends('admin.layouts.master')
@section('page_title',__('Listing Order list'))

@section('content')
	<div class="main-content">
		<section class="section">
			<div class="section-header">
				<h1>@lang('Listing Order List')</h1>
				<div class="section-header-breadcrumb">
					<div class="breadcrumb-item active">
						<a href="{{route('admin.home')}}">@lang('Dashboard')</a>
					</div>
					<div class="breadcrumb-item">@lang('Listing Order List')</div>
				</div>
			</div>

			<div class="row mb-3">
				<div class="container-fluid" id="container-wrapper">
					<div class="row">
						<div class="col-lg-12">
							<div class="card mb-4 card-primary shadow-sm">
								<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
									<h6 class="m-0 font-weight-bold text-primary">@lang('Search')</h6>
								</div>
								<div class="card-body">
									<form action="{{ route('admin.listing.order.search') }}" method="get">
										@include('admin.listing.order.searchForm')
									</form>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-12">
							<div class="card card-primary shadow">
								<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
									<h6 class="m-0 font-weight-bold text-primary">@lang('Conversation List')</h6>

								</div>

								<div class="card-body">
									<div class="table-responsive">
										<table class="table table-striped table-hover align-items-center ">

										</table>
									</div>

									<div class="card-footer">

									</div>
								</div>

							</div>
						</div>
					</div>
				</div>
			</div>



		</section>
	</div>

	{{--	remove listing order --}}
	<div class="modal fade" id="removeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">@lang('Remove order from list')</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form action="{{route('admin.listing.order.remove')}}" method="post">
					@csrf
					<div class="modal-body">
						<input type="hidden" name="id">
						<p>@lang('Are you want to remove this order?')</p>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('No')</button>
						<button type="submit" class="btn btn-primary">@lang('Yes')</button>
					</div>
				</form>
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
			$('.remove').on('click',function (){
				let modal = $('#removeModal');
				modal.find('input[name="id"]').val($(this).data('id'));
			});
		});
	</script>
@endsection
