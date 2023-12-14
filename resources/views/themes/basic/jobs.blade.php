@extends($theme.'layouts.app')
@section('title', trans('Jobs'))
@section('content')
	<section class="job-section">
		<div class="container">
			<div class="row g-lg-5">
				<div class="col-12 d-lg-none mb-3">
					<div class="d-flex justify-content-end">
						<button class="btn-custom-outline d-lg-none" onclick="toggleUserSideBar('jobFilterArea')">
							<i class="fa-light fa-filter"></i>
							@lang("Filter")
						</button>
					</div>
				</div>
				<div class="col-lg-3">
					<div class="filter-area" id="jobFilterArea">
						<button class="btn-custom d-lg-none close-btn bg-danger" onclick="toggleUserSideBar('jobFilterArea')">
							<i class="fa-light fa-times"></i>
							@lang("close")
						</button>
						<div class="accordion-item">
							<h5 class="accordion-header" id="headingOne">
								<button class="accordion-button" type="button" data-bs-toggle="collapse"
										data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
									@lang('Advanced Search')
								</button>

							</h5>

							<div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne">
								<div class="accordion-body">
									<div class="filter-box">
										<div class="row g-3">
											<form>
												<div class="input-box col-12">
													<input type="text" name="searchTerm" id="searchTerm"
														   class="form-control" placeholder="@lang('Title search for jobs')"/>
												</div>

											</form>

											<div class="input-box col-12">
												<select class="js-example-basic-single form-control" name="category_id"
														id="category_id">
													<option value="">@lang('Select a category')</option>
													@foreach ($catagorDetails as $item)
														<option value="{{$item->id}}">{{__($item->name)}}</option>
													@endforeach
												</select>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="accordion-item">
							<h5 class="accordion-header" id="headingTwo">
								<button class="accordion-button" type="button" data-bs-toggle="collapse"
										data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
									@lang('Bid Rate')
								</button>
							</h5>

							<div id="collapseTwo" class="accordion-collapse collapse show" aria-labelledby="headingTwo">
								<div class="accordion-body">
									<div class="filter-box">
										<div class="input-box">
											<input type="hidden" value="{{ $min }}" id="minRange">
											<input type="hidden" value="{{ $max }}" id="maxRange">
											<input type="text" class="js-range-slider" name="my_range" value=""
												   id="range"/>
											<label for="customRange1" class="form-label mt-3"> <span class="highlight">{{ config('basic.currency_symbol') . $min }} - {{ config('basic.currency_symbol') . $max }}</span>
											</label>
										</div>

									</div>
								</div>
							</div>
						</div>
						<div class="accordion-item">
							<h5 class="accordion-header" id="headingThree">
								<button class="accordion-button" type="button" data-bs-toggle="collapse"
										data-bs-target="#collapseThree" aria-expanded="false"
										aria-controls="collapseThree">
									@lang('Experience Level')
								</button>
							</h5>
							<div id="collapseThree" class="accordion-collapse collapse show"
								 aria-labelledby="headingThree">
								<div class="accordion-body">
									<div class="filter-box">
										<div class="check-box">
											<div class="form-check">
												<input class="form-check-input experience" name="experience" type="radio" value="3"
													   id="expert"/>
												<label class="form-check-label" for="expert">@lang('Expert') </label>
											</div>
											<div class="form-check">
												<input class="form-check-input experience" name="experience" type="radio" value="2"
													   id="intermidiate"/>
												<label class="form-check-label"
													   for="intermidiate">@lang('Intermidiate') </label>
											</div>
											<div class="form-check">
												<input class="form-check-input experience" name="experience" type="radio" value="1"
													   id="entry"/>
												<label class="form-check-label" for="entry">@lang('Entry') </label>
											</div>

										</div>
									</div>
								</div>
							</div>
						</div>

						<div class="accordion-item">
							<h5 class="accordion-header" id="headingSeven">
								<button class="accordion-button" type="button" data-bs-toggle="collapse"
										data-bs-target="#collapseSeven" aria-expanded="false"
										aria-controls="collapseSeven">
									@lang('Job Type')
								</button>
							</h5>
							<div id="collapseSeven" class="accordion-collapse collapse show"
								 aria-labelledby="headingSeven">
								<div class="accordion-body">
									<div class="filter-box">
										<div class="check-box">
											<div class="form-check">
												<input class="form-check-input" name="type" type="radio" value="1"
													   id="hourly"/>
												<label class="form-check-label" for="hourly">@lang('Hourly') </label>
											</div>

											<div class="form-check">
												<input class="form-check-input" name="type" type="radio" value="2"
													   id="project"/>
												<label class="form-check-label"
													   for="project">@lang('Project') </label>
											</div>

										</div>

									</div>
								</div>
							</div>
						</div>

					</div>
				</div>
				<div class="col-lg-9">
					<div class="d-md-flex justify-content-between align-items-center top-filter mb-4">
						<div class="result-info">
							<p class="mb-md-0"> {{$job_count}} @lang('Jobs found')</p>
						</div>

					</div>

					<div class="topbar">

						<ul class="nav nav-tabs">
							<li class="nav-item">
								<a class="nav-link {{ collect(request()->segments())->last() == 'job' ? 'active' : '' }}"
								   aria-current="page" href="{{ route('jobs') }}" id="jobs">@lang('Recent Jobs')</a>
							</li>
							<li class="nav-item">
								<a class="nav-link {{ collect(request()->segments())->last() == 'best-matches' ? 'active' : '' }}"
								   href="{{ route('user.best.matches') }}" id="bestmatch">@lang('Best Matches')</a>
							</li>
							<li class="nav-item">
								<a class="nav-link {{ collect(request()->segments())->last() == 'list' ? 'active' : '' }}"
								   href="{{ route('user.save.list') }}" id="saveJob">@lang('Save Jobs')</a>
							</li>
						</ul>
					</div>

					<div id="content"></div>

					@if ($job_count >0)
						<div id="data-wrapper">
							@include($theme.'job_post')
						</div>
					@else
						<div class="job-box text-center">
							<img src="{{asset($themeTrue.'images/no-data.png')}}" alt="@lang('no-data')" class="no-data-img"> <br>
							<p class="text-center">@lang('No jobs found')</p>
						</div>
					@endif

					<!-- Data Loader -->
					<div class="auto-load text-center d-none">
						<svg version="1.1" id="L9" xmlns="http://www.w3.org/2000/svg"
							 xmlns:xlink="http://www.w3.org/1999/xlink"
							 x="0px" y="0px" height="60" viewBox="0 0 100 100" enable-background="new 0 0 0 0"
							 xml:space="preserve">
							<path fill="#000"
								  d="M73,50c0-12.7-10.3-23-23-23S27,37.3,27,50 M30.9,50c0-10.5,8.5-19.1,19.1-19.1S69.1,39.5,69.1,50">
								<animateTransform attributeName="transform" attributeType="XML" type="rotate" dur="1s"
												  from="0 50 50" to="360 50 50" repeatCount="indefinite"/>
							</path>
						</svg>
					</div>
				</div>
			</div>
		</div>

	</section>

