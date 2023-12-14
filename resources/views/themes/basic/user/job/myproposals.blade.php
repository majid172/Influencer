@extends($theme.'layouts.user')
@section('title', trans('Job Proposal List'))
@section('content')
	<div class="col-xl-9 col-lg-8 col-md-12 change-password">
		<ul class="nav nav-tabs" id="myTab" role="tablist">
			<li class="nav-item" role="presentation">
				<button class="nav-link {{$activeTab == 'active' ? 'active':''}}" id="active-tab" data-bs-toggle="tab"
						data-bs-target="#active-tab-pane" type="button" role="tab" aria-controls="active-tab-pane"
						aria-selected="true">@lang('Active')</button>
			</li>
			<li class="nav-item" role="presentation">
				<button class="nav-link {{$activeTab == 'archived' ? 'active':''}}" id="archived-tab"
						data-bs-toggle="tab" data-bs-target="#archived-tab-pane" type="button" role="tab"
						aria-controls="archived-tab-pane" aria-selected="false">@lang('Archived')</button>
			</li>

		</ul>

		<div class="tab-content" id="myTabContent">
			<div class="tab-pane fade show active" id="active-tab-pane" role="tabpanel" aria-labelledby="active-tab"
				 tabindex="0">
				<div class="accordion mt-4" id="accordionExample">
					<div class="accordion-item">
						<h2 class="accordion-header" id="headingOne">
							<button class="accordion-button" type="button" data-bs-toggle="collapse"
									data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
								@lang('Offers') ({{$offers->count()}})
							</button>
						</h2>
						<div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"
							 data-bs-parent="#accordionExample">
							<div class="accordion-body">
								<div class=" ">
									<div class="table-parent table-responsive">
										<table class="table  table table-striped w-100" id="offers">
											<thead>
												<th>@lang('Title')</th>
												<th>@lang('Rate')</th>
												<th>@lang('Submit Date')</th>
												<th>@lang('Action')</th>
											</thead>
											<tbody>

											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>


					<div class="accordion-item">
						<h2 class="accordion-header" id="headingThree">
							<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
									data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
								@lang('Interview Invitation') ({{$interviews->count()}})
							</button>
						</h2>
						<div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree"
							 data-bs-parent="#accordionExample">
							<div class="accordion-body">
								<div class="table-parent table-responsive">
									<table class="table  table table-striped" id="interview">
										<thead>
											<th>@lang('Title')</th>
											<th>@lang('Experience')</th>
											<th>@lang('Skills')</th>
											<th>@lang('Details')</th>
										</thead>
										<tbody>

										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
					<div class="accordion-item">
						<h2 class="accordion-header" id="headingFour">
							<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
									data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
								@lang('Submitted Job') ({{$submitted->count()}})
							</button>
						</h2>
						<div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour"
							 data-bs-parent="#accordionExample">
							<div class="accordion-body">
								<div class="table-parent table-responsive">
									<table class="table table-striped" id="submitted">
										<thead>
										<th>@lang('Title')</th>
										<th>@lang('Submit Date')</th>
										<th>@lang('Details')</th>
										</thead>
										<tbody>

										</tbody>

									</table>
								</div>
							</div>
						</div>
					</div>
				</div>

			</div>
			<div class="tab-pane fade" id="archived-tab-pane" role="tabpanel" aria-labelledby="archived-tab"
				 tabindex="0">
				<div class="mt-3">
					<h5>@lang('Archived Proposals') ({{$proposal_count}})</h5>

					<div class="table-parent table-responsive">
						<table class="table table-striped " id="archived">
							<thead>
							<th>@lang('Title')</th>
							<th>@lang('Bid amount')</th>
							<th>@lang('Receive amount')</th>
							<th>@lang('Status')</th>
							<th>@lang('Created at')</th>
							<th>@lang('Action')</th>
							</thead>

							<tbody>

							</tbody>

						</table>
					</div>

				</div>
			</div>

		</div>

	</div>


	<div class="modal fade" id="acceptModal" tabindex="-1" aria-labelledby="acceptModal" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">@lang('Accept the hiring offer')</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<p>@lang('Are you ready to start working on this project?')</p>
				</div>
				<div class="modal-footer">
					<form action="" method="post" class="confirm">
						@csrf
						<button type="submit" class="btn btn-primary">@lang('Accept')</button>
					</form>

				</div>
			</div>
		</div>
	</div>

@endsection

@push('css-lib')
<link rel="stylesheet" href="{{asset($themeTrue.'css/dataTables.bootstrap.min.css')}}">
<link rel="stylesheet" href="{{asset($themeTrue.'css/dataTables_material.css')}}">
<link rel="stylesheet" href="{{asset($themeTrue.'css/material_component.min.css')}}">
@endpush
@push('style')
	<style>
		.mdc-data-table {
			width: 100%;
		}
	</style>
@endpush
@push('scripts')


<script src="{{asset($themeTrue.'js/dataTable.min.js')}}"></script>
<script src="{{asset($themeTrue.'js/dataTables.bootstrap.min.js')}}"></script>
<script src="{{asset($themeTrue.'js/dataTables.material.min.js')}}"></script>

	<script>

		$('#offers').DataTable({
				processing:true,
				serverSide:true,
				ajax:'{{route("job.offers")}}',
				columns:[
					{ data: 'title', name: 'title' },
					{ data: 'rate', name: 'rate' },
					{ data: 'submit_date', name: 'submit_date' },
					{ data: 'accept' , name: 'accept'}
				],
		});


		//	interview invitation pagination
		$('#interview').DataTable({
			processing: true,
			serverSide:true,
			ajax:'{{route("job.interview.invitation")}}',
			columns: [
				{ data:'title',name:'title'},
				{
					data:'experience',name:'experience',
					render: function (data)
					{
						if(data == 1){
							return '@lang("Entry")';
						}
						else if(data == 2)
						{
							return '@lang("Intermidiate")';
						}
						else if(data == 3) {
							return '@lang("Expert")';
						}
					}
				},
				{ data:'skills',name:'skills'},
				{ data:'details_link',name: 'details_link'},

			]
		});

		$('#submitted').DataTable({
			processing: true,
			serverSide: true,
			ajax: '{{route("job.submitted")}}',
			columns: [
				{data:'title', name:'title'},
				{data:'submite_date',name: 'submite_date'},
				{data:'details', name: 'details'},
			]

		});

		$('#archived').DataTable({
			processing: true,
			serverSide: true,
			ajax: '{{route("job.archived")}}',
			columns: [
				{
					data: 'title', name: 'title',
					render: function (data, type, row) {
						const maxLength = 50;
						if (type == 'display' && data.length > maxLength) {
							return data.substr(0, maxLength) + '...';
						}
						return data;
					},
				},
				{ data:'bid_amount',name:'bid_amount'},
				{ data:'receive_amount',name:'receive_amount'},

				{
					data: 'status', name: 'status',
				},
				{data: 'created_at', name: 'created_at'},
				{ data:'details_link',name:'details_link'},
			]
		});
	</script>

	<script>
		$(document).ready(function () { // Ensure the DOM is fully loaded
			$('.accept').click(function () {
				var url = $(this).data('route');
				$('.confirm').attr('action', url);
			});
		});
	</script>
@endpush
