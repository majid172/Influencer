@extends($theme.'layouts.user')
@section('title',__('Job List'))
@section('content')

<div class="col-xl-9 col-lg-8 col-md-12">
	<div class="row g-4">
		<div class="col-lg-12">
			<div class="card-box p-0">
				<div class="row align-items-end">
					<div class="col-lg-7">
						<div class="p-4">
							<h5 class="text-primary">@lang('Welcome') @lang(auth()->user()->name)! 🎉</h5>
							<a href="{{route('user.job.create')}}" class="btn-custom">@lang('Create Job')</a>

						</div>
					</div>
					<div class="col-lg-5 text-center text-sm-left d-none d-lg-block">
						<div class="text-right">
							<img src="{{asset($themeTrue.'images/dashboard-man-with-pc.png')}}"
								height="140" alt="View Badge User"
								data-app-dark-img="{{asset($themeTrue.'images/dashboard-man-with-pc.png')}}"
								data-app-light-img="{{asset($themeTrue.'images/dashboard-man-with-pc.png')}}" />
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-12">

				<div class="table-parent table-responsive">
					<table class="table  table table-striped" id="offers" >
						<thead>
						<th>@lang('Title')</th>
						<th>@lang('Proposals')</th>
						<th>@lang('Hired')</th>
						<th>@lang('Action')</th>
						</thead>
						<tbody>
						@forelse($joblists as $item)
							<tr>
								<td data-label="@lang('Title')"><a href="{{route('user.jobs.details',[slug($item->title),$item->id])}}" class="job-title text-primary">{{Str::limit($item->title,30)}}</a></td>
								<td data-label="@lang('Proposals')">{{$item->total_proposal}}</td>
								<td data-label="@lang('Hired')">{{$item->hire->count()}}</td>
								<td data-label="@lang('Action')">
									<a href="{{route('user.proposal.list',$item->id)}}" class="btn-action text-light" type="button" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="@lang('View all job proposal lists.')"><i class="fa-regular fa-eye me-2" id="icon"></i>@lang('Proposal')</a>

									<a href="{{route('user.job.send.invite',$item->id)}}" class="btn-action text-light"  type="button" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="@lang('Send invitation all influencers for your job.')"><i class="fa-solid fa-share me-2" id="icon"></i>@lang('Invite')</a>
								</td>
							</tr>
						@empty
							<tr>
								<th colspan="100%" class="text-center">
									<img src="{{asset($themeTrue.'images/no-data.png')}}" alt="@lang('no-data')" class="no-data-img"> <br>
									@lang('No data found')</th>
							</tr>
						@endforelse
						</tbody>
					</table>
				</div>

				<div class="">
					{{ $joblists->links() }}
				</div>

			</div>
	</div>
</div>


@endsection