@endsection

@push('script')
	<script>

		let min = $('#minRange').val();
		let max = $('#maxRange').val();

		$(".js-range-slider").ionRangeSlider({
			type: "double",
			min: min,
			max: max,
			from: minRange,
			to: maxRange,
			grid: true,
		});

		$('#test').on('click', function () {
			$('#hourly').val(1);
			$('#project').val("");
		})

		$('#test2').on('click', function () {
			$('#project').val(2);
			let hourly = $('#hourly').val("");
		})

		//filtering

		$('#searchTerm,#category_id,#hourly,#project,.experience,#range').on('input change',function (){

			var title = $("#searchTerm").val();
			var category_id = $('#category_id').val();
			var my_range=  $('#range').val();
			var experience = $('input[name = "experience"]:checked').val();
			var type = $('input[name = "type"]:checked').val();

			$.ajax({
				url:'{{route('jobs.search')}}',
				method:'GET',
				data:{
					title:title,
					category_id:category_id,
					my_range:my_range,
					type:type,
					experience:experience,
				},
				success:function (response){
					let jobs = response;
					let cur_symbol = "{{trans($basic->currency_symbol)}}";
					$('#data-wrapper').html('');
					$.each(jobs, function (index, item) {
						let description = item.description.length > 100 ? item.description.slice(0, 300) + '...' : item.description;
						let markup = `<div class="job-box">
                     <a href="${item.title_route}" class="job-title">${item.title}</a>
                     <p>@lang('Experience') - ${item.expr} @lang('level') - @lang('Est. Budget'): ${cur_symbol} ${item.rate} - @lang('Posted') ${item.posted}</p>
                     <p>${description}<a href="${item.title_route}">@lang('more')</a></p>
                     <div>`;

						$.each(item.skill.split(','), function (indexSkill, skill) {

							markup += `<a href="#" class="tag">${skill}</a>`;
						});
						markup += `</div>
                 <div class="bottom-area mt-3">
                     <p>@lang('Proposals'): ${item.total_proposal}</p>
                     <span><i class="fa-solid fa-certificate"></i> Payment Verified</span>
                     <span>
                         <i class="fa-solid fa-location-dot"></i>${item.country}
                     </span>
                 </div>
                 <div class="feedback">
                     <button>
                         <i class="fa-light fa-thumbs-down"></i>
                     </button>
                 </div>
             </div>`;
						$('#data-wrapper').append(markup);
					});

				},

				// errror:function ()
			})
		})
	</script>

	{{-- infinite scroll --}}
	<script>
		var PAGE_ROUTE = "{{ route('jobs') }}";
		var page = 1;

		$(window).scroll(function () {
			if ($(window).scrollTop() + $(window).height() >= $(document).height() - 500) {
				page++;
				infiniteLoadMore(page);
			}
		});

		function infiniteLoadMore(page) {
			$.ajax({
				url: PAGE_ROUTE,
				data: {page: page},
				dataType: "html",
				type: "get",
				beforeSend: function () {
					$('.auto-load').show();
				}
			})
				.done(function (response) {
					let data = JSON.parse(response);
					if (!data.html) {
						$('.auto-load').html('<div class="job-box">We don\'t have more data to display</div>');
						return;
					}

					$('.auto-load').hide();
					$("#data-wrapper").append(data.html);
				})
				.fail(function (jqXHR, textStatus, errorThrown) {
				});
		}
	</script>

@endpush

